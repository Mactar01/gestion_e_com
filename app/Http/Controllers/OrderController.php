<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facades\Pdf;
use App\Models\Invoice;
use App\Mail\OrderConfirmationMail;
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
            foreach ($cart as $product_id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            // Paiement simulé (à adapter pour paiement réel)
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => $validated['payment_method'],
                'status' => $validated['payment_method'] === 'en_ligne' ? 'effectue' : 'en_attente',
                'payment_date' => $validated['payment_method'] === 'en_ligne' ? now() : null,
            ]);
            // Génération de la facture PDF
            $order->load('orderItems.product', 'user');
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            $pdf = Pdf::loadView('invoices.pdf', [
                'order' => $order,
                'invoiceNumber' => $invoiceNumber,
            ]);
            $pdfPath = 'invoices/' . $invoiceNumber . '.pdf';
            \Storage::disk('public')->put($pdfPath, $pdf->output());
            Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => $invoiceNumber,
                'pdf_path' => $pdfPath,
            ]);
            DB::commit();
            session()->forget('cart');
            // Envoi de l'email de confirmation de commande
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            return redirect()->route('orders.index')->with('success', 'Commande passée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors du passage de la commande.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('orderItems.product', 'payment');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadInvoice(Order $order)
    {
        $this->authorize('view', $order);
        $invoice = $order->invoice;
        if (!$invoice || !\Storage::disk('public')->exists($invoice->pdf_path)) {
            return back()->with('error', 'Facture non disponible.');
        }
        return response()->download(storage_path('app/public/' . $invoice->pdf_path), $invoice->invoice_number . '.pdf');
    }
}
