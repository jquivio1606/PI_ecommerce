<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;

// ----------------------------
// RUTAS PÚBLICAS
// ----------------------------

// Página principal de usuario (home)
Route::view('/', 'user.index')->name('user.index');

// Página tienda (listado de productos)
Route::view('/tienda', 'user.tienda')->name('user.tienda');

// Página sobre nosotros
Route::view('/sobreNosotros', 'user.aboutUs')->name('user.aboutUs');

// Página para mostrar producto específico por id (dinámico)
Route::get('/productos/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('user.product', compact('product'));
})->name('productos.show');

// Página de aviso legal
Route::view('/aviso-legal', 'legalNotice')->name('legalNotice');

// Página del mapa web
Route::view('/mapaWeb', 'siteMap')->name('siteMap');

// Página de contacto
Route::view('/contacto', 'contact')->name('contact');

// Página de accesibilidad
Route::view('/accesibilidad', 'accessibility')->name('accessibility');


// ----------------------------
// RUTAS PROTEGIDAS PARA USUARIO AUTENTICADO CON ROL 0 (USUARIO NORMAL)
// ----------------------------

Route::middleware(['auth', 'role:0'])->group(function () {
    // Perfil de usuario autenticado
    Route::view('/usuario/perfil','user.profile')->name('user.profile');

    // Página de pedidos del usuario
    Route::view('/usuario/pedidos', 'user.orders')->name('user.orders');
});


// ----------------------------
// RUTAS PROTEGIDAS PARA ADMINISTRADOR (ROL 1)
// ----------------------------

Route::middleware(['auth', 'role:1'])->group(function () {

    Route::view('/admin/panel','admin.dashboard')->name('admin.dashboard');

    Route::view('/admin/productos', 'admin.product')->name('admin.product');

    Route::view('/admin/pedidos', 'admin.order')->name('admin.order');

    Route::view('/admin/usuarios', 'admin.users')->name('admin.users');
});


// ----------------------------
// REDIRECCIÓN AUTOMÁTICA AL DASHBOARD SEGÚN EL ROL DEL USUARIO AUTENTICADO
// ----------------------------

Route::get('/dashboard', function () {
    if (Auth::check()) {
        // Si el rol es 1 (admin), redirige al dashboard admin; sino, perfil usuario normal
        return redirect()->route(Auth::user()->role == 1 ? 'admin.dashboard' : 'user.profile');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// ----------------------------
// RUTAS PROTEGIDAS PARA LOS USUARIOS AUTENTICADOS (Rutas de configuración de perfil - Laravel Volt)
// ----------------------------

Route::middleware(['auth'])->group(function () {

    // Página carrito de compra
    Route::view('/carrito', 'user.cart')->name('user.cart');

    // Página de confirmación de pedido
    Route::view('/confirmacionPedido', 'user.orderConfirmation')->name('user.orderConfirmation');

    // Redirigir shortcut a perfil
    Route::redirect('configuracion', 'settings/profile');

    // Rutas de configuración de usuario con Volt
    Volt::route('configuracion/perfil', 'settings.profile')->name('settings.profile');
    Volt::route('configuracion/contraseña', 'settings.password')->name('settings.password');
    Volt::route('configuracion/apariencia', 'settings.appearance')->name('settings.appearance');
});


// ----------------------------
// RUTAS DE AUTENTICACIÓN POR DEFECTO DE LARAVEL
// ----------------------------
require __DIR__ . '/auth.php';
