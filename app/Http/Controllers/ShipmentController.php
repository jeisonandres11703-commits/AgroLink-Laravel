<?php

namespace App\Http\Controllers;
use App\Models\Vehicle;
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


    // Actualiza los datos del envío:

    public function update(Request $request, string $id)
    {
        // Si viene de la vista Mis Viajes, solo permitir actualizar la fecha de entrega
        if ($request->has('delivery_davte')) {
            $request->validate([
                'delivery_davte' => 'nullable|date',
            ]);
            $shipment = Shipment::findOrFail($id);
            $shipment->delivery_davte = $request->delivery_davte;
            $shipment->save();
            return redirect()->route('shipments.mytrips')->with('success', 'Fecha de entrega actualizada');
        }
        // Lógica original para otros updates
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

   
    public function destroy(string $id)
    {
    $shipment = Shipment::findOrFail($id);
    $shipment->delete();

    return redirect()->route('shipments.mytrips')->with('success', 'Envío eliminado correctamente');
    }

    public function pendingRequests()
    {
        $purchases = Purchase::doesntHave('shipment')->with('client.user')->get();
        return view('shipments.pending', compact('purchases'));
    }


    public function acceptRequest(Request $request, $id_shipment)
    {
        $request->validate([
            'id_vehicle' => 'required|exists:tb_vehicles,id_vehicle',
        ]);
        try {
            $shipment = Shipment::findOrFail($id_shipment);
            if ($shipment->shipment_status === 'Asignado') {
                return redirect()->route('shipments.dashboard')
                    ->with('error', 'El envío ya fue asignado a otro transportador.');
            }
            $shipment->id_carrier = Auth::id();
            $shipment->id_vehicle = $request->id_vehicle;
            $shipment->shipment_status = 'Asignado';
            $shipment->save();
            return redirect()->route('shipments.dashboard')
                ->with('success', '¡Has aceptado el viaje correctamente!');
        } catch (\Exception $e) {
            return redirect()->route('shipments.dashboard')
                ->with('error', 'Ocurrió un error al aceptar el viaje: ' . $e->getMessage());
        }
    }
    /**
     * Actualizar el vehículo asignado a un envío desde Mis Viajes
     */
    public function updateVehicle(Request $request, $id_shipment)
    {
        $request->validate([
            'id_vehicle' => 'required|exists:tb_vehicles,id_vehicle',
        ]);
        $shipment = Shipment::findOrFail($id_shipment);
        $shipment->id_vehicle = $request->id_vehicle;
        $shipment->save();
        return redirect()->back()->with('success', 'Vehículo actualizado correctamente para el envío.');
    }


    public function dashboard()
    {
        $user = auth()->user();

        // Si el usuario es transportista (carrier)
        if ($user->carrier) {
            $shipments = Shipment::with(['purchase.client.user', 'purchase.details.product.producer.user'])
                ->where('shipment_status', 'Buscando Transporte')
                ->get();
            return view('shipments.enviosdashboard', compact('shipments'));
        }

        // Si no es transportista, lo devolvemos al home con error
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder al dashboard de envíos.');
    }

       // Vista personalizada: Mis Viajes para transportista
    public function myShipments()
    {
        $user = auth()->user();
        if ($user->carrier) {
            $shipments = Shipment::where('id_carrier', $user->id_user)
                ->where('shipment_status', 'Asignado')
                ->with(['purchase.client.user', 'purchase.details.product.producer.user'])
                ->get();
            return view('shipments.mytrips', compact('shipments'));
        }
        return redirect()->route('carrier.home')->with('error', 'No tienes permisos para acceder a Mis Viajes.');
    }

    /* Mostrar formulario de selección de vehículo al aceptar viaje
     */
    public function selectVehicle($id_shipment)
    {
        $shipment = Shipment::findOrFail($id_shipment);
        $carrier = Auth::user()->carrier;
        $vehicles = $carrier ? $carrier->vehicles : collect();
        return view('shipments.select_vehicle', compact('shipment', 'vehicles'));
    }

    /**
     * Mostrar perfil del transportista con envíos pendientes y realizados
     */
    public function carrierProfile()
    {
        $user = auth()->user();
        $pendingShipments = Shipment::where('id_carrier', $user->id_user)
            ->where('shipment_status', 'Asignado')
            ->with(['purchase.client.user', 'purchase.details.product.producer.user'])
            ->get();
        $finishedShipments = Shipment::where('id_carrier', $user->id_user)
            ->where('shipment_status', 'Finalizado')
            ->with(['purchase.client.user', 'purchase.details.product.producer.user'])
            ->get();
        return view('profile.carrier', compact('pendingShipments', 'finishedShipments'));
    }

    /**
     * Finalizar un envío (cambiar estado a Finalizado)
     */
    public function finish($id_shipment)
    {
        $shipment = Shipment::findOrFail($id_shipment);
        $shipment->shipment_status = 'Finalizado';
        $shipment->save();
        return redirect()->back()->with('success', '¡Envío finalizado correctamente!');
    }


}


