@extends('layouts.producer')

@section('styles')
    <style>
        .dashboard-title {
            color: #1a512e;
            font-family: 'Permanent Marker', cursive;
        }
        .order-card {
            background: #c6dc93;
            border: 1px solid #1a512e;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        .order-card .card-header {
            background: #1a512e;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
        .order-product-list {
            background: #f8f9fa;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <h1 class="dashboard-title mb-4">Pedidos Recibidos</h1>
    <div class="row">
        @forelse($orders as $order)
            <div class="col-md-6">
                <div class="card order-card">
                    <div class="card-header">
                        Pedido #{{ $order->id_purchase }} - {{ $order->client->user->Name ?? 'Cliente' }}
                    </div>
                    <div class="card-body">
                        <p><strong>Fecha:</strong> {{ $order->purchase_datetime ? $order->purchase_datetime->format('d/m/Y H:i') : '-' }}</p>
                        <p><strong>Dirección de entrega:</strong> {{ $order->delivery_address }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total, 0, ',', '.') }}</p>
                        <div class="order-product-list p-2 rounded">
                            <strong>Productos:</strong>
                            <ul class="mb-0">
                                @foreach($order->details as $detail)
                                    <li>{{ $detail->product->product_name ?? '' }} x {{ $detail->quantity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No tienes pedidos aún.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
