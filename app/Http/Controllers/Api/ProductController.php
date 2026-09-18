<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with([
                'variants' => function ($query) {
                    $query->where('is_active', true)->with('images');
                },
            ]);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->where('is_active', true);

                if ($request->filled('min_price')) {
                    $query->where('price', '>=', (int) round($request->float('min_price') * 100));
                }

                if ($request->filled('max_price')) {
                    $query->where('price', '<=', (int) round($request->float('max_price') * 100));
                }
            });
        }

        switch ($request->input('sort')) {
            case 'price_asc':
                $products->orderBy(
                    ProductVariant::select('price')
                        ->whereColumn('product_id', 'products.id')
                        ->where('is_active', true)
                        ->orderBy('price')
                        ->limit(1),
                    'asc'
                );
                break;

            case 'price_desc':
                $products->orderBy(
                    ProductVariant::select('price')
                        ->whereColumn('product_id', 'products.id')
                        ->where('is_active', true)
                        ->orderByDesc('price')
                        ->limit(1),
                    'desc'
                );
                break;

            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;

            default:
                $products->latest();
                break;
        }

        $products = $products->paginate(20)->withQueryString();

        $products->getCollection()->transform(fn (Product $product) => $this->transformListItem($product));

        return response()->json($products);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'variants' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->with(['images', 'variantAttributes.attribute', 'variantAttributes.attributeOption']);
            },
        ]);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'brand' => $product->brand,
            'variants' => $product->variants->map(fn (ProductVariant $variant) => [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => (float) $variant->price,
                'stock' => $variant->stock,
                'image' => $this->imageUrl($variant->images->first()?->filename),
                'attributes' => $variant->variantAttributes->map(fn ($va) => [
                    'name' => $va->attribute?->name,
                    'option' => $va->attributeOption?->option,
                ])->filter(fn ($a) => $a['name'] && $a['option'])->values(),
            ]),
        ]);
    }

    private function transformListItem(Product $product): array
    {
        $variants = $product->variants;
        $firstImage = $variants->first()?->images->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'image' => $this->imageUrl($firstImage?->filename),
            'variants_count' => $variants->count(),
            'single_variant_id' => $variants->count() === 1 ? $variants->first()->id : null,
            'min_price' => $variants->isEmpty() ? null : (float) $variants->min('price'),
            'max_price' => $variants->isEmpty() ? null : (float) $variants->max('price'),
        ];
    }

    private function imageUrl(?string $filename): ?string
    {
        return $filename ? Storage::url('products/variants/' . $filename) : null;
    }
}
