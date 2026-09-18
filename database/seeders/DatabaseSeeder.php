<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lessenzza.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        if (Product::query()->exists()) {
            return;
        }

        $color = Attribute::create(['name' => 'Cor']);
        $preta = AttributeOption::create(['attribute_id' => $color->id, 'option' => 'Preta']);
        $bege = AttributeOption::create(['attribute_id' => $color->id, 'option' => 'Bege']);

        $products = [
            [
                'name' => 'Bolsa Tote Clássica',
                'description' => 'Bolsa de couro sintético com alças reforçadas, ideal para o dia a dia.',
                'brand' => 'Lessenzza',
                'variants' => [
                    ['sku' => 'BTC-PRETA', 'price' => 189.90, 'stock' => 12, 'option' => $preta],
                    ['sku' => 'BTC-BEGE', 'price' => 189.90, 'stock' => 8, 'option' => $bege],
                ],
            ],
            [
                'name' => 'Bolsa Transversal Mini',
                'description' => 'Bolsa compacta e versátil, perfeita para sair sem carregar peso.',
                'brand' => 'Lessenzza',
                'variants' => [
                    ['sku' => 'BTM-PRETA', 'price' => 129.90, 'stock' => 20, 'option' => $preta],
                ],
            ],
            [
                'name' => 'Necessaire Premium',
                'description' => 'Necessaire espaçosa com forro impermeável.',
                'brand' => 'Lessenzza',
                'variants' => [
                    ['sku' => 'NEC-BEGE', 'price' => 59.90, 'stock' => 30, 'option' => $bege],
                ],
            ],
            [
                'name' => 'Carteira Slim',
                'description' => 'Carteira slim com compartimentos para cartões e porta-moedas.',
                'brand' => 'Lessenzza',
                'variants' => [
                    ['sku' => 'CS-PRETA', 'price' => 79.90, 'stock' => 0, 'option' => $preta],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'description' => $productData['description'],
                'brand' => $productData['brand'],
                'is_active' => true,
                'is_featured' => false,
            ]);

            foreach ($productData['variants'] as $variantData) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'stock' => $variantData['stock'],
                    'price' => $variantData['price'],
                    'is_active' => true,
                ]);

                $variant->variantAttributes()->create([
                    'attribute_id' => $color->id,
                    'attribute_option_id' => $variantData['option']->id,
                ]);
            }
        }
    }
}
