<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use App\Livewire\TwoFactorAuth;


// ----------------------------
// RUTAS DE VISTAS PÚBLICAS (FOOTER)
// ----------------------------

// Página de aviso legal
Route::view('/aviso-legal', 'legalNotice')->name('legalNotice');

// Página de contacto
Route::view('/contacto', 'contact')->name('contact');

// Página de accesibilidad
Route::view('/accesibilidad', 'accessibility')->name('accessibility');

// ----------------------------
// RUTAS PARA USUARIOS NORMALES (PÚBLICAS Y PROTEGIDAS)
// ----------------------------

// Página principal de usuario (home)
Route::get('/', function () {
    return view('user.index');
})->name('user.index');

// Página tienda (listado de productos)
Route::view('/tienda', 'user.tienda')->name('user.tienda');

// Página sobre nosotros
Route::view('/sobreNosotros', 'user.aboutUs')->name('user.aboutUs');

// Página carrito de compra
Route::view('/carrito', 'user.cart')->name('user.cart');

// Página genérica de producto (sin datos específicos)
Route::view('/producto', 'user.product')->name('user.product');

// Página de confirmación de pedido
Route::view('/confirmacionPedido', 'user.orderConfirmation')->name('user.orderConfirmation');

// Página para mostrar producto específico por id (dinámico)
Route::get('/productos/{id}', function ($id) {
    $product = Product::findOrFail($id);  // Buscar producto o fallar si no existe
    return view('user.product', compact('product')); // Pasar producto a la vista
})->name('productos.show');


// ----------------------------
// RUTAS PROTEGIDAS PARA USUARIO AUTENTICADO CON ROL 0 (USUARIO NORMAL)
// ----------------------------

Route::middleware(['auth', 'role:0'])->group(function () {
    // Perfil de usuario autenticado
    Route::get('/usuario/perfil', function () {
        return view('user.profile');
    })->name('user.profile');

    // Página de pedidos del usuario
    Route::view('/pedidos', 'user.orders')->name('user.orders');
});


// ----------------------------
// RUTAS PROTEGIDAS PARA ADMINISTRADOR (ROL 1)
// ----------------------------

Route::middleware(['auth', 'role:1'])->group(function () {
    // Dashboard administrador
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD productos (vista administración)
    Route::get('/admin/productos', function () {
        return view('admin.product');
    })->name('admin.product');

    // Gestión de pedidos en administración
    Route::get('/admin/pedidos', function () {
        return view('admin.order');
    })->name('admin.order');

    // Gestión de usuarios en administración
    Route::get('/admin/usuarios', function () {
        return view('admin.users');
    })->name('admin.users');
});


// ----------------------------
// REDIRECCIÓN AUTOMÁTICA AL DASHBOARD SEGÚN EL ROL DEL USUARIO AUTENTICADO
// ----------------------------

Route::get('/dashboard', function () {
    if (Auth::check()) {
        // Si el rol es 1 (admin), redirige al dashboard admin; sino, perfil usuario normal
        return redirect()->route(Auth::user()->role == 1 ? 'admin.dashboard' : 'user.profile');
    }
    // Si no está autenticado, redirige al home
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');


// ----------------------------
// RUTAS DE CONFIGURACIÓN DE PERFIL (Laravel Volt) - PROTEGIDAS
// ----------------------------

Route::middleware(['auth'])->group(function () {
    // Redirigir shortcut a perfil
    Route::redirect('settings', 'settings/profile');

    // Rutas de configuración de usuario con Volt
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


// ----------------------------
// OTRAS RUTAS
// ----------------------------

// Vista home (posible página general o dashboard alternativo)
Route::get('/home', function () {
    return view('home');
})->name('home');


// ----------------------------
// RUTAS DE AUTENTICACIÓN POR DEFECTO DE LARAVEL
// ----------------------------
require __DIR__.'/auth.php';
