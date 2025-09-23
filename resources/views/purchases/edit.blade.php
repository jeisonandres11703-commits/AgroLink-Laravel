@extends('layouts.appIndex')

@section('content')
<div class="container">
    <h1>Editar Compra #{{ $purchase->id_purchase }}</h1>

    <form action="{{ route('purchases.update', $purchase) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label for="payment_method">Método de pago</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="Efectivo" {{ $purchase->payment_method == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="Transferencia" {{ $purchase->payment_method == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                <option value="Tarjeta de crédito" {{ $purchase->payment_method == 'Tarjeta de crédito' ? 'selected' : '' }}>Tarjeta de crédito</option>
            </select>
            <label for="delivery_address">Direccion De Entrega</label>
            <input type="text" name="delivery_address" id="delivery_address" class="form-control" value="{{ $purchase->delivery_address }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
@endsection