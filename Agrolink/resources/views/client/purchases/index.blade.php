@extends('layouts.appIndex')

@section('content')
    <h1>Mis Compras</h1>
    <a href="{{ route('compras.create') }}">Nueva Compra</a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        @foreach($compras as $c)
            <tr>
                <td>{{ $c->id_purchase }}</td>
                <td>{{ $c->purchase_datetime }}</td>
                <td>{{ $c->total }}</td>
                <td>
                    <a href="{{ route('compras.show', $c) }}">Ver</a>
                    <a href="{{ route('compras.edit', $c) }}">Editar</a>
                    <form action="{{ route('purchases.destroy', $purchase->id_purchase) }}" method="POST"></form>
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete Purchase</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection