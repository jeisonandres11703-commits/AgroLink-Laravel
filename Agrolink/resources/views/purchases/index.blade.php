@extends('layouts.appIndex')

@section('content')
    <div class="container">
        <h1 class="mb-4">Mis Compras</h1>

        @if($purchases->isEmpty())
            <div class="alert alert-info">
                No tienes compras registradas.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Compra</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>

                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id_purchase }}</td>
                            <td>{{ $purchase->details->sum('quantity') }}</td>
                            <td>{{ $purchase->details->first()->product->product_name ?? 'N/A' }}</td>

                            <td>${{ number_format($purchase->total, 2) }}</td>
                            <td>{{ $purchase->purchase_datetime ? \Carbon\Carbon::parse($purchase->purchase_datetime)->format('d/m/Y H:i:s') : 'Sin fecha' }}</td>
                            <td>{{ $purchase->shipment->shipment_status ?? 'Sin estado' }}</td>
                            <td>

                                <a href="{{ route('purchases.show', $purchase->id_purchase) }}" class="btn btn-info btn-sm">Ver</a>


                                <form action="{{ route('purchases.destroy', $purchase->id_purchase) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de cancelar esta compra?')">
                                        Cancelar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection