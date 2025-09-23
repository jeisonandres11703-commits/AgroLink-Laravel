<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agrolink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/envios.css') }}">
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a512e;" data-bs-theme="light w-100">
        <div class="container-fluid">
            <a class="navbar-brand me-5 d-flex align-items-center" href="{{ route('shipments.dashboard') }}">
                Agrolink
                <img src="{{ asset('images/logo agrolink.jpeg') }}" alt="Agrolink Logo" style="height:36px; width:auto; margin-left:10px; border-radius:6px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vehicles.index') }}">Mis vehículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.carrier') }}">Mi perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shipments.mytrips') }}">Mis viajes</a>
                    </li>
                
                    <li class="nav-item">
                        @if(Auth::check())
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-link" >Cerrar sesión</button>
                        </form>
                    @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="{{ asset('js/enviosscript.js') }}"></script>
</body>

    <footer class="footer mt-5" style="background:#1a512e; color:#fff; text-align:center; padding:1rem 0;">
        <p class="mb-0">© 2025 Agrolink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>