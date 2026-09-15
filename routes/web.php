<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckIfIsAdmin;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', CheckIfIsAdmin::class])
    ->prefix('admin')
    ->group(function(){
        //AdminPanel
        Route::get('/usuario', [AdminPanelController::class, 'usuario'])->name('admin.users');
        Route::get('/produtos', [AdminPanelController::class, 'products'])->name('admin.products');
        Route::get('/pedidos', [AdminPanelController::class, 'orders'])->name('admin.orders');
        Route::get('/configs', [AdminPanelController::class, 'configs'])->name('admin.configs');
        Route::get('/panel', [AdminPanelController::class, 'index'])->name('admin.panel');

        //User
        Route::post('/usuario', [UserController::class, 'store'])->name('users.store');
        Route::get('/usuario', [UserController::class, 'index'])->name('users.index');
            //->middleware(['', ''])

        //ordem da rota importa pra não confundir os caminhos, se ele cair em uma rota que tem /usuario/{user}
        //a aplicação vai tentar achar um valor criar dentro de user, o que não vai existir
        //então sempre que uma rota tiver a mesma quantidade de parametros, e um for variável, 
        //precisa colocar o sem variável primeiro pra garantir o match
        Route::get('/usuario/criar', [UserController::class, 'create'])->name('users.create');
        Route::get('/usuario/{user}', [UserController::class, 'show'])->name('users.show');
        //put pra editar completo, patch pra editar parcial, pode ter as duas
        Route::put('/usuario/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/usuario/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::delete('/usuario/{user}/destruir', [UserController::class, 'destroy'])->name('users.destroy');

        //Product
        Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
        Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
        Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
        Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::get('/produtos/editar/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::delete('/produtos/destruir/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        //Product.Variant
        Route::post('/produtos/{product}/variantes',[ProductController::class, 'storeVariant'])->name('variants.store');
        Route::put('/produtos/{product}/variantes/{variant}',[ProductController::class, 'updateVariant'])->name('variants.update');
        Route::delete('/produtos/{product}/variantes/{variant}',[ProductController::class, 'destroyVariant'])->name('variants.destroy');
        //Product.Variant.Option
        Route::post('/produtos/{product}/variantes/{variant}/atributos', [ProductController::class, 'StoreVariantAttribute'])->name('variants.attributes.store');
        Route::delete(' /produtos/{product}/variantes/{variant}/atributos/{variantAttribute}', [ProductController::class, 'destroyVariantAttribute'])->name('variants.attributes.destroy');


        //Attributes
        Route::get('/atributos', [AttributeController::class, 'index'])->name('attributes.index');
        Route::post('/atributos', [AttributeController::class, 'store'])->name('attributes.store');
        Route::put('/atributos/{attribute}', [AttributeController::class, 'update'])->name('attributes.update');
        Route::get('/atributos/editar/{attribute}', [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::delete('/atributos/destruir/{attribute}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
        //Attribute Options
        Route::put('/atributos/opcao', [AttributeController::class, 'updateOption'])->name('attributes.update-option');
        Route::delete('/atributos/destruir/{optionid}', [AttributeController::class, 'destroyOption'])->name('attributes.destroy-option');
        Route::post('/atributos/opcao/{attribute}', [AttributeController::class, 'storeOption'])->name('attributes.store-option');

        //Images
        Route::post('/produtos/{product}/variantes/{variant}/imagens',[ProductController::class, 'storeVariantImage'])->name('variants.images.store');
        Route::delete('/produtos/{product}/variantes/{variant}/imagens/{image}',[ProductController::class, 'destroyVariantImage'])->name('variants.images.destroy');
        

        //Cart

        //Order
        Route::get('/pedidos', [AdminPanelController::class, 'orders'])->name('orders.index');

        //Config
        Route::get('/configs', [AdminPanelController::class, 'configs'])->name('configs.index');

});

//Grupo para páginas de acesso público
Route::prefix('')->group(function(){
    // Área pública / consumidor
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Produtos
    Route::get('/home/produto/{product}', [ProductController::class, 'show'])->name('shop.products.show');

    // Carrinho
    Route::get('/home/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::post('/home/carrinho/adicionar/{variant}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/home/carrinho/{variant}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/home/carrinho/{variant}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/home/carrinho', [CartController::class, 'clear'])->name('cart.clear');

    // Finalização
    Route::get('/home/finalizar', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/home/finalizar', [OrderController::class, 'store'])->name('orders.store');

    // Pedido concluído
    Route::get('/home/pedido/concluido/{order}', [OrderController::class, 'success'])->name('orders.success');
});

//Utiliza um nome de rota para redirecionar para outra rota
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::get('/', function () {
    return redirect()->route('home');
});

/*
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';