<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private const INITIAL_STOCK = 10;

    /**
     * Idempotente: pode rodar em produção sem duplicar produtos nem
     * sobrescrever o estoque de itens que já existem.
     */
    public function run(): void
    {
        $color = Attribute::firstOrCreate(['name' => 'Cor']);
        $options = [
            'Preta' => AttributeOption::firstOrCreate(['attribute_id' => $color->id, 'option' => 'Preta']),
            'Bege' => AttributeOption::firstOrCreate(['attribute_id' => $color->id, 'option' => 'Bege']),
        ];

        $products = [
            [
                'name' => 'Bolsa Tote Clássica',
                'description' => 'Bolsa de couro sintético com alças reforçadas, ideal para o dia a dia.',
                'variants' => [
                    ['sku' => 'BTC-PRETA', 'price' => 189.90, 'color' => 'Preta'],
                    ['sku' => 'BTC-BEGE', 'price' => 189.90, 'color' => 'Bege'],
                ],
            ],
            [
                'name' => 'Bolsa Transversal Mini',
                'description' => 'Bolsa compacta e versátil, perfeita para sair sem carregar peso.',
                'variants' => [
                    ['sku' => 'BTM-PRETA', 'price' => 129.90, 'color' => 'Preta'],
                ],
            ],
            [
                'name' => 'Necessaire Premium',
                'description' => 'Necessaire espaçosa com forro impermeável.',
                'variants' => [
                    ['sku' => 'NEC-BEGE', 'price' => 59.90, 'color' => 'Bege'],
                ],
            ],
            [
                'name' => 'Carteira Slim',
                'description' => 'Carteira slim com compartimentos para cartões e porta-moedas.',
                'variants' => [
                    ['sku' => 'CS-PRETA', 'price' => 79.90, 'color' => 'Preta'],
                ],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'brand' => 'Lessenzza',
                    'is_active' => true,
                    'is_featured' => false,
                ]
            );

            foreach ($data['variants'] as $variantData) {
                $variant = ProductVariant::firstOrCreate(
                    ['product_id' => $product->id, 'sku' => $variantData['sku']],
                    ['stock' => self::INITIAL_STOCK, 'price' => $variantData['price'], 'is_active' => true]
                );

                $variant->variantAttributes()->firstOrCreate([
                    'attribute_id' => $color->id,
                    'attribute_option_id' => $options[$variantData['color']]->id,
                ]);
            }
        }
    }
}
