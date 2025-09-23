@extends('layouts.shipmentsly')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">📋 Lista de Envíos</h1>

    @if($shipments->isEmpty())
        <div class="alert alert-info text-center">
            No hay envíos registrados todavía.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover shadow-sm align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        <th>Transportista</th>
                        <th>Fecha Salida</th>
                        <th>Fecha Entrega</th>
                        <th>Total Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($shipments as $shipment)
                        <tr>
                            <td>{{ $shipment->id_shipment }}</td>
                            <td>
                                <span class="badge 
                                    @if($shipment->shipment_status == 'Asignado') bg-success
                                    @elseif($shipment->shipment_status == 'Pendiente') bg-warning
                                    @else bg-secondary @endif">
                                    {{ $shipment->shipment_status }}
                                </span>
                            </td>
                            <td>
                                {{ $shipment->purchase->client->user->Name }}
                                {{ $shipment->purchase->client->user->last_Name }}
                            </td>
                            <td>
                                @if($shipment->carrier)
                                    {{ $shipment->carrier->user->Name }}
                                    {{ $shipment->carrier->user->last_Name }}
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>{{ $shipment->departure_date }}</td>
                            <td>{{ $shipment->delivery_date ?? 'Pendiente' }}</td>
                            <td>${{ number_format($shipment->purchase->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('shipments.show', $shipment->id_shipment) }}" class="btn btn-sm btn-primary">
                                    🔍 Ver
                                </a>
                                <a href="{{ route('shipments.edit', $shipment->id_shipment) }}" class="btn btn-sm btn-warning">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('shipments.destroy', $shipment->id_shipment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este envío?')">
                                        🗑 Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
