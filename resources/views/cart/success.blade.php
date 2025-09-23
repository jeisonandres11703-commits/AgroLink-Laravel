@extends('layouts.appIndex')

@section('content')
<div class="container">
    <h2 class="mb-4"> Compra realizada con éxito</h2>

    <div class="card">
        <div class="card-body">
            <h5>Resumen de la compra #{{ $purchase->id_purchase }}</h5>
            <p><strong>Método de pago:</strong> {{ $purchase->payment_method }}</p>
            <p><strong>Dirección de entrega:</strong> {{ $purchase->delivery_address }}</p>
            <p><strong>Subtotal:</strong> ${{ number_format($purchase->subtotal, 0) }}</p>
            <p><strong>Impuestos:</strong> ${{ number_format($purchase->taxes, 0) }}</p>
            <p><strong>Envío:</strong> ${{ number_format($purchase->shipment_value, 0) }}</p>
            <p><strong>Total:</strong> ${{ number_format($purchase->total, 0) }}</p>
        </div>
    </div>

    <h5 class="mt-4"> Productos comprados</h5>
    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase->details as $detail)
            <tr>
                <td>{{ $detail->product->product_name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>${{ number_format($detail->unit_price, 0) }}</td>
                <td>${{ number_format($detail->subtotal, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection