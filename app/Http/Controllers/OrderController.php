<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\InvoiceService;
use App\Models\Invoice;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderCancellationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderByDesc('created_at')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        return view('orders.create', compact('cart', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:en_ligne,a_la_livraison',
        ]);

        DB::beginTransaction();
        try {
            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => collect($cart)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                }),
                'address' => $validated['address'],
                'status' => 'en attente',
                'payment_method' => $validated['payment_method'],
                'paid' => $validated['payment_method'] === 'en_ligne' ? true : false,
            ]);

            // Créer les éléments de commande
            foreach ($cart as $product_id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Créer le paiement
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => $validated['payment_method'],
                'status' => $validated['payment_method'] === 'en_ligne' ? 'effectue' : 'en_attente',
                'payment_date' => $validated['payment_method'] === 'en_ligne' ? now() : null,
            ]);

            // Charger les relations pour la génération PDF
            $order->load('orderItems.product', 'user');

            // Générer la facture PDF
            try {
                $invoiceService = new InvoiceService();
                $invoice = $invoiceService->generateInvoice($order);
                Log::info("Facture PDF générée avec succès pour la commande {$order->id}");
            } catch (\Exception $e) {
                Log::error("Erreur lors de la génération du PDF pour la commande {$order->id}: " . $e->getMessage());
                // Continuer sans facture PDF
            }

            DB::commit();
            session()->forget('cart');

            // Envoi de l'email de confirmation
            try {
                Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
                Log::info("Email de confirmation envoyé pour la commande {$order->id}");
            } catch (\Exception $emailError) {
                Log::error("Erreur lors de l'envoi de l'email pour la commande {$order->id}: " . $emailError->getMessage());
                // Continuer même si l'email échoue
            }

            return redirect()->route('orders.index')->with('success', 'Commande passée avec succès. Un email de confirmation vous a été envoyé.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la création de la commande: " . $e->getMessage());
            return back()->with('error', 'Erreur lors du passage de la commande. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur peut voir cette commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
        }

        $order->load('orderItems.product', 'payment', 'invoice');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice(Order $order)
    {
        // Vérifier que l'utilisateur peut voir cette commande
        if ($order->user_id !== Auth::id()) {
            Log::error('Tentative d\'accès non autorisé à la facture de la commande: ' . $order->id . ' par l\'utilisateur: ' . Auth::id());
            abort(403, 'Vous n\'êtes pas autorisé à télécharger cette facture.');
        }

        Log::info('Début du téléchargement de facture pour la commande: ' . $order->id . ' par l\'utilisateur: ' . Auth::id());

        try {
            $invoiceService = new InvoiceService();

            // Vérifier si la commande a une facture associée
            $invoice = $order->invoice;
            Log::info('Facture existante: ' . ($invoice ? 'OUI' : 'NON'));

            if (!$invoice) {
                // Essayer de générer et sauvegarder la facture
                Log::info('Génération automatique de facture pour la commande: ' . $order->id);
                try {
                    $invoice = $invoiceService->generateInvoice($order);
                    Log::info('Facture générée avec succès: ' . $invoice->invoice_number);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la génération de facture: ' . $e->getMessage());
                    Log::info('Tentative de génération directe sans sauvegarde...');

                    // En cas d'erreur, utiliser la génération directe
                    return $invoiceService->generateAndDownloadInvoice($order);
                }
            }

            // Vérifier si le fichier existe
            Log::info('Vérification du fichier: ' . $invoice->pdf_path);
            if (!Storage::disk('public')->exists($invoice->pdf_path)) {
                Log::error('Fichier PDF introuvable après génération: ' . $invoice->pdf_path);
                Log::info('Tentative de génération directe sans sauvegarde...');

                // En cas d'erreur, utiliser la génération directe
                return $invoiceService->generateAndDownloadInvoice($order);
            }

            Log::info('Fichier trouvé, génération de la réponse de téléchargement');
            $response = $invoiceService->downloadInvoice($invoice);

            // Log du succès
            Log::info('Facture téléchargée avec succès: ' . $invoice->invoice_number);

            return $response;

        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement de la facture: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            // Dernière tentative avec génération directe
            try {
                Log::info('Tentative de génération directe en cas d\'erreur...');
                return $invoiceService->generateAndDownloadInvoice($order);
            } catch (\Exception $e2) {
                Log::error('Erreur finale lors de la génération directe: ' . $e2->getMessage());
                return back()->with('error', 'Erreur lors du téléchargement de la facture. Veuillez réessayer.');
            }
        }
    }

    /**
     * Annuler une commande
     */
    public function cancel(Order $order)
    {
        // Vérifier que l'utilisateur peut annuler cette commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // Vérifier que la commande peut être annulée
        if (!in_array($order->status, ['en attente', 'en cours de préparation'])) {
            return back()->with('error', 'Cette commande ne peut plus être annulée. Statut actuel : ' . $order->status);
        }

        // Vérifier que la commande n'a pas été payée en ligne (ou rembourser si nécessaire)
        if ($order->paid && $order->payment_method === 'en_ligne') {
            // Ici, vous pourriez ajouter la logique de remboursement
            // Pour l'instant, on empêche l'annulation des commandes payées en ligne
            return back()->with('error', 'Les commandes payées en ligne ne peuvent pas être annulées directement. Veuillez contacter le service client.');
        }

        DB::beginTransaction();
        try {
            // Mettre à jour le statut de la commande
            $order->update(['status' => 'annulée']);

            // Mettre à jour le statut du paiement si il existe
            if ($order->payment) {
                try {
                    $order->payment->update(['status' => 'echoue']);
                } catch (\Exception $e) {
                    Log::warning('Impossible de mettre à jour le statut du paiement: ' . $e->getMessage());
                    // On continue même si la mise à jour du paiement échoue
                }
            }

            // Remettre les produits en stock
            foreach ($order->orderItems as $item) {
                try {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                } catch (\Exception $e) {
                    Log::warning('Impossible de remettre en stock le produit ' . $item->product_id . ': ' . $e->getMessage());
                    // On continue même si la remise en stock échoue
                }
            }

            // Envoyer un email de confirmation d'annulation
            try {
                Mail::to($order->user->email)->send(new OrderCancellationMail($order));
                Log::info('Commande annulée : ' . $order->id . ' par l\'utilisateur ' . Auth::id());
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'email d\'annulation: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Commande annulée avec succès. Les produits ont été remis en stock.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'annulation de la commande: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'annulation de la commande. Veuillez réessayer.');
        }
    }
}
