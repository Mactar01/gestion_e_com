<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    /**
     * Générer une facture PDF pour une commande
     */
    public function generateInvoice(Order $order): Invoice
    {
        try {
            // Vérifier si une facture existe déjà pour cette commande
            $existingInvoice = Invoice::where('order_id', $order->id)->first();
            if ($existingInvoice) {
                return $existingInvoice;
            }

            $order->load('orderItems.product', 'user');
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            // Générer le PDF
            $pdf = Pdf::loadView('invoices.pdf', [
                'order' => $order,
                'invoiceNumber' => $invoiceNumber
            ]);

            // Configuration du PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'chroot' => realpath(base_path()),
                'enable_font_subsetting' => false,
                'pdf_backend' => 'CPDF',
                'default_media_type' => 'screen',
                'default_paper_size' => 'a4',
                'default_paper_orientation' => 'portrait',
                'dpi' => 96,
                'enable_php' => false,
                'enable_javascript' => true,
                'enable_remote' => true,
                'font_height_ratio' => 1.1,
            ]);

            $fileName = 'invoices/facture-' . $invoiceNumber . '.pdf';

            // S'assurer que le dossier existe
            $directory = dirname(storage_path('app/public/' . $fileName));
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Sauvegarder le PDF
            Storage::disk('public')->put($fileName, $pdf->output());

            // Créer l'enregistrement de facture
            $invoice = Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => $invoiceNumber,
                'pdf_path' => $fileName,
            ]);

            return $invoice;

        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération de facture PDF: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la génération de la facture PDF: ' . $e->getMessage());
        }
    }

    /**
     * Télécharger une facture
     */
    public function downloadInvoice(Invoice $invoice)
    {
        try {
            if (!Storage::disk('public')->exists($invoice->pdf_path)) {
                throw new \Exception('Le fichier de facture est introuvable.');
            }

            $filePath = storage_path('app/public/' . $invoice->pdf_path);
            $fileName = 'facture-' . $invoice->invoice_number . '.pdf';

            return response()->download($filePath, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement de facture: ' . $e->getMessage());
            throw new \Exception('Erreur lors du téléchargement de la facture: ' . $e->getMessage());
        }
    }

    /**
     * Générer et télécharger une facture directement sans sauvegarde
     */
    public function generateAndDownloadInvoice(Order $order)
    {
        try {
            $order->load('orderItems.product', 'user');
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            // Générer le PDF
            $pdf = Pdf::loadView('invoices.pdf', [
                'order' => $order,
                'invoiceNumber' => $invoiceNumber
            ]);

            // Configuration du PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'chroot' => realpath(base_path()),
                'enable_font_subsetting' => false,
                'pdf_backend' => 'CPDF',
                'default_media_type' => 'screen',
                'default_paper_size' => 'a4',
                'default_paper_orientation' => 'portrait',
                'dpi' => 96,
                'enable_php' => false,
                'enable_javascript' => true,
                'enable_remote' => true,
                'font_height_ratio' => 1.1,
            ]);

            $fileName = 'facture-' . $invoiceNumber . '.pdf';

            // Retourner le PDF directement
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Content-Length' => strlen($pdf->output())
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération directe de facture PDF: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la génération de la facture PDF: ' . $e->getMessage());
        }
    }
}
