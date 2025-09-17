<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Purchase;
use App\Models\Carrier;
use App\Models\Client;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carga los envíos con la relación de compra y transportista
        $shipments = Shipment::with(['purchase.client.user', 'carrier.user'])->get();
        return view('shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /*
    Muestra el formulario para crear un envío.
    Carga las compras pendientes de envío y los transportistas disponibles: 
    */
    public function create()
    {
        // // Solo compras que aún no tienen envío asignado
        $purchases = Purchase::doesntHave('shipment')->with('client.user')->get();
        $carriers = Carrier::with('user')->get();
        return view('shipments.create', compact('purchases', 'carriers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Guarda un nuevo envío en la base de datos:
    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'id_purchase' => 'required|exists:tb_purchase,id_purchase',
            'id_carrier' => 'nullable|exists:tb_carrier,id_user',
            'shipment_status' => 'required',
            'departure_date' => 'nullable|date',
            'delivery_davte' => 'nullable|date',
            'tracking_number' => 'nullable|string|max:10',
        ]);

        // Crea el envío
        Shipment::create($request->all());

        return redirect()->route('shipments.index')->with('success', 'Envío creado correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shipment = Shipment::with(['purchase.client.user', 'carrier.user'])->findOrFail($id);
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    //Muestra el formulario para editar un envío:
    public function edit(string $id)
    {
        $shipment = Shipment::findOrFail($id);
        $carriers = Carrier::with('user')->get();
        return view('shipments.edit', compact('shipment', 'carriers'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Actualiza los datos del envío:
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_carrier' => 'nullable|exists:tb_carrier,id_user',
            'shipment_status' => 'required',
            'departure_date' => 'nullable|date',
            'delivery_davte' => 'nullable|date',
            'tracking_number' => 'nullable|string|max:10',
        ]);

        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->all());

        return redirect()->route('shipments.index')->with('success', 'Envío actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return redirect()->route('shipments.index')->with('success', 'Envío eliminado correctamente');
    }

    public function pendingRequests()
    {
        $purchases = Purchase::doesntHave('shipment')->with('client.user')->get();
        return view('shipments.pending', compact('purchases'));
    }

     public function acceptRequest(Request $request, $purchaseId)
    {   
        try {
            // 1. Verificar autenticación
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe iniciar sesión para aceptar viajes',
                    'redirect' => route('login')
                ], 401);
            }

            $user = Auth::user();
            
            // 2. Verificar que el usuario sea transportista
            $carrier = Carrier::where('id_user', $user->id_user)->first();
            
            if (!$carrier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo los transportistas pueden aceptar viajes'
                ], 403);
            }

            // 3. Verificar que la compra existe
            $purchase = Purchase::find($purchaseId);
            if (!$purchase) {
                return response()->json([
                    'success' => false,
                    'message' => 'La compra no existe'
                ], 404);
            }

            // 4. Verificar que el envío no esté ya asignado
            $existingShipment = Shipment::where('id_purchase', $purchaseId)->first();
            
            if ($existingShipment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este viaje ya fue asignado a otro transportista'
                ], 400);
            }

            // 5. Crear el envío en la base de datos
            $shipment = Shipment::create([
                'id_purchase' => $purchaseId,
                'id_carrier' => $user->id_user,
                'shipment_status' => 'Asignado',
                'departure_date' => now(),
                'delivery_davte' => now()->addDays(3), // 3 días para entrega
                'tracking_number' => 'TRK' . rand(100000, 999999)
            ]);

            // 6. Actualizar el stock si es necesario (opcional)
            // foreach ($purchase->details as $detail) {
            //     $product = $detail->product;
            //     $product->stock -= $detail->quantity;
            //     $product->save();
            // }

            // 7. Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Viaje aceptado correctamente',
                'shipment' => [
                    'id' => $shipment->id_shipment,
                    'tracking_number' => $shipment->tracking_number,
                    'status' => $shipment->shipment_status,
                    'delivery_date' => $shipment->delivery_davte
                ]
            ]);

        } catch (\Exception $e) {
            // 8. Manejar errores inesperados
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function dashboard()
{
    $shipments = Shipment::with([
        'purchase.details.product.producer.user',
        'purchase.client.user',
        'carrier.user'
    ])->get();

    return view('shipments.enviosDashboard', compact('shipments'));
}
}


