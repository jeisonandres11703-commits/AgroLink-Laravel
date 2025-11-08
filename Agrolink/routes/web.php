
<?php

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControler;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


// Login
Route::get('/login', [AuthControler::class, 'showLogin'])->name('login');
Route::post('/login', [AuthControler::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthControler::class, 'logout'])->name('logout');

// Registro de usuario
Route::get('/register', [AuthControler::class, 'showRegister'])->name('register');
Route::post('/register', [AuthControler::class, 'register'])->name('register.post');

// Route::get('/client/home', [ClientController::class, 'home'])->name('client.home');


// solo usuarios autenticados pueden ver estas rutas.
Route::middleware(['auth'])->group(function () {
     // Catálogo de productos
     Route::get('/products', [ProductController::class, 'index'])->name('products.index');

     // Detalle de producto
     Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');



     Route::get('/purchase/success', function () {
          return view('purchases.success');
     })->name('purchase.success');

     Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');

     Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
     Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
     Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


     Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
     Route::get('/cart/success/{id}', [CartController::class, 'success'])->name('cart.success');

     Route::post('/cart/add-and-redirect/{id}', [CartController::class, 'addAndRedirect'])->name('cart.addAndRedirect');
     Route::post('/cart/add-with-quantity/{id}', [CartController::class, 'addWithQuantity'])->name('cart.addWithQuantity');
     Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');




});
Route::middleware(['auth'])->group(function () {
     // Ruta para agregar imágenes a productos (solo para productores)
     Route::post('/products/{id}/images', [ProductController::class, 'storeImage'])
          ->name('products.images.store');
});
Route::middleware(['auth'])->group(function () {
     Route::resource('purchases', PurchaseController::class);
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
// Ruta explícita para el index de envíos (transportista y admin)
Route::get('/shipments', [App\Http\Controllers\ShipmentController::class, 'index'])->name('shipments.index');

// 🔹 Rutas personalizadas de Shipments 
Route::get('shipments/dashboard', [ShipmentController::class, 'dashboard'])->name('shipments.dashboard');
Route::get('shipments/pending', [ShipmentController::class, 'pendingRequests'])->name('shipments.pending');

// Aceptar viaje (redirigiendo, no API)
Route::post('/shipments/accept/{id_shipment}', [ShipmentController::class, 'acceptRequest'])
     ->name('shipments.accept');

Route::resource('shipments', ShipmentController::class);


// Mis Viajes (gestión de envíos del transportista)
Route::middleware('auth')->get('/mis-viajes', [App\Http\Controllers\ShipmentController::class, 'myShipments'])->name('shipments.mytrips');



// Ver detalles de envío
Route::get('/envios/{id}', [ShipmentController::class, 'show'])
     ->name('shipments.show');


// vehiculos 

// CRUD de vehículos para transportista
Route::middleware('auth')->resource('vehicles', App\Http\Controllers\VehicleController::class);

// Ruta para seleccionar vehículo al aceptar un viaje
Route::middleware('auth')->get('/shipments/{id_shipment}/seleccionar-vehiculo', [App\Http\Controllers\ShipmentController::class, 'selectVehicle'])->name('shipments.selectVehicle');
Route::middleware('auth')->post('/shipments/{id_shipment}/actualizar-vehiculo', [App\Http\Controllers\ShipmentController::class, 'updateVehicle'])->name('shipments.updateVehicle');

// Perfil del transportista
Route::middleware('auth')->get('/perfil-transportista', [App\Http\Controllers\ShipmentController::class, 'carrierProfile'])->name('profile.carrier');

// Finalizar envío
Route::middleware('auth')->post('/shipments/{id_shipment}/finalizar', [App\Http\Controllers\ShipmentController::class, 'finish'])->name('shipments.finish');

// Perfil del cliente
Route::middleware('auth')->get('/perfil-cliente', [App\Http\Controllers\ClientController::class, 'clientProfile'])->name('profile.client');

// Ruta protegida para el carrito de compras
Route::middleware('auth')->get('/carrito', function() {
    $cart = session('cart', []);
    return view('cart.index', compact('cart'));
})->name('cart.index');


// Rutas para Productor
Route::middleware(['auth'])->prefix('producer')->name('producer.')->group(function () {
     // Dashboard principal (pedidos)
     Route::get('/dashboard', [App\Http\Controllers\ProducerController::class, 'dashboard'])->name('dashboard');
     // Pedidos (alias)
     Route::get('/orders', [App\Http\Controllers\ProducerController::class, 'dashboard'])->name('orders');
     // Mis productos
     Route::get('/products', [App\Http\Controllers\ProducerController::class, 'products'])->name('products');
     // Perfil productor
     Route::get('/profile', [App\Http\Controllers\ProducerController::class, 'profile'])->name('profile');
     // CRUD productos (crear, editar, eliminar, actualizar stock) - sin create
     Route::resource('manage-products', App\Http\Controllers\ProductController::class)->except(['show', 'index', 'create']);
     // protege la ruta con middleware auth
     Route::get('/dashboard', [ShipmentController::class, 'dashboard'])
    ->middleware('auth');
});


