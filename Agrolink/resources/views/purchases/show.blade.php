@extends('layouts.appIndex')

@section('content')
<div class="container">
    <h1>Detalle de la Compra #{{ $purchase->id_purchase }}</h1>

    <p><strong>Fecha:</strong> {{ $purchase->purchase_datetime }}</p>
    <p><strong>Método de pago:</strong> {{ $purchase->payment_method }}</p>
    <p><strong>Total:</strong> ${{ number_format($purchase->total, 0, ',', '.') }}</p>

    <h3>Productos</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Direccion de Entrega</th>
                <th>Impuestos</th>
                <th>Costo de Envio</th>


            </tr>
        </thead>
        <tbody>
            @foreach($purchase->details as $detalle)
                <tr>
                    <td>{{ $detalle->product->product_name }}</td>
                    <td>{{ $detalle->quantity }}</td>
                    <td>${{ number_format($detalle->unit_price, 0, ',', '.') }}</td>
                    <td>${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $purchase->delivery_address ?? 'Sin dirección registrada' }}</td>
                    <td>${{ number_format($purchase->taxes, 0, ',', '.') }}</td>
                    <td>${{ number_format($purchase->shipment_value, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection