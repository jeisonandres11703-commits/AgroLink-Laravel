<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agrolink - Inde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Chewy&family=Honk:SHLN@31.6&family=Permanent+Marker&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clienteIndex.css') }}">

    @yield('styles')

</head>

<body>

    <div class="barranav">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a512e;" data-bs-theme="light w-100">
            <div class="container-fluid">
                <a class="navbar-brand me-5 d-flex align-items-center" font="Chewy" href="{{ route('client.home') }}">
                    Agrolink
                    <img src="{{ asset('images/logo agrolink.jpeg') }}" alt="Agrolink Logo" style="height:36px; width:auto; margin-left:10px; border-radius:6px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('client.home') }}">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Servicios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Veterinario</a></li>
                                <li><a class="dropdown-item" href="#">Asesorias agricolas</a></li>
                                <li><a class="dropdown-item" href="#">Maquinarias</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/servicios.html">Ver todos los servicios
                                        publicados</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Categorías
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Frutas</a></li>
                                <li><a class="dropdown-item" href="#">Verduras</a></li>
                                <li><a class="dropdown-item" href="#">Hortalizas</a></li>
                                <li><a class="dropdown-item" href="#">Cereales</a></li>
                                <li><a class="dropdown-item" href="#">Tuberculos y raices </a></li>
                                <li><a class="dropdown-item" href="#">Café y especias</a></li>
                                <li><a class="dropdown-item" href="#">Frutos secos</a></li>
                                <li><a class="dropdown-item" href="#">Flores y plantas ornamentales</a></li>
                                <li><a class="dropdown-item" href="#">Lácteos y derivados</a></li>
                                <li><a class="dropdown-item" href="#">Animales</a></li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"> Ver todos los productos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex me-5">
                        <input class="form-control me-2" type="search" placeholder="Buscar...">
                        <button class="btn btn-outline-light" type="submit">Buscar</button>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item me-5">
                            <a class="nav-link" href="{{ route('purchases.index') }}">
                                <i class="bi bi-bag-check"></i> Mis Compras
                            </a>
                        </li>
                        <li class="nav-item me-5">
                            
                            <a href="{{ route('cart.show') }}" class="btn btn-outline-success">
                                Ver Carrito
                            </a>
                        </li>


                        <li class="nav-item me-5">
                            <a class="nav-link" href="{{ route('profile.client') }}"><i class="bi bi-person"></i>Perfil</a>
                        </li>
                        <li class="nav-item">
                            @if(Auth::check())
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="nav-link">Cerrar sesión</button>
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="contenedor">
        @yield('content')
    </div>
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/cart.js') }}"></script>
    <style>
        .cart-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
            background: #1a512e;
            color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            font-size: 2rem;
            cursor: pointer;
        }
        .cart-float .badge {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 0.9em;
        }
    </style>
    <a href="{{ route('cart.index') }}" class="cart-float">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-float-count" class="badge bg-danger">{{ count(session('cart', [])) }}</span>
    </a>
</script>
    @yield('scripts')
    @stack('scripts')
</body>

   
</body>
</html>