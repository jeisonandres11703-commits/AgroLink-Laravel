@extends('layouts.appIndex')

@section('content')
<div class="container">
    <h1 class="mb-4">Registro de Usuario</h1>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
            <label for="Name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Name" name="Name" required>
        </div>
        <div class="mb-3">
            <label for="last_Name" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="last_Name" name="last_Name" required>
        </div>
        <div class="mb-3">
            <label for="user_name" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
        </div>
        <div class="mb-3">
            <label for="user_password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="user_password" name="user_password" required>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="Email" name="Email" required>
        </div>
        <div class="mb-3">
            <label for="City" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="City" name="City" required>
        </div>
        <div class="mb-3">
            <label for="Department" class="form-label">Departamento</label>
            <input type="text" class="form-control" id="Department" name="Department" required>
        </div>
        <div class="mb-3">
            <label for="Direction" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direction" name="Direction" required>
        </div>
        <div class="mb-3">
            <label for="ID_Card" class="form-label">Cédula</label>
            <input type="text" class="form-control" id="ID_Card" name="ID_Card" required>
        </div>
        <div class="mb-3">
            <label for="Phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Phone" name="Phone" required value="0000000000">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-control" id="role" name="role" required>
                <option value="client">Cliente</option>
                <option value="producer">Productor</option>
                <option value="advicer">Asesor</option>
                <option value="carrier">Transportista</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>
@endsection
