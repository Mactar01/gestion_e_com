<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Mail\OrderStatusUpdatedMail;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('paid')) {
            $query->where('paid', $request->paid);
        }
        $orders = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('user', 'orderItems.product', 'payment');
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:en attente,expédiée,livrée,annulée',
            'paid' => 'required|boolean',
        ]);
        $order->status = $validated['status'];
        $order->paid = $validated['paid'];
        $order->save();
        // Mettre à jour le paiement si nécessaire
        if ($order->payment) {
            $order->payment->status = $order->paid ? 'effectue' : 'en_attente';
            $order->payment->payment_date = $order->paid ? now() : null;
            $order->payment->save();
        }
        // Envoi de l'email de notification de changement de statut
        Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
        // Envoi de l'email de confirmation de paiement si payé
        if ($order->paid) {
            Mail::to($order->user->email)->send(new PaymentConfirmationMail($order));
        }
        return redirect()->route('admin.orders.index')->with('success', 'Commande mise à jour.');
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
        $invoice = $order->invoice;
        if (!$invoice || !\Storage::disk('public')->exists($invoice->pdf_path)) {
            return back()->with('error', 'Facture non disponible.');
        }
        return response()->download(storage_path('app/public/' . $invoice->pdf_path), $invoice->invoice_number . '.pdf');
    }
}
