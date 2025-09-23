@extends('layouts.loginly')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-container ms-5">
                    <!-- Encabezado -->
                    <div class="login-header">
                        <h2><i class="fas fa-leaf me-2"></i>Agrolink</h2>
                        <p>Accede a tu cuenta agrícola</p>
                    </div>
                    
                    <!-- Cuerpo del formulario -->
                    <div class="login-body">
                         <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="user_name" class="form-label">User Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input  class="form-control" id="user_name" name="user_name" placeholder="usernameEjemplo123" value="{{ old('user_name') }}" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Recordar mi cuenta</label>
                            </div>
                            
                            <button type="submit" class="btn btn-login mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar sesión
                            </button>

                             @error('login')
                                <div style="color:red">{{ $message }}</div>
                             @enderror
                            
                            <div class="text-center mb-3">
                                <a href="#">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Pie de página -->
                    <div class="login-footer">
                        ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
@endsection




