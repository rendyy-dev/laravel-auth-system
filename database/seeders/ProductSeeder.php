<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Laptop Lenovo',
            'sku' => 'LTP-001',
            'stock' => 10,
            'price' => 12500000,
            'description' => 'Laptop operasional kantor',
        ]);
    }
}
