<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use PDF;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending with a sample order';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Testing email sending to: {$email}");
        
        try {
            // Vérifier s'il y a une commande existante
            $order = Order::with('user', 'orderItems.product', 'invoice')->first();
            
            if (!$order) {
                $this->info('Aucune commande trouvée. Création d\'une commande de test...');
                
                // Créer un utilisateur de test
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => 'Utilisateur Test',
                        'password' => bcrypt('password'),
                    ]
                );
                
                // Créer une catégorie de test
                $category = \App\Models\Category::firstOrCreate(
                    ['name' => 'Test'],
                    [
                        'description' => 'Catégorie de test',
                    ]
                );
                
                // Créer un produit de test
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
                
                // Créer une commande de test
                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => 99.99,
                    'address' => '123 Rue de Test, 75001 Paris',
                    'status' => 'en attente',
                    'payment_method' => 'en_ligne',
                    'paid' => true,
                ]);
                
                // Créer un élément de commande
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => 99.99,
                ]);
                
                // Créer un paiement
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => 99.99,
                    'payment_method' => 'en_ligne',
                    'status' => 'effectue',
                    'payment_date' => now(),
                ]);
                
                // Générer une facture PDF
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
                
                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => $invoiceNumber,
                    'pdf_path' => $pdfPath,
                ]);
                
                $this->info('Commande de test créée avec succès !');
            }
            
            // Charger les relations
            $order->load('user', 'orderItems.product', 'invoice');
            
            // Envoyer l'email de test
            Mail::to($email)->send(new OrderConfirmationMail($order));
            
            $this->info('✅ Email envoyé avec succès !');
            $this->info("Email envoyé à: {$email}");
            $this->info("Commande ID: {$order->id}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi de l\'email:');
            $this->error($e->getMessage());
            return 1;
        }
    }
} 