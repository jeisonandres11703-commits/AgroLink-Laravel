@extends('layouts.appIndex')

@section('styles')
    <link rel="stylesheet" href="/css/PerfilAsesor.css">
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="foto mb-3">
                <img src="{{ asset('images/perfil.png') }}" style="width: auto; height: 200px;object-fit: cover; border-radius: 50%;" alt="foto del perfil del Cliente">
            </div>
            <h3>{{ Auth::user()->Name }} {{ Auth::user()->last_Name }}</h3>
            <p class="text-muted">{{ Auth::user()->email }}</p>
        </div>
        <div class="col-md-8">
            <h2>Compras realizadas</h2>
            <div class="compras-scroll-container">
                <div class="compras-scroll-inner">
                    @forelse($purchases as $purchase)
                    <div class="compra-card card mx-2">
                        <div class="card-body">
                            <h5 class="card-title">Compra #{{ $purchase->id_purchase }}</h5>
                            <p class="card-text"><strong>Fecha:</strong> {{ $purchase->purchase_datetime ? \Carbon\Carbon::parse($purchase->purchase_datetime)->format('d/m/Y') : '-' }}</p>
                            <p class="card-text"><strong>Valor:</strong> ${{ number_format($purchase->shipment_value, 0, ',', '.') }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($purchase->details as $detail)
                                <li class="list-group-item">
                                    <strong>{{ $detail->product->product_name ?? '' }}</strong> x {{ $detail->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @empty
                    <p class="text-muted">No has realizado compras aún.</p>
                    @endforelse
                </div>
            </div>
            <style>
                .compras-scroll-container {
                    overflow-x: auto;
                    overflow-y: hidden;
                    width: 100%;
                }
                .compras-scroll-inner {
                    display: flex;
                    flex-direction: row;
                    gap: 1rem;
                    min-width: 0;
                }
                .compra-card {
                    min-width: 320px;
                    max-width: 320px;
                    flex: 0 0 32%;
                }
                @media (max-width: 900px) {
                    .compra-card {
                        min-width: 90vw;
                        max-width: 90vw;
                    }
                }
            </style>
        </div>
    </div>
</div>
@endsection
