@extends('layouts.appIndex')

@section('title', $product->product_name . ' - Agrolink')

@section('styles')
    <!-- Agregar FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .product-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .product-main {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        .product-image {
            flex: 1;
            min-width: 300px;
        }

        .product-image img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            flex: 2;
            min-width: 300px;
            background-color: #c6dc93;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .product-title {
            font-size: 28px;
            font-weight: bold;
            color: #212121;
            margin-bottom: 5px;
        }

        .product-seller {
            font-size: 16px;
            color: #666;
            font-style: italic;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 24px;
            color: #1b5e20;
            margin-bottom: 15px;
        }

        .product-description {
            font-size: 16px;
            line-height: 1.6;
            color: #120101;
            margin-bottom: 20px;
        }

        .product-stock {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .product-stock .fa-check-circle {
            color: #388e3c;
        }

        .product-stock .fa-times-circle {
            color: #dc3545;
        }

        .purchase-form {
            background-color: #a8c97f;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group select, 
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #1a512e;
            font-size: 14px;
        }

        .btn-comprar {
            background-color: #1a512e;
            color: #c6dc93;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-comprar:hover:not(:disabled) {
            background-color: #388e3c;
        }

        .btn-comprar:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .btn-carrito {
            background-color: #c6dc93;
            color: #1a512e;
            padding: 12px 25px;
            border: 2px solid #1a512e;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-carrito:hover:not(:disabled) {
            background-color: #a8c97f;
        }

        .btn-carrito:disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            cursor: not-allowed;
        }

        .similar-products {
            margin-top: 40px;
        }

        .similar-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #1a512e;
        }

        .similar-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .similar-product {
            width: 180px;
            background-color: #c6dc93;
            border: 1px solid #1a512e;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .similar-product:hover {
            transform: translateY(-5px);
        }

        .similar-product img {
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .similar-product h6 {
            font-size: 14px;
            color: #444;
            margin-bottom: 5px;
        }

        .similar-price {
            font-size: 14px;
            color: #1b5e20;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .product-main {
                flex-direction: column;
            }
            
            .product-info {
                padding: 20px;
            }
            
            .similar-product {
                width: 45%;
            }
        }

        @media screen and (max-width: 480px) {
            .similar-product {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
<div class="product-container">
    <div class="product-main">
        <!-- Imagen del producto -->
        <div class="product-image">
            @if($product->images->count() > 0)
                <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" 
                     alt="{{ $product->product_name }}"
                     class="img-fluid">
            @else
                <img src="{{ asset('img/placeholder.jpg') }}" 
                     alt="Imagen no disponible"
                     class="img-fluid">
            @endif
        </div>

        <!-- Información del producto -->
        <div class="product-info">
            <h1 class="product-title">{{ $product->product_name }}</h1>
            <div class="product-seller">
                Vendido Por: {{ $product->producer->user->Name ?? 'Productor' }} {{ $product->producer->user->last_Name ?? '' }}
            </div>
            
            <div class="product-price">
                ${{ number_format($product->price, 0, ',', '.') }} 
                <br>
                <small>
                    @if($product->weight_kg)
                        Peso en kg {{ $product->weight_kg }} - 
                        Precio por Kg {{ number_format($product->price / $product->weight_kg, 0, ',', '.') }}$
                    @endif
                </small>
            </div>
            
            <div class="product-description">
                {{ $product->product_description }}
            </div>
            
            <div class="product-stock">
                <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }} me-2"></i>
                {{ $product->stock > 0 ? 'Stock Disponible (' . $product->stock . ' unidades)' : 'Agotado' }}
            </div>

            <!-- Formulario de compra -->
            @auth
            <div class="purchase-form">
                <form action="{{ route('purchase.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id_product }}">
                    
                    <div class="form-group">
                        <label for="quantity">Cantidad:</label>
                        <select name="quantity" id="quantity" required {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <option value="" disabled selected>Selecciona la cantidad</option>
                            @for($i = 1; $i <= min(10, $product->stock); $i++)
                                <option value="{{ $i }}">{{ $i }} unidad(es)</option>
                            @endfor
                            @if($product->stock > 10)
                                <option value="more">Más de 10...</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección de envío:</label>
                        <textarea name="address" id="address" rows="3" required 
                                  placeholder="Ingresa tu dirección de envío"
                                  {{ $product->stock == 0 ? 'disabled' : '' }}>{{ Auth::user()->Direction ?? '' }}</textarea>
                        <small class="text-muted">Puedes modificar tu dirección actual si es necesario</small>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Método de pago:</label>
                        <select name="payment_method" id="payment_method" required {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <option value="Efectivo"> Efectivo</option>
                            <option value="Transferencia"> Transferencia</option>
                            <option value="Targeta De Credito"> Tarjeta de crédito</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-comprar" {{ $product->stock == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart me-2"></i>Comprar ahora
                    </button>
                </form>
                
                <button class="btn-carrito" onclick="addToCart({{ $product->id_product }})" {{ $product->stock == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-plus me-2"></i>Agregar al carrito
                </button>
            </div>
            @else
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Debes <a href="{{ route('login') }}" class="alert-link">iniciar sesión</a> para realizar compras
            </div>
            @endauth
        </div>
    </div>

    <!-- Productos similares -->
    @if(isset($similarProducts) && $similarProducts->count() > 0)
    <div class="similar-products">
        <h2 class="similar-title">¡Productos similares!</h2>
        <div class="similar-container">
            @foreach($similarProducts as $similar)
            <div class="similar-product">
                @if($similar->images->count() > 0)
                    <img src="{{ asset('storage/' . $similar->images->first()->file_path) }}" 
                         alt="{{ $similar->product_name }}">
                @else
                    <img src="{{ asset('img/placeholder.jpg') }}" 
                         alt="Imagen no disponible">
                @endif
                <h6>{{ $similar->product_name }}</h6>
                <div class="similar-price">${{ number_format($similar->price, 0, ',', '.') }}</div>
                <a href="{{ route('products.show', $similar->id_product) }}" class="btn btn-sm btn-success mt-2">Ver producto</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function addToCart(productId) {
    // Lógica para agregar al carrito
    alert('Producto ' + productId + ' agregado al carrito');
}

// Validación del formulario
document.querySelector('form')?.addEventListener('submit', function(e) {
    const quantity = document.getElementById('quantity').value;
    const address = document.getElementById('address').value;
    
    if (!quantity || quantity === '') {
        e.preventDefault();
        alert('Por favor selecciona una cantidad');
        return false;
    }
    
    if (!address.trim()) {
        e.preventDefault();
        alert('Por favor ingresa una dirección de envío');
        return false;
    }
});
</script>
@endsection