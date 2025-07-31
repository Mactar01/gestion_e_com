<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des catégories
        $categories = [
            ['name' => 'Berlines', 'description' => 'Voitures de luxe et confort'],
            ['name' => 'SUV', 'description' => 'Véhicules utilitaires sport'],
            ['name' => 'Citadines', 'description' => 'Voitures compactes pour la ville'],
            ['name' => 'Sportives', 'description' => 'Voitures de performance'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Récupérer les catégories
        $berlines = Category::where('name', 'Berlines')->first();
        $suv = Category::where('name', 'SUV')->first();
        $citadines = Category::where('name', 'Citadines')->first();
        $sportives = Category::where('name', 'Sportives')->first();

        // Créer des produits
        $products = [
            [
                'name' => 'Mercedes Classe C',
                'description' => 'Berline de luxe avec intérieur premium et technologies avancées',
                'price' => 45000,
                'stock' => 5,
                'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=400',
                'category_id' => $berlines->id,
            ],
            [
                'name' => 'BMW X5',
                'description' => 'SUV premium avec conduite sportive et espace généreux',
                'price' => 65000,
                'stock' => 3,
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400',
                'category_id' => $suv->id,
            ],
            [
                'name' => 'Peugeot 208',
                'description' => 'Citadine moderne avec design innovant et économie de carburant',
                'price' => 22000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=400',
                'category_id' => $citadines->id,
            ],
            [
                'name' => 'Porsche 911',
                'description' => 'Voiture de sport légendaire avec performance exceptionnelle',
                'price' => 120000,
                'stock' => 2,
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400',
                'category_id' => $sportives->id,
            ],
            [
                'name' => 'Audi A4',
                'description' => 'Berline allemande avec technologie quattro et finition soignée',
                'price' => 38000,
                'stock' => 6,
                'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=400',
                'category_id' => $berlines->id,
            ],
            [
                'name' => 'Range Rover Sport',
                'description' => 'SUV de luxe avec capacités tout-terrain exceptionnelles',
                'price' => 85000,
                'stock' => 4,
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400',
                'category_id' => $suv->id,
            ],
            [
                'name' => 'Renault Clio',
                'description' => 'Citadine populaire avec excellent rapport qualité-prix',
                'price' => 18000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=400',
                'category_id' => $citadines->id,
            ],
            [
                'name' => 'Ferrari F8',
                'description' => 'Supercar italienne avec design agressif et performance maximale',
                'price' => 250000,
                'stock' => 1,
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400',
                'category_id' => $sportives->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
