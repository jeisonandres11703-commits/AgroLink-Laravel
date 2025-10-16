@extends('layouts.appIndex')

@section('content')
<div class="carrusel" style="height: 20rem;">
    <div id="carouselExampleInterval" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100" data-bs-interval="10000">
                <img src='../images/carrusel1.webp' class="d-block w-100 h-100" alt="imagen1">
            </div>
            <div class="carousel-item h-100" data-bs-interval="2000">
                <img src="../images/carrusel2.jpg" class="d-block w-100 h-100" alt="imagen2">
            </div>
            <div class="carousel-item h-100">
                <img src="../images/carrusel3.jpg" class="d-block w-100 h-100" alt="imagen3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="letrero" style="margin-top: 5px;">
    <h2>Productos disponibles</h2>
</div>

<!-------------------------------------Productos---------------------------->
<div class="container-fluid">
    <div class="productos-container">
        @foreach($products as $product)
        <div class="card producto-card">
            <div class="card-img-container">
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" alt="{{ $product->product_name }}">
                @else
                    <!-- Imágenes por defecto según categoría -->
                    @switch($product->id_category)
                        @case(1) <!-- Lácteos -->
                            <img src="{{ asset('img/queso.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(2) <!-- Carnes -->
                            <img src="{{ asset('img/carne.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(3) <!-- Frutas -->
                            <img src="{{ asset('img/platano.png') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(4) <!-- Verduras -->
                            <img src="{{ asset('img/tomate.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(5) <!-- Granos -->
                            <img src="{{ asset('img/frijoles.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(6) <!-- Café -->
                            <img src="{{ asset('img/cafe.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @case(7) <!-- Tubérculos -->
                            <img src="{{ asset('img/papa.jpg') }}" alt="{{ $product->product_name }}">
                            @break
                        @default
                            <img src="{{ asset('img/logoAgrolink.jpg') }}" alt="{{ $product->product_name }}">
                    @endswitch
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $product->product_name }}</h5>
                <p class="card-text">{{ $product->product_description }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Precio: ${{ number_format($product->price, 0, ',', '.') }}</li>
                <li class="list-group-item">Stock: {{ $product->stock }} unidades</li>
                <li class="list-group-item">
                    @switch($product->id_category)
                        @case(1) Lácteos @break
                        @case(2) Carnes @break
                        @case(3) Frutas @break
                        @case(4) Verduras @break
                        @case(5) Granos @break
                        @case(6) Café @break
                        @case(7) Tubérculos @break
                        @default Otros
                    @endswitch
                </li>
            </ul>
            <div class="card-body">
                <a href="{{ route('products.show', ['id' => $product->id_product]) }}" class="card-link" style="text-decoration: none; color: #c6dc93;">Ver Producto</a>
                @auth
                    <button class="btn btn-success btn-sm add-to-cart" data-product-id="{{ $product->id_product }}">
                        Agregar al carrito
                    </button>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-------------------------------------Producto destacado-------------------------->
<div class="destacado">
    <div class="letrero">
        <h2>Producto destacado</h2>
    </div>
    <div class="d-flex justify-content-center">
        @if($featuredProduct)
        <div class="card producto-card" style="max-width: 18rem;">
            <div class="card-img-container">
                @if($featuredProduct->images->count() > 0)
                    <img src="{{ asset('storage/' . $featuredProduct->images->first()->file_path) }}" alt="{{ $featuredProduct->product_name }}">
                @else
                    <img src="{{ asset('img/queso.jpg') }}" alt="{{ $featuredProduct->product_name }}">
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $featuredProduct->product_name }}</h5>
                <p class="card-text">{{ $featuredProduct->product_description }} - Producto Destacado</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Precio: ${{ number_format($featuredProduct->price, 0, ',', '.') }}</li>
                <li class="list-group-item">Stock: {{ $featuredProduct->stock }} unidades</li>
                <li class="list-group-item">
                    @switch($featuredProduct->id_category)
                        @case(1) Lácteos @break
                        @case(2) Carnes @break
                        @case(3) Frutas @break
                        @case(4) Verduras @break
                        @case(5) Granos @break
                        @case(6) Café @break
                        @case(7) Tubérculos @break
                        @default Otros
                    @endswitch
                </li>
            </ul>
            <div class="card-body">
                <a href="{{ route('products.show', ['id' => $product->id_product]) }}" class="card-link" style="text-decoration: none; color: #c6dc93;">Ver Producto</a>
            </div>
        </div>
        @endif
    </div>
</div>

<footer class="footer">
    <p>© 2025 Agrolink. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
@endsection