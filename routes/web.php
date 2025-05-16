<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;

//VISTAS FOOTER
Route::view('/aviso-legal', 'legalNotice')->name('legalNotice');
Route::view('/contacto', 'contact')->name('contact');
Route::view('/accesibilidad', 'accessibility')->name('accessibility');




// VISTAS PARA USUARIO
Route::get('/', function () {
    return view('user.index');
})->name('user.index');

Route::view('/tienda', 'user.tienda')->name('user.tienda');
Route::view('/sobreNosotros', 'user.aboutUs')->name('user.aboutUs');

Route::view('/carrito', 'user.cart')->name('user.cart');
Route::view('/producto', 'user.product')->name('user.product');
Route::view('/confirmacionPedido', 'user.orderConfirmation')->name('user.orderConfirmation');


Route::get('/productos/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('user.product', compact('product'));
})->name('productos.show');


// Ruta del perfil si es usuario
Route::middleware(['auth', 'role:0'])->group(function () {
    Route::get('/usuario/perfil', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::view('/pedidos', 'user.orders')->name('user.orders');
});



// VISTAS PARA ADMIN
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


    // Vista Crud de Producto
    Route::get('/admin/productos', function () {
        return view('admin.product');
    })->name('admin.product');

    Route::get('/admin/pedidos', function () {
        return view('admin.order');
    })->name('admin.order');

    Route::get('/admin/usuarios', function () {
        return view('admin.users');
    })->name('admin.users');

});


// REDIRECCIÓN AUTOMÁTICA AL DASHBOARD SEGÚN ROL
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role == 1 ? 'admin.dashboard' : 'user.profile');
    }
    return redirect('/'); // Por si acaso no está autenticado
})->middleware(['auth', 'verified'])->name('dashboard');


// COSAS DE LARAVEL - MEJOR NO TOCAR
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
