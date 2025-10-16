<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_id' => $product->id_product,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        $cartCount = count($cart);
        return response()->json([
            'message' => 'Producto agregado al carrito',
            'cart_count' => $cartCount
        ]);
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.cart', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = \App\Models\Product::findOrFail($id);

        if (!isset($cart[$id])) {
            return back()->withErrors(['error' => 'Producto no encontrado en el carrito.']);
        }

        $newQuantity = max(1, min($request->quantity, $product->stock)); // ✅ Validación contra stock
        $cart[$id]['quantity'] = $newQuantity;

        session()->put('cart', $cart);
        return redirect()->route('cart.show');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.show');
    }


    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        $clientId = Auth::id();

        if (empty($cart)) {
            return back()->withErrors(['error' => 'El carrito está vacío']);
        }

        $deliveryAddress = $request->input('delivery_address');

        if (!$deliveryAddress) {
            return back()->withErrors(['error' => 'La dirección de entrega es obligatoria.'])->withInput();
        }

        try {
            // 1. Crear la cabecera de la compra
            DB::statement('CALL sp_create_purchase_with_shipment_address(?, ?, ?, @p_purchase_id)', [
                $clientId,
                'Tarjeta', // Puedes cambiar el método de pago si lo necesitas
                $deliveryAddress
            ]);

            $purchaseId = DB::select('SELECT @p_purchase_id as id')[0]->id;

            // 2. Insertar productos en detalle usando SP (también descuenta stock)
            foreach ($cart as $item) {
                DB::statement('CALL sp_add_product_with_weight(?, ?, ?)', [
                    $purchaseId,
                    $item['product_id'],
                    $item['quantity']
                ]);
            }

            // 3. Limpiar carrito
            session()->forget('cart');

            session()->forget('cart');
            return redirect()->route('cart.success', ['id' => $purchaseId])
                ->with('success', 'Compra registrada correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar la compra: ' . $e->getMessage()])->withInput();
        }
    }
    public function success($id)
    {
        $purchase = \App\Models\Purchase::with('details.product')->findOrFail($id);
        return view('cart.success', compact('purchase'));
    }

    public function addAndRedirect($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_id' => $product->id_product,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.show');
    }

    public function addWithQuantity(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $quantity = max(1, min($request->quantity, $product->stock));

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'product_id' => $product->id_product,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        // Si la petición es AJAX, responde con JSON
        if ($request->ajax() || $request->wantsJson()) {
            $cartCount = count($cart);
            return response()->json([
                'message' => 'Producto agregado al carrito',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->route('cart.show');
    }

    public function buyNow(Request $request)
    {
        $product = \App\Models\Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $cart = session('cart', []);
        $cart[$product->id_product] = [
            'product_id' => $product->id_product,
            'name' => $product->product_name,
            'price' => $product->price,
            'quantity' => $quantity
        ];

        session(['cart' => $cart]);

        return redirect()->route('cart.checkout');
    }
}
