@extends('layouts.shipmentsly')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color:var(--color-primario); font-weight:600;">Selecciona un vehículo para este envío</h2>
    <form action="{{ route('shipments.accept', $shipment->id_shipment) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_vehicle" class="form-label">Vehículo</label>
            <select name="id_vehicle" id="id_vehicle" class="form-select" required>
                <option value="" disabled selected>Selecciona un vehículo</option>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id_vehicle }}">
                        {{ $vehicle->vehicle_type }} - Placa: {{ $vehicle->vehicle_plate }} ({{ $vehicle->load_capacity }} kg)
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Aceptar viaje con este vehículo</button>
    </form>
</div>
@endsection
