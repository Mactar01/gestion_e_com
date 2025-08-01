<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use PDF;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre commande - E-Commerce Premium',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Ajouter la facture PDF si elle existe
        if ($this->order->invoice && \Storage::disk('public')->exists($this->order->invoice->pdf_path)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->order->invoice->pdf_path)
                ->as($this->order->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject('Confirmation de votre commande - E-Commerce Premium')
            ->view('emails.order_confirmation');

        // Ajouter la facture PDF en pièce jointe si elle existe
        if ($this->order->invoice && \Storage::disk('public')->exists($this->order->invoice->pdf_path)) {
            $mail->attach(storage_path('app/public/' . $this->order->invoice->pdf_path), [
                'as' => $this->order->invoice->invoice_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
