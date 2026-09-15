<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreVAttributeRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Attribute;
use App\Models\AttributeOption;

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

    public function edit(String $id){
        if(!$product = Product::find($id)){
            return redirect()
                ->route('products.index')
                ->with('message', 'Produto não encontrado');
        }

        $attributes = Attribute::with('options')->get();

        $variants = $product->variants()
        ->with([
            'variantAttributes.attribute', 
            'variantAttributes.attributeOption',
            'images',
        ])
        ->latest()
        ->get();
        
        //passando o produto ou null
        return view('admin.product.new-product', compact('product', 'variants', 'attributes'));
    }

    public function update(UpdateProductRequest $request, Product $product){
        $data = $request->validated();
        $data['is_active'] = $data['is_active'] ?? false;
        $data['is_featured'] = $data['is_featured'] ?? false;

       $product->update($data);
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


    public function storeVariant(StoreVariantRequest $request, Product $product){
        $data = $request->validated();
        $data['product_id'] = $product->id;
        $data['is_active'] = $request->has('is_active');

        if (isset($data['price'])) {
            $data['price'] = (int) round($data['price']);
        }

        ProductVariant::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Variante criada com sucesso!');
    }

    public function updateVariant(UpdateVariantRequest $request, Product $product, ProductVariant $variant){
        $data = $request->validated();
        $data['product_id'] = $product->id;
        $data['is_active'] = $request->has('is_active');

        if (isset($data['price'])) {
            $data['price'] = (int) round($data['price']);
        }

        $variant->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Variante atualizada com sucesso!');
    }

    public function destroyVariant(Product $product, ProductVariant $variant)
    {
        if(!$variant){
            return redirect()
                ->route('products.index')
                ->with('message', 'Variante não encontrads');
        }
        $variant->delete();

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Variante deletada com sucesso');
    }

    //Variant Attributes

    public function storeVariantAttribute(
        StoreVAttributeRequest $request,
        Product $product,
        ProductVariant $variant
    ) {
        // Garante que a variante pertence ao produto informado
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $attributeId = $request->attribute_id;
        $optionId = $request->attribute_option_id;

        // Garante que a opção pertence ao atributo selecionado
        $option = AttributeOption::where('id', $optionId)
            ->where('attribute_id', $attributeId)
            ->firstOrFail();

        // Impede que a variante tenha duas opções do mesmo atributo
        $alreadyExists = $variant->variantAttributes()
            ->where('attribute_id', $attributeId)
            ->exists();

        if ($alreadyExists) {
            return redirect()
                ->route('products.edit', $product->id)
                ->with('error', 'A variante já possui uma opção para este atributo.');
        }

        // Cria o vínculo
        $variant->variantAttributes()->create([
            'attribute_id' => $attributeId,
            'attribute_option_id' => $option->id,
        ]);

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Atributo vinculado à variante com sucesso!');
    }

    public function destroyVariantAttribute(
        Product $product,
        ProductVariant $variant,
        $variantAttribute
    ) {
        // Garante que a variante pertence ao produto
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        // Busca o vínculo dentro da própria variante
        $variantAttribute = $variant->variantAttributes()
            ->where('id', $variantAttribute)
            ->firstOrFail();

        // Remove somente o vínculo
        $variantAttribute->delete();

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Atributo removido da variante com sucesso!');
    }

    //Imagens
    public function storeVariantImage(
        StoreImageRequest $request,
        Product $product,
        ProductVariant $variant
    ) {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $file = $request->file('image');

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        // Cria primeiro o registro para obter o ID da imagem
        $image = $variant->images()->create([
            'filename' => 'temp',
        ]);

        $filename = $variant->id
            . '-' . Str::slug($variant->sku)
            . '-' . $image->id
            . '.' . $extension;

        try {

            $file->storeAs(
                'products/variants',
                $filename,
                'public'
            );

            $image->update([
                'filename' => $filename,
            ]);

        } catch (\Throwable $e) {

            // Remove o registro caso o arquivo não consiga ser salvo
            $image->delete();

            throw $e;
        }

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Imagem adicionada com sucesso!');
    }

    public function destroyVariantImage(
        Product $product,
        ProductVariant $variant,
        Image $image
    ) {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        if ($image->product_variant_id !== $variant->id) {
            abort(404);
        }

        Storage::disk('public')->delete(
            'products/variants/' . $image->filename
        );

        $image->delete();

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Imagem removida com sucesso!');
    }
    
}
