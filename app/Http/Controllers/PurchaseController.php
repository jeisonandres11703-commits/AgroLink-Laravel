<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseDetail;

class PurchaseController extends Controller
{
    /**
     * Muestra todas las compras (puedes filtrar por cliente si lo deseas)
     */
    public function index()
    {
        // Obtiene todas las compras con datos del cliente
        $purchases = Purchase::with('client.user')->get();
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Muestra el formulario para crear una nueva compra
     */
    public function create()
    {
        // Obtiene productos disponibles y el cliente autenticado (ajusta según tu auth)
        $products = Product::all();
        $client = Client::first(); // Cambia esto por el cliente autenticado
        return view('purchases.create', compact('products', 'client'));
    }

    /**
     * Guarda la compra en la base de datos
     */
    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'id_client' => 'required|exists:tb_client,id_user',
            'products' => 'required|array',
            'products.*.id_product' => 'required|exists:tb_products,id_product',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Crea la compra
        $purchase = Purchase::create([
            'id_client' => $request->id_client,
            'subtotal' => 0, // Calcula después
            'taxes' => 0,
            'total' => 0,
            'payment_method' => $request->payment_method ?? 'Efectivo',
        ]);

        $subtotal = 0;
        // Crea los detalles de la compra
        foreach ($request->products as $item) {
            $product = Product::find($item['id_product']);
            $lineSubtotal = $product->price * $item['quantity'];
            PurchaseDetail::create([
                'id_purchase' => $purchase->id_purchase,
                'id_product' => $product->id_product,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $lineSubtotal,
            ]);
            $subtotal += $lineSubtotal;
        }

        // Actualiza los totales de la compra
        $purchase->subtotal = $subtotal;
        $purchase->taxes = $subtotal * 0.19; // Ejemplo de IVA 19%
        $purchase->total = $purchase->subtotal + $purchase->taxes;
        $purchase->save();

        return redirect()->route('purchases.index')->with('success', 'Compra registrada correctamente');
    }

    /**
     * Muestra el detalle de una compra
     */
    public function show($id)
    {
        $purchase = Purchase::with(['client.user', 'details.product'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id_product' => 'required|exists:tb_products,id_product',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $purchase = Purchase::findOrFail($id);

        // Elimina los detalles anteriores
        $purchase->details()->delete();

        $subtotal = 0;
        // Crea los nuevos detalles de la compra
        foreach ($request->products as $item) {
            $product = Product::find($item['id_product']);
            $lineSubtotal = $product->price * $item['quantity'];
            PurchaseDetail::create([
                'id_purchase' => $purchase->id_purchase,
                'id_product' => $product->id_product,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $lineSubtotal,
            ]);
            $subtotal += $lineSubtotal;
        }

        // Actualiza los totales de la compra
        $purchase->subtotal = $subtotal;
        $purchase->taxes = $subtotal * 0.19; // Ejemplo de IVA 19%
        $purchase->total = $purchase->subtotal + $purchase->taxes;
        $purchase->save();

        return redirect()->route('purchases.index')->with('success', 'Compra actualizada correctamente');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->details()->delete(); // Elimina los detalles primero
        $purchase->delete(); // Luego elimina la compra

        return redirect()->route('purchases.index')->with('success', 'Compra eliminada correctamente');
    }


}