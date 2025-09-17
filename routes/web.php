<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\PurchaseController;

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

// Aceptar viaje (API)
Route::post('/envios/accept/{purchaseId}', [ShipmentController::class, 'acceptRequest'])
     ->name('shipments.accept')
     ->middleware('auth');

// Ver detalles de envío
Route::get('/envios/{id}', [ShipmentController::class, 'show'])
     ->name('shipments.show');

     
