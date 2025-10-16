@extends('layouts.shipmentsly')

@section('content')
<link rel="stylesheet" href="/css/envios.css">
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color:var(--color-primario); font-weight:600;">Mis Vehículos Registrados</h2>
    <div class="row g-4" id="contenedor-tarjetas">
        @foreach($vehicles as $vehicle)
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body view-mode">
                    <h5 class="card-title"><strong>{{ $vehicle->vehicle_type }}</strong></h5>
                    <p class="card-text"><strong>Placa: </strong> {{ $vehicle->vehicle_plate }}</p>
                    <p class="card-text"><strong>Capacidad:</strong> {{ $vehicle->load_capacity }} (Kg)</p>
                    @if($vehicle->property_document)
                        <p class="card-text"><strong>Documento:</strong> <a href="{{ asset('storage/' . $vehicle->property_document) }}" target="_blank">Ver documento</a></p>
                    @endif
                    <div class="d-flex gap-2">
                        <a href="{{ route('vehicles.edit', $vehicle->id_vehicle) }}" class="btn btn-success">Editar</a>
                        <form action="{{ route('vehicles.destroy', $vehicle->id_vehicle) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar este vehículo?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <hr>
    <h2 class="h4 fw-bold mb-4">Agregar un vehículo</h2>
    <form class="row g-3" action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <select class="form-select form-select-lg mb-3" name="vehicle_type" required>
                <option selected disabled>Tipo de vehículo</option>
                <option value="Camión">Camión</option>
                <option value="Camioneta">Camioneta</option>
                <option value="Van">Van</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="vehicle_plate" placeholder="Placa del vehículo" maxlength="7" required />
        </div>
        <div class="col-md-6">
            <label class="form-label">Capacidad máxima (kg)</label>
            <input type="number" class="form-control" name="load_capacity" min="0" max="15000" step="100" required />
        </div>
        <div class="col-md-6">
            <label for="property_document" class="form-label">Documento de propiedad</label>
            <input class="form-control" type="file" name="property_document" accept=".pdf,.jpg,.jpeg,.png">
            <div class="form-text">Sube el documento de propiedad del vehículo</div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success w-100 fw-semibold">Agregar vehículo</button>
        </div>
    </form>
</div>

@endsection
