<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with([
                'variants' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->with([
                            'images',
                            'variantAttributes.attribute',
                            'variantAttributes.attributeOption',
                        ]);
                }
            ]);

        // Busca
        if ($request->filled('search')) {
            $search = $request->search;

            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ordenação
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

            case 'recent':
                $products->latest();
                break;

            default:
                $products->latest();
                break;
        }

        $products = $products->paginate(20)->withQueryString();

        return view('welcome', compact(
            'products'
        ));
    }
}
