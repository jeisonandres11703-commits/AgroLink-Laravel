<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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


    public function acceptRequest($id_shipment)
    {
        try {
            // Buscar el envío
            $shipment = Shipment::findOrFail($id_shipment);

            // Verificar si ya está asignado
            if ($shipment->shipment_status === 'Asignado') {
                return redirect()->route('shipments.dashboard')
                    ->with('error', 'El envío ya fue asignado a otro transportador.');
            }

            // Asignar el transportador y cambiar estado
            $shipment->id_carrier = Auth::id();
            $shipment->shipment_status = 'Asignado';
            $shipment->save();

            return redirect()->route('shipments.dashboard')
                ->with('success', '¡Has aceptado el viaje correctamente!');
        } catch (\Exception $e) {
            return redirect()->route('shipments.dashboard')
                ->with('error', 'Ocurrió un error al aceptar el viaje: ' . $e->getMessage());
        }
    }


    public function dashboard()
    {
        $user = auth()->user();

        // Si el usuario es transportista (carrier)
        if ($user->carrier) {
            $shipments = Shipment::with(['purchase.client.user', 'purchase.details.product.producer.user'])
                ->get();

            return view('shipments.enviosdashboard', compact('shipments'));
        }

        // Si no es transportista, lo devolvemos al home con error
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder al dashboard de envíos.');
    }




}


