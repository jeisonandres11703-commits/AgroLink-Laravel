<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrolink - Inde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Honk:SHLN@31.6&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clienteIndex.css') }}">

    @yield('styles')
   
</head>
<body>
     
<div class="barranav">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a512e;" data-bs-theme="light w-100">
            <div class="container-fluid">
                <a class="navbar-brand me-5" font="Chewy" href="#">Agrolink</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.html">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Servicios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Veterinario</a></li>
                                <li><a class="dropdown-item" href="#">Asesorias agricolas</a></li>
                                <li><a class="dropdown-item" href="#">Maquinarias</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/servicios.html">Ver todos los servicios publicados</a></li>
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

                                <li><hr class="dropdown-divider"></li>
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
                                <a class="nav-link" href=""><i class="bi bi-person"></i>Mis Compras</a>
                        </li>
                        <li class="nav-item me-5">
                                <a class="nav-link" href=""><i class="bi bi-person"></i>Perfil</a>
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
    </div>

     <div class="contenedor">
        @yield('content') <!-- ¡Esta línea es crucial! -->
    </div>
</body>
</html>