@extends('layouts.appIndex')

@section('content')
    <div class="container">
        <h2 class="mb-4"> Carrito de Compras</h2>

        @if(count($cart) > 0)
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>${{ number_format($item['price'], 0) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product_id']) }}" method="POST"
                                    class="d-flex align-items-center">
                                    @csrf
                                    <input type="number" name="quantity" min="1"
                                        max="{{ \App\Models\Product::find($item['product_id'])->stock }}"
                                        value="{{ $item['quantity'] }}" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-outline-primary btn-sm ms-2">Actualizar</button>
                                </form>
                            </td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 0) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="delivery_address" class="form-label">Dirección de envío</label>
                    <input type="text" name="delivery_address" id="delivery_address" class="form-control" required
                        maxlength="100" placeholder="Ej. Calle 123 #45-67, Bogotá" value="{{ old('delivery_address') }}">
                </div>
                <button type="submit" class="btn btn-primary">Confirmar Compra</button>
            </form>
        @else
            <div class="alert alert-info">Tu carrito está vacío.</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
