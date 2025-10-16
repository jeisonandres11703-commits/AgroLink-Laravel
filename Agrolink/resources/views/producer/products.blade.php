@extends('layouts.producer')

@section('styles')
    <style>
        .product-card {
            background: #c6dc93;
            border: 1px solid #1a512e;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        .product-card .card-header {
            background: #1a512e;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4" style="color:#1a512e; font-family:'Permanent Marker', cursive;">Mis Productos</h1>
    <div class="mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">Agregar nuevo producto</div>
            <div class="card-body">
                <form action="{{ route('producer.manage-products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="product_name" class="form-label">Nombre</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" required maxlength="100">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="id_category" class="form-label">Categoría</label>
                            <select name="id_category" id="id_category" class="form-select" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach(\App\Models\ProductCategory::all() as $cat)
                                    <option value="{{ $cat->id_categorie }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="product_description" class="form-label">Descripción</label>
                            <textarea name="product_description" id="product_description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="price" class="form-label">Precio</label>
                            <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="images" class="form-label">Imágenes</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="weight_kg" class="form-label">Peso (kg)</label>
                            <input type="number" name="weight_kg" id="weight_kg" class="form-control" min="0" step="0.01" value="1.00" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Crear producto</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="card product-card">
                    <div class="card-header">
                        {{ $product->product_name }}
                    </div>
                    <div class="card-body">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image->file_path) }}" class="product-img mb-2" alt="Imagen producto">
                        @else
                            <img src="{{ asset('img/placeholder.jpg') }}" class="product-img mb-2" alt="Sin imagen">
                        @endif
                        <p><strong>Categoría:</strong> {{ $product->category->category_name ?? '-' }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($product->price, 0, ',', '.') }}</p>
                        <p><strong>Stock:</strong> {{ $product->stock }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('producer.manage-products.edit', $product->id_product) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('producer.manage-products.destroy', $product->id_product) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No tienes productos registrados aún.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
