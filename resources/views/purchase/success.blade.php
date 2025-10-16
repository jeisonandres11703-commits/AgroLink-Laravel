@extends('layouts.app')

@section('content')
<div class="container">
    <h2>¡Compra realizada con éxito!</h2>
    <p>Tu pedido ha sido registrado. El productor recibirá la orden y pronto se gestionará el envío.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Volver al catálogo</a>
</div>
@endsection