<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDF;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class TestPdfEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation and email template';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test complet PDF et Email...');
        
        try {
            // Créer les données de test
            $this->info('📝 Création des données de test...');
            
            $user = User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Utilisateur Test',
                    'password' => bcrypt('password'),
                ]
            );
            
            $category = Category::firstOrCreate(
                ['name' => 'Test'],
                ['description' => 'Catégorie de test']
            );
            
            $product = Product::firstOrCreate(
                ['name' => 'Produit Test'],
                [
                    'description' => 'Description du produit test',
                    'price' => 99.99,
                    'stock' => 10,
                    'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=400',
                    'category_id' => $category->id,
                ]
            );
            
            $order = Order::firstOrCreate(
                ['user_id' => $user->id, 'total' => 99.99],
                [
                    'total' => 99.99,
                    'address' => '123 Rue de Test, 75001 Paris',
                    'status' => 'en attente',
                    'payment_method' => 'en_ligne',
                    'paid' => true,
                ]
            );
            
            OrderItem::firstOrCreate(
                ['order_id' => $order->id, 'product_id' => $product->id],
                [
                    'quantity' => 1,
                    'price' => 99.99,
                ]
            );
            
            Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'amount' => 99.99,
                    'payment_method' => 'en_ligne',
                    'status' => 'effectue',
                    'payment_date' => now(),
                ]
            );
            
            $this->info('✅ Données de test créées !');
            
            // Test 1: Génération PDF
            $this->info('📄 Test de génération PDF...');
            
            $order->load('orderItems.product', 'user');
            $invoiceNumber = 'FAC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            
            $pdf = PDF::loadView('invoices.pdf', [
                'order' => $order,
                'invoiceNumber' => $invoiceNumber,
            ]);
            
            $invoiceDir = 'invoices';
            if (!Storage::disk('public')->exists($invoiceDir)) {
                Storage::disk('public')->makeDirectory($invoiceDir);
            }
            
            $pdfPath = $invoiceDir . '/' . $invoiceNumber . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());
            
            Invoice::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'invoice_number' => $invoiceNumber,
                    'pdf_path' => $pdfPath,
                ]
            );
            
            $this->info('✅ PDF généré avec succès !');
            $this->info("📁 Fichier: storage/app/public/{$pdfPath}");
            
            // Test 2: Template Email
            $this->info('📧 Test du template email...');
            
            $emailContent = view('emails.order_confirmation', compact('order'))->render();
            $emailPath = storage_path('app/public/test_email.html');
            file_put_contents($emailPath, $emailContent);
            
            $this->info('✅ Template email généré !');
            $this->info("📁 Fichier: {$emailPath}");
            
            // Test 3: Vérification des fichiers
            $this->info('🔍 Vérification des fichiers...');
            
            if (Storage::disk('public')->exists($pdfPath)) {
                $this->info('✅ Fichier PDF existe');
            } else {
                $this->error('❌ Fichier PDF manquant');
            }
            
            if (file_exists($emailPath)) {
                $this->info('✅ Fichier email existe');
            } else {
                $this->error('❌ Fichier email manquant');
            }
            
            $this->info('');
            $this->info('🎉 Tests terminés avec succès !');
            $this->info('');
            $this->info('📋 Résumé:');
            $this->info("   • Commande ID: {$order->id}");
            $this->info("   • Facture: {$invoiceNumber}");
            $this->info("   • PDF: storage/app/public/{$pdfPath}");
            $this->info("   • Email: {$emailPath}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors des tests:');
            $this->error($e->getMessage());
            return 1;
        }
    }
} 