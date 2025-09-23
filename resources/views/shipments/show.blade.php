@extends('layouts.shipmentsly')

@section('content')
<link rel="stylesheet" href="/css/envios.css">
<div class="container mt-4">
    <div class="card-viaje p-4 mx-auto" style="max-width: 700px;">
        <h2 class="mb-4 text-center" style="color:var(--color-primario); font-weight:600;">Detalle del Envío</h2>
        <div class="row mb-3">
            <div class="col-6">
                <p><strong>ID Envío:</strong> {{ $shipment->id_shipment }}</p>
            </div>
            <div class="col-6 text-end">
                <span class="badge-estado badge @if($shipment->shipment_status == 'Asignado') bg-success @elseif($shipment->shipment_status == 'Pendiente') bg-warning @else bg-secondary @endif">
                    {{ $shipment->shipment_status }}
                </span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <p><strong>Fecha de salida:</strong> {{ $shipment->departure_date }}</p>
            </div>
            <div class="col-6">
                <p><strong>Fecha de entrega:</strong> {{ $shipment->delivery_date ?? 'Pendiente' }}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-6">
                <p><strong>ID Compra:</strong> {{ $shipment->purchase->id_purchase }}</p>
                <p><strong>Producto:</strong> {{ $shipment->purchase->details->first()->product->product_name ?? 'N/A' }}</p>
            </div>
            <div class="col-6">
                <p><strong>Total:</strong> ${{ number_format($shipment->purchase->total, 0, ',', '.') }}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-6 info-cliente">
                <p class="mb-1"><strong>Cliente:</strong> {{ $shipment->purchase->client->user->Name }} {{ $shipment->purchase->client->user->last_Name }}</p>
                <p class="mb-1"><strong>Teléfono:</strong> {{ $shipment->purchase->client->user->phone ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Ciudad:</strong> {{ $shipment->purchase->client->user->City ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Dirección:</strong> {{ $shipment->purchase->client->user->Direction ?? 'N/A' }}</p>
            </div>
            <div class="col-6 info-vendedor">
                <p class="mb-1"><strong>Transportista:</strong> 
                    @if($shipment->carrier)
                        {{ $shipment->carrier->user->Name }} {{ $shipment->carrier->user->last_Name }}
                    @else
                        <span class="text-muted">No asignado</span>
                    @endif
                </p>
                <p class="mb-1"><strong>Teléfono:</strong> 
                    @if($shipment->carrier)
                        {{ $shipment->carrier->user->phone ?? 'N/A' }}
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('carrier.home') }}" class="btn btn-outline-secondary">
                ⬅ Volver al dashboard de envíos
            </a>
        </div>
    </div>
</div>
@endsection
