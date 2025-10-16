@extends('layouts.shipmentsly')

@section('content')
<link rel="stylesheet" href="/css/envios.css">
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color:var(--color-primario); font-weight:600;">Editar Vehículo</h2>
    <form class="row g-3" action="{{ route('vehicles.update', $vehicle->id_vehicle) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <select class="form-select form-select-lg mb-3" name="vehicle_type" required>
                <option value="Camión" @if($vehicle->vehicle_type=='Camión') selected @endif>Camión</option>
                <option value="Camioneta" @if($vehicle->vehicle_type=='Camioneta') selected @endif>Camioneta</option>
                <option value="Van" @if($vehicle->vehicle_type=='Van') selected @endif>Van</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="vehicle_plate" placeholder="Placa del vehículo" maxlength="7" value="{{ $vehicle->vehicle_plate }}" required />
        </div>
        <div class="col-md-6">
            <label class="form-label">Capacidad máxima (kg)</label>
            <input type="number" class="form-control" name="load_capacity" min="0" max="15000" step="100" value="{{ $vehicle->load_capacity }}" required />
        </div>
        <div class="col-md-6">
            <label for="property_document" class="form-label">Documento de propiedad</label>
            <input class="form-control" type="file" name="property_document" accept=".pdf,.jpg,.jpeg,.png">
            @if($vehicle->property_document)
                <div class="form-text">Documento actual: <a href="{{ asset('storage/' . $vehicle->property_document) }}" target="_blank">Ver documento</a></div>
            @endif
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success w-100 fw-semibold">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
