<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request){

        $search = $request->input('search');
        $type = $request->input('type');

        $products = Product::search($search, $type)
            ->latest() // Ex: ordena pelos mais recentes
            ->paginate(20)
            ->appends(['search' => $search, 'type' => $type]);

        /*
        $products = Product::search($search, $type)
            ->latest() // Ex: ordena pelos mais recentes
            ->paginate(20)
            ->withQueryString(); // substitui os appends
        */
        
        return view('admin.product.index', compact('products', 'search'));
    }


    public function create(){
        return view('admin.product.new-product', [
            'product' => null,
        ]);
    }

    public function store(StoreProductRequest $request){
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $data['is_active'] ?? false;
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['description'] = $data['description'] ?? '';

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto criado com sucesso');
    }

    public function edit(Product $product){
        if(!$product){
            return redirect()
                ->route('products.index')
                ->with('message', 'Produto não encontrado');
        }
        
        $variants = Product::searchVariants($product->id)
            ->with('variants.variantAttributes')
            ->latest(); // Ex: ordena pelos mais recentes

        
        //passando o produto ou null
        return view('admin.product.new-product', compact('product', 'variants'));
    }

    public function update(UpdateProductRequest $request){
        $data = $request->validated();
        $data['is_active'] = $data['is_active'] ?? false;
        $data['is_featured'] = $data['is_featured'] ?? false;

        Product::update($data);
    }

    public function show(){
        return true;
    }

    public function destroy(string $id){
        if(!$product = Product::find($id)){
            return redirect()
                ->route('products.index')
                ->with('message', 'Produto não encontrado');
        }

        $product->delete();

        return redirect()
                ->route('products.index')
                ->with('success', 'Produto deletado com sucesso');
    }
    
}
