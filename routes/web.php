<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\OrderConfirmation;


Route::get('/', function () {
    return view('user.index');
})->name('user.index');

Route::view('/tienda', 'user.tienda')->name('user.tienda');
Route::view('/sobreNosotros', 'user.sobreNosotros')->name('user.sobreNosotros');

Route::view('/carrito', 'user.carrito')->name('user.carrito');
Route::view('/producto', 'user.product')->name('user.product');
Route::view('/confirmacionPedido', 'user.orderConfirmation')->name('user.orderConfirmation');



// VISTAS CRUD DE PRODUCTO
Route::get('/productos', function () {
    return view('admin.product');
});
Route::get('/pedidos', function () {
    return view('admin.order');
});


Route::get('/productos/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('user.product', compact('product'));
})->name('productos.show');


// COSAS DE LARAVEL - MEJOR NO TOCAR

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::get('/home', function () {
    return view('home');
})->name('home');



require __DIR__.'/auth.php';
