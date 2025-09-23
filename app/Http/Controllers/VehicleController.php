<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::where('id_carrier', auth()->id())->get();
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No se usa, el formulario está en index
        return redirect()->route('vehicles.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|string|max:50',
            'vehicle_plate' => 'required|string|max:7',
            'load_capacity' => 'required|integer',
            'property_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $vehicle = new Vehicle();
        $vehicle->id_carrier = auth()->id();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_plate = $request->vehicle_plate;
        $vehicle->load_capacity = $request->load_capacity;

        if ($request->hasFile('property_document')) {
            $path = $request->file('property_document')->store('vehicles', 'public');
            $vehicle->property_document = $path;
        }

        $vehicle->save();
        return redirect()->route('vehicles.index')->with('success', 'Vehículo registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        // No se usa, redirigir a index
        return redirect()->route('vehicles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        $request->validate([
            'vehicle_type' => 'required|string|max:50',
            'vehicle_plate' => 'required|string|max:7',
            'load_capacity' => 'required|integer',
            'property_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_plate = $request->vehicle_plate;
        $vehicle->load_capacity = $request->load_capacity;

        if ($request->hasFile('property_document')) {
            $path = $request->file('property_document')->store('vehicles', 'public');
            $vehicle->property_document = $path;
        }

        $vehicle->save();
        return redirect()->route('vehicles.index')->with('success', 'Vehículo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        if ($vehicle->property_document) {
            \Storage::disk('public')->delete($vehicle->property_document);
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehículo eliminado correctamente');
    }
}
