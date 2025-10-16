<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller{
    public function store(Request $request){
        $request->validate([
            'product_id' => 'required|exists:tb_products,id_product',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|max:20',
        ]);

        $clientId = Auth::id(); // id_user del cliente autenticado

        DB::beginTransaction();
        try {
            // 1. Crear la compra (cabecera)
            $purchase = Purchase::create([
                'id_client' => $clientId,
                'payment_method' => $request->payment_method,
                'subtotal' => 0, // se recalcula con trigger
                'taxes' => 0,
                'total' => 0,
            ]);

            // 2. Obtener producto
            $product = Product::findOrFail($request->product_id);

            // 3. Insertar detalle
            PurchaseDetail::create([
                'id_purchase' => $purchase->id_purchase,
                'id_product' => $product->id_product,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $request->quantity,
            ]);

            // 4.  cuando el cliente lo necesite : actualizar dirección del cliente
            Auth::user()->update(['Direction' => $request->address]);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Compra realizada con éxito. El productor recibirá la orden.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar la compra: ' . $e->getMessage()]);
        }
    }
}