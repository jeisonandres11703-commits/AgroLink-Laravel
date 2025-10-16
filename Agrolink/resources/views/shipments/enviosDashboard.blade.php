
@extends('layouts.shipmentsly')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="container">
        <div class="row">
            <!-- Filtros -->
            <div class="col-lg-3 mt-3">
                <div class="filtros sticky-top" style="top: 10px; background-color: #c6dc93;">
                    <h5 class="mb-4">Filtra tus viajes</h5>
                    <form method="GET" action="{{ route('shipments.dashboard') }}">
                        <div class="mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" class="form-control" name="ubicacion" placeholder="Ciudad o dirección">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de carga</label>
                            <select class="form-select" name="tipo_carga">
                                <option selected>Todas</option>
                                <option>Liquidos</option>
                                <option>Refrigerados</option>
                                <option>Perecederos</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rango de peso (kg)</label>
                            <input type="range" class="form-range peso-slider" min="0" max="15000" step="100" value="0"
                                name="peso">
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">0 kg</small>
                                <span class="badge bg-success valor-peso">0 kg</span>
                                <small class="text-muted">15000 kg</small>
                            </div>
                        </div>
                        <button class="btn btn-success w-100 mt-2" type="submit">
                            <i class="fas fa-search me-2"></i>Buscar viajes
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lista de viajes -->
            <div class="col-lg-9 mt-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Viajes disponibles</h4>
                    <div>
                        <span class="badge bg-primary rounded-pill">{{ $shipments->count() }} viajes encontrados</span>
                    </div>
                </div>

                @forelse($shipments as $shipment)
                    <div class="card card-viaje mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="badge bg-success badge-estado mb-2">
                                                {{ $shipment->shipment_status == 'Asignado' ? 'Asignado' : 'Disponible' }}
                                            </span>
                                            <h5>
                                                {{ $shipment->purchase->details->first()->product->product_name ?? 'Producto' }}
                                            </h5>
                                            <p class="text-muted">
                                                {{ $shipment->purchase->details->first()->product->producer->user->City ?? 'Origen' }}
                                                <i class="fas fa-arrow-right mx-2"></i>
                                                {{ $shipment->purchase->client->user->City ?? 'Destino' }}
                                            </p>
                                        </div>
                                        <h4 class="text-dark">
                                            ${{ number_format($shipment->purchase->shipment_value, 0, ',', '.') }}
                                        </h4>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6 info-cliente mb-3">
                                            <h6>Cliente</h6>
                                            <p class="mb-1">
                                                <strong>{{ $shipment->purchase->client->user->Name ?? '' }}
                                                    {{ $shipment->purchase->client->user->last_Name ?? '' }}</strong>
                                            </p>
                                            <p class="mb-1 small">
                                                <i class="fas fa-phone me-2"></i>
                                                {{ $shipment->purchase->client->user->Phone ?? 'N/A' }}
                                            </p>
                                            <p class="mb-0 small">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ $shipment->purchase->delivery_address ?? $shipment->purchase->client->user->Direction ?? '' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6 info-vendedor">
                                            <h6>Vendedor</h6>
                                            <p class="mb-1">
                                                <strong>{{ $shipment->purchase->details->first()->product->producer->user->Name ?? '' }}
                                                    {{ $shipment->purchase->details->first()->product->producer->user->last_Name ?? '' }}</strong>
                                            </p>
                                            <p class="mb-1 small">
                                                <i class="fas fa-phone me-2"></i>
                                                {{ $shipment->purchase->details->first()->product->producer->user->Phone ?? 'N/A' }}
                                            </p>
                                            <p class="mb-0 small">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ $shipment->purchase->details->first()->product->producer->user->Direction ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mapa-mini mb-3">
                                        <i class="fas fa-map-marked-alt fa-2x"></i>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-1"><strong>Detalles:</strong></p>
                                        <ul class="small ps-3">
                                            <li>Peso: {{ $shipment->purchase->details->first()->product->weight_kg ?? 'N/A' }}
                                                kg</li>
                                            <li>Fecha recogida: {{ $shipment->departure_date ?? 'Por definir' }}</li>
                                            <li>Fecha entrega: {{ $shipment->delivery_davte ?? 'Por definir' }}</li>
                                        </ul>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('shipments.selectVehicle', $shipment->id_shipment) }}" class="btn btn-success">
                                            Aceptar viaje
                                        </a>

                                        <a href="{{ route('shipments.show', $shipment->id_shipment) }}" class="btn btn-outline"
                                            style="color: #1a512e;">
                                            <i class="fas fa-info-circle me-2"></i>Ver detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No hay viajes disponibles.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection