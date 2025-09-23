@extends('layouts.shipmentsly')

@section('content')
<link rel="stylesheet" href="/css/envios.css">
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color:var(--color-primario); font-weight:600;">Mis Viajes</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID Envío</th>
                    <th>Estado</th>
                    <th>Fecha de salida</th>
                    <th>Fecha de entrega</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $shipment)
                <tr>
                    <td>{{ $shipment->id_shipment }}</td>
                    <td>
                        <span class="badge-estado badge @if($shipment->shipment_status == 'Asignado') bg-success @elseif($shipment->shipment_status == 'Pendiente') bg-warning @else bg-secondary @endif">
                            {{ $shipment->shipment_status }}
                        </span>
                    </td>
                    <td>{{ $shipment->departure_date }}</td>
                    <td>
                        <form method="POST" action="{{ route('shipments.update', $shipment->id_shipment) }}" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="date" name="delivery_davte" value="{{ $shipment->delivery_davte }}" class="form-control form-control-sm" style="max-width:140px;">
                            <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                        </form>
                    </td>
                    <td>{{ $shipment->purchase->client->user->Name }} {{ $shipment->purchase->client->user->last_Name }}</td>
                    <td>{{ $shipment->purchase->details->first()->product->product_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('shipments.show', $shipment->id_shipment) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                        <!-- Formulario para cambiar vehículo -->
                        <form action="{{ route('shipments.updateVehicle', $shipment->id_shipment) }}" method="POST" class="d-inline-block mt-2">
                            @csrf
                            <select name="id_vehicle" class="form-select form-select-sm d-inline-block w-auto" required>
                                <option value="" disabled>Selecciona vehículo</option>
                                @foreach(auth()->user()->carrier->vehicles as $vehicle)
                                    <option value="{{ $vehicle->id_vehicle }}" @if($shipment->id_vehicle == $vehicle->id_vehicle) selected @endif>
                                        {{ $vehicle->vehicle_type }} - {{ $vehicle->vehicle_plate }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-secondary">Actualizar</button>
                        </form>
                        <!-- Botón para finalizar envío -->
                        <form action="{{ route('shipments.finish', $shipment->id_shipment) }}" method="POST" class="d-inline-block mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Finalizar envío</button>
                        </form>
                        <!-- Botón para eliminar viaje -->
                        <form action="{{ route('shipments.destroy', $shipment->id_shipment) }}" method="POST" class="d-inline-block mt-2" onsubmit="return confirm('¿Estás seguro de eliminar este viaje?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
