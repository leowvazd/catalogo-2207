<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index(Request $request){

        $search = $request->input('search');

        $attributes = Attribute::with('options')
            ->search($search)
            ->latest() // Ex: ordena pelos mais recentes
            ->paginate(20)
            ->appends(['search' => $search]);
        
        return view('admin.attribute.index', compact('attributes', 'search'));
    }

    public function store(StoreAttributeRequest $request){
        $data = $request->validated();

        Attribute::create($data);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Atributo criado com sucesso');
    }

    public function edit(Attribute $attribute){
        if(!$attribute){
            return redirect()
                ->route('attributes.index')
                ->with('message', 'Atributo não encontrado');
        }

        //passando o atributo ou null
        return view('admin.attribute.edit-attribute', compact('attribute'));
    }

    public function update(){
        return true;
    }

    public function show(){
        return true;
    }

    public function destroy(string $id){
        if(!$attribute = Attribute::find($id)){
            return redirect()
                ->route('attributes.index')
                ->with('message', 'Atributo não encontrado');
        }

        $attribute->delete();

        return redirect()
                ->route('attributes.index')
                ->with('success', 'Atributo deletado com sucesso');
    }

    public function storeOption(){

    }

    public function destroyOption(string $id){

    }

    public function updateOption(){

    }

    /*

    public function edit(Product $product){
        if(!$product){
            return redirect()
                ->route('product.index')
                ->with('message', 'Produto não encontrado');
        }

        //passando o produto ou null
        return view('admin.product.new-product', compact('product'));
        
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

    
    */
}
