<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Rice;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@rice.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Sample rice items
        $riceItems = [
            ['name' => 'Jasmine Rice',   'price_per_kg' => 55.00,  'stock_quantity_kg' => 200, 'description' => 'Fragrant long-grain rice from Thailand. Perfect for everyday meals.'],
            ['name' => 'Dinorado',        'price_per_kg' => 60.00,  'stock_quantity_kg' => 150, 'description' => 'Premium Philippine heirloom rice with a naturally sweet aroma.'],
            ['name' => 'Brown Rice',      'price_per_kg' => 65.00,  'stock_quantity_kg' => 100, 'description' => 'Whole grain rice, high in fiber and nutrients. Ideal for health-conscious consumers.'],
            ['name' => 'Sinandomeng',     'price_per_kg' => 52.00,  'stock_quantity_kg' => 180, 'description' => 'Popular Philippine variety known for its soft and slightly sweet taste.'],
            ['name' => 'Basmati Rice',    'price_per_kg' => 75.00,  'stock_quantity_kg' => 80,  'description' => 'Long-grain aromatic rice from the Indian subcontinent.'],
            ['name' => 'Black Rice',      'price_per_kg' => 90.00,  'stock_quantity_kg' => 50,  'description' => 'Antioxidant-rich heirloom grain with a nutty flavor.'],
            ['name' => 'NFA Regular',     'price_per_kg' => 42.00,  'stock_quantity_kg' => 300, 'description' => 'Standard government-subsidized rice variety.'],
        ];

        foreach ($riceItems as $item) {
            Rice::firstOrCreate(
                ['name' => $item['name']],
                [
                    'price_per_kg' => $item['price_per_kg'],
                    'stock_quantity_kg' => $item['stock_quantity_kg'],
                    'description' => $item['description']
                ]
            );
        }
    }
}
