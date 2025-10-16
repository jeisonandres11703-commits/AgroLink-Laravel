@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">📦 Detalle del Envío</h1>

    <div class="row">
        <!-- Información del Envío -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    Información del Envío
                </div>
                <div class="card-body">
                    <p><strong>ID Envío:</strong> {{ $shipment->id_shipment }}</p>
                    <p><strong>Estado:</strong> 
                        <span class="badge 
                            @if($shipment->shipment_status == 'Asignado') bg-success 
                            @elseif($shipment->shipment_status == 'Pendiente') bg-warning 
                            @else bg-secondary @endif">
                            {{ $shipment->shipment_status }}
                        </span>
                    </p>
                    <p><strong>Fecha de salida:</strong> {{ $shipment->departure_date }}</p>
                    <p><strong>Fecha de entrega:</strong> {{ $shipment->delivery_date ?? 'Pendiente' }}</p>
                </div>
            </div>
        </div>

        <!-- Información de la Compra -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    Información de la Compra
                </div>
                <div class="card-body">
                    <p><strong>ID Compra:</strong> {{ $shipment->purchase->id_purchase }}</p>
                    <p><strong>Total:</strong> ${{ number_format($shipment->purchase->total, 0, ',', '.') }}</p>
                    <p><strong>Producto:</strong> 
                        {{ $shipment->purchase->details->first()->product->product_name ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Cliente -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    Cliente
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $shipment->purchase->client->user->Name }} {{ $shipment->purchase->client->user->last_Name }}</p>
                    <p><strong>Teléfono:</strong> {{ $shipment->purchase->client->user->phone ?? 'N/A' }}</p>
                    <p><strong>Ciudad:</strong> {{ $shipment->purchase->client->user->City ?? 'N/A' }}</p>
                    <p><strong>Dirección:</strong> {{ $shipment->purchase->client->user->Direction ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Transportista -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    Transportista
                </div>
                <div class="card-body">
                    @if($shipment->carrier)
                        <p><strong>Nombre:</strong> {{ $shipment->carrier->user->Name }} {{ $shipment->carrier->user->last_Name }}</p>
                        <p><strong>Teléfono:</strong> {{ $shipment->carrier->user->phone ?? 'N/A' }}</p>
                    @else
                        <p class="text-muted">No asignado</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de volver -->
    <div class="text-center mt-4">
        <a href="{{ route('shipments.index') }}" class="btn btn-outline-secondary">
            ⬅ Volver a la lista de envíos
        </a>
    </div>
</div>
@endsection
