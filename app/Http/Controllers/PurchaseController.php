<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    // Listar compras
    public function index()
    {
        $purchases = \App\Models\Purchase::with('details.product')
            ->where('id_client', Auth::id())
            ->get();
        return view('purchases.index', compact('purchases'));
    }

    // Mostrar detalles de una compra
    public function show($id)
    {
        $purchase = \App\Models\Purchase::with('details.product')->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    // Eliminar compra (usa SP que restaura stock)
    public function destroy($id)
    {
        try {
            // 👉 Solo llamamos al SP, no tocamos stock ni detalles manualmente
            DB::statement('CALL sp_cancel_purchase(?)', [$id]);

            return redirect()->route('purchases.index')
                ->with('success', 'Compra eliminada y stock restaurado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('purchases.index')
                ->with('error', 'Error al eliminar la compra: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $purchase = \App\Models\Purchase::findOrFail($id);

        // Validar que la compra pertenece al usuario logueado
        if ($purchase->id_client !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        $purchase = \App\Models\Purchase::findOrFail($id);

        if ($purchase->id_client !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Solo permitimos editar campos seguros (ej: dirección, método de pago)
        $purchase->update([
            'payment_method' => $request->payment_method,
            'delivery_address' => $request->delivery_address,
        ]);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated successfully');
    }

}
