<?php

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControler;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ProductController;


// Login
Route::get('/login', [AuthControler::class, 'showLogin'])->name('login');
Route::post('/login', [AuthControler::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthControler::class, 'logout'])->name('logout');

// Route::get('/client/home', [ClientController::class, 'home'])->name('client.home');


// solo usuarios autenticados pueden ver estas rutas.
Route::middleware(['auth'])->group(function () {
     // Catálogo de productos
     Route::get('/products', [ProductController::class, 'index'])->name('products.index');

     // Detalle de producto
     Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
     
     // Guardar compra
     Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
});
Route::middleware(['auth'])->group(function () {
     // Ruta para agregar imágenes a productos (solo para productores)
     Route::post('/products/{id}/images', [ProductController::class, 'storeImage'])
          ->name('products.images.store');
});

// Dashboards de prueba para cada rol
Route::middleware('auth')->group(function () {
     Route::get('/client/home', [ProductController::class, 'index'])->name('client.home');
     Route::view('/producer/home', 'dashboards.producer')->name('producer.home');
     Route::get('/carrier/home', [ShipmentController::class, 'dashboard'])->name('carrier.home');

     Route::view('/admin/home', 'dashboards.admin')->name('admin.home');
     Route::view('/advisor/home', 'dashboards.advisor')->name('advisor.home');
});


Route::get('/', function () {
     return redirect()->route('shipments.dashboard');
});

// 🔹 Rutas personalizadas de Shipments primero
Route::get('shipments/dashboard', [ShipmentController::class, 'dashboard'])->name('shipments.dashboard');
Route::get('shipments/pending', [ShipmentController::class, 'pendingRequests'])->name('shipments.pending');

// 🔹 Luego el resource para evitar conflictos
Route::resource('shipments', ShipmentController::class);

// Resource de purchases
Route::resource('purchases', PurchaseController::class);


// Aceptar viaje (redirigiendo, no API)
Route::post('/shipments/accept/{id_shipment}', [ShipmentController::class, 'acceptRequest'])
    ->name('shipments.accept');




// Ver detalles de envío
Route::get('/envios/{id}', [ShipmentController::class, 'show'])
     ->name('shipments.show');


