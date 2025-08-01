<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDF;

class TestPdfCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation with DomPDF';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PDF generation...');
        
        try {
            // Créer un PDF simple de test
            $pdf = PDF::loadView('emails.order_confirmation', [
                'order' => (object) [
                    'id' => 1,
                    'user' => (object) ['name' => 'Test User', 'email' => 'test@example.com'],
                    'total' => 100.00,
                    'address' => '123 Test Street',
                    'created_at' => now(),
                    'status' => 'en attente',
                    'payment_method' => 'en_ligne',
                    'invoice' => null
                ]
            ]);
            
            // Sauvegarder le PDF
            $pdfPath = storage_path('app/public/test.pdf');
            $pdf->save($pdfPath);
            
            $this->info('✅ PDF généré avec succès !');
            $this->info("Fichier sauvegardé : {$pdfPath}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la génération du PDF:');
            $this->error($e->getMessage());
            return 1;
        }
    }
} 