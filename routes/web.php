<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
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
        Route::put('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
        Route::delete('/produtos/{product}/destruir', [ProductController::class, 'destroy'])->name('products.destroy');

        
        //Attributes
        Route::get('/atributos', [AttributeController::class, 'index'])->name('attributes.index');
        Route::post('/atributos', [AttributeController::class, 'store'])->name('attributes.store');
        Route::put('/atributos/{attribute}', [AttributeController::class, 'update'])->name('attributes.update');
        Route::post('/atributos/{attribute}/editar', [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::delete('/atributos/{attribute}/destruir', [AttributeController::class, 'destroy'])->name('attributes.destroy');
        //Attribute Options
        Route::put('/atributos/{option}', [AttributeController::class, 'update-option'])->name('attributes.update-option');
        Route::delete('/atributos/{option}/destruir', [AttributeController::class, 'destroy-option'])->name('attributes.destroy-option');
        Route::post('/atributos/{attribute}/opcao', [AttributeController::class, 'store-option'])->name('attributes.store-option');
        

        //Cart

        //Order
        Route::get('/pedidos', [AdminPanelController::class, 'orders'])->name('orders.index');

        //Config
        Route::get('/configs', [AdminPanelController::class, 'configs'])->name('configs.index');

});

//Grupo para páginas de acesso público
Route::prefix('inicial')->group(function(){
    Route::get('/inicial');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Utiliza um nome de rota para redirecionar para outra rota
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');


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