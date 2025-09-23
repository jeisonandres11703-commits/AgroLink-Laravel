@extends('layouts.shipmentsly')

@section('content')
<link rel="stylesheet" href="/css/PerfilAsesor.css">
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="foto mb-3">
                <img src="{{ asset('images/perfil.png') }}" style="width: auto; height: 200px;object-fit: cover; border-radius: 50%;" alt="foto del perfil del Transportista">
            </div>
            <h3>{{ Auth::user()->Name }} {{ Auth::user()->last_Name }}</h3>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <div class="Calificacion mb-4">
                <h5>Calificación:</h5>
                <div class="rating">
                    @php $score = Auth::user()->carrier->qualification->score ?? 4.2; @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star{{ $i <= $score ? ' active' : '' }}">★</span>
                    @endfor
                </div>
                <p>Puntaje actual: <span id="current-rating">{{ $score }}</span>/5</p>
            </div>
        </div>
        <div class="col-md-8">
            <h2>Envíos pendientes</h2>
            <div class="row">
                @forelse($pendingShipments as $shipment)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Track #{{ $shipment->tracking_number }}</h5>
                            <p class="card-text"><strong>Cliente:</strong> {{ $shipment->purchase->client->user->Name ?? '' }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Origen: </strong>{{ $shipment->purchase->details->first()->product->producer->user->City ?? '' }}</li>
                            <li class="list-group-item"><strong>Destino: </strong>{{ $shipment->purchase->client->user->City ?? '' }}</li>
                        </ul>
                     
                    </div>
                </div>
                @empty
                <p class="text-muted">No hay envíos pendientes.</p>
                @endforelse
            </div>
            <h2 class="mt-5">Envíos realizados</h2>
            <div class="row">
                @forelse($finishedShipments as $shipment)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Track #{{ $shipment->tracking_number }}</h5>
                            <p class="card-text"><strong>Cliente:</strong> {{ $shipment->purchase->client->user->Name ?? '' }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Origen: </strong>{{ $shipment->purchase->details->first()->product->producer->user->City ?? '' }}</li>
                            <li class="list-group-item"><strong>Destino: </strong>{{ $shipment->purchase->client->user->City ?? '' }}</li>
                        </ul>
                    </div>
                </div>
                @empty
                <p class="text-muted">No hay envíos realizados.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
