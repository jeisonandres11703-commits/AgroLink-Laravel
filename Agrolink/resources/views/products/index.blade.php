@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Catálogo de Productos</h2>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $product->product_name }}</h5>
                        <p>{{ $product->product_description }}</p>
                        <p><strong>${{ number_format($product->price, 0) }}</strong></p>
                        <a href="{{ route('products.show', $product->id_product) }}" class="btn btn-primary">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection