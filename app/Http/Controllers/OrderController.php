<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Invoice;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            
            try {
                $pdf = Pdf::loadView('invoices.pdf', [
                    'order' => $order,
                    'invoiceNumber' => $invoiceNumber,
                ]);
                
                // Créer le dossier invoices s'il n'existe pas
                $invoiceDir = 'invoices';
                if (!Storage::disk('public')->exists($invoiceDir)) {
                    Storage::disk('public')->makeDirectory($invoiceDir);
                }
                
                $pdfPath = $invoiceDir . '/' . $invoiceNumber . '.pdf';
                Storage::disk('public')->put($pdfPath, $pdf->output());
                
                // Créer l'enregistrement de facture
                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => $invoiceNumber,
                    'pdf_path' => $pdfPath,
                ]);
                
                Log::info("Facture PDF générée avec succès pour la commande {$order->id}");
                
            } catch (\Exception $pdfError) {
                Log::error("Erreur lors de la génération du PDF pour la commande {$order->id}: " . $pdfError->getMessage());
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
        $this->authorize('view', $order);
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
        $this->authorize('view', $order);
        
        $invoice = $order->invoice;
        
        if (!$invoice) {
            return back()->with('error', 'Aucune facture trouvée pour cette commande.');
        }
        
        if (!Storage::disk('public')->exists($invoice->pdf_path)) {
            Log::error("Fichier PDF manquant: {$invoice->pdf_path}");
            return back()->with('error', 'Le fichier PDF de la facture est introuvable.');
        }
        
        try {
            $filePath = storage_path('app/public/' . $invoice->pdf_path);
            
            if (!file_exists($filePath)) {
                Log::error("Fichier PDF introuvable sur le système: {$filePath}");
                return back()->with('error', 'Le fichier PDF de la facture est introuvable.');
            }
            
            return response()->download($filePath, $invoice->invoice_number . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $invoice->invoice_number . '.pdf"'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Erreur lors du téléchargement de la facture {$invoice->id}: " . $e->getMessage());
            return back()->with('error', 'Erreur lors du téléchargement de la facture.');
        }
    }

    /**
     * Regenerate invoice PDF
     */
    public function regenerateInvoice(Order $order)
    {
        $this->authorize('view', $order);
        
        try {
            $order->load('orderItems.product', 'user');
            
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            
            $pdf = Pdf::loadView('invoices.pdf', [
                'order' => $order,
                'invoiceNumber' => $invoiceNumber,
            ]);
            
            $invoiceDir = 'invoices';
            if (!Storage::disk('public')->exists($invoiceDir)) {
                Storage::disk('public')->makeDirectory($invoiceDir);
            }
            
            $pdfPath = $invoiceDir . '/' . $invoiceNumber . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());
            
            // Mettre à jour ou créer l'enregistrement de facture
            Invoice::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'invoice_number' => $invoiceNumber,
                    'pdf_path' => $pdfPath,
                ]
            );
            
            Log::info("Facture PDF régénérée avec succès pour la commande {$order->id}");
            
            return back()->with('success', 'Facture PDF régénérée avec succès.');
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de la régénération du PDF pour la commande {$order->id}: " . $e->getMessage());
            return back()->with('error', 'Erreur lors de la régénération de la facture PDF.');
        }
    }
}
