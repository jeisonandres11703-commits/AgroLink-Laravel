<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Productor - Agrolink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clienteIndex.css') }}">
    <style>
        .navbar-producer {
            background: #1a512e;
        }
        .producer-sidebar {
            background: #c6dc93;
            min-height: 100vh;
        }
        .producer-content {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 2rem;
        }
        .producer-navbar-brand {
            font-family: 'Chewy', cursive;
            color: #fff;
            font-size: 2rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a512e;" data-bs-theme="light w-100">
        <div class="container-fluid">
            <a class="navbar-brand me-5 d-flex align-items-center" style="font-family: 'Chewy', cursive; font-size:2rem;" href="{{ route('producer.dashboard') }}">
                Agrolink
                <img src="{{ asset('images/logo agrolink.jpeg') }}" alt="Agrolink Logo" style="height:36px; width:auto; margin-left:10px; border-radius:6px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarProducer">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarProducer">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('producer.dashboard') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('producer.orders') }}">Mis Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('producer.products') }}">Mis Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('producer.profile') }}">Perfil</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="producer-content">
        @yield('content')
    </div>
    <footer class="footer mt-5" style="background:#1a512e; color:#fff; text-align:center; padding:1rem 0;">
        <p class="mb-0">© 2025 Agrolink. Todos los derechos reservados.</p>
    </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
