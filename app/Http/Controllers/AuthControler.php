<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthControler extends Controller
{
    // Muestra tu vista HTML de login
    public function showLogin()
    {
        // Por qué: si ya hay sesión, no tiene sentido mostrar login; redirigimos según su rol.
        if (Auth::check()) {
            return redirect($this->redirectPathFor(Auth::user()));
        }
        return view('auth.login'); // Usa tu HTML existente en resources/views/auth/login.blade.php
    }

    // Procesa el login
    public function login(Request $request)
    {
        // Por qué: validamos inputs mínimos y coherentes con tu formulario HTML
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Importante: "password" (no user_password) porque Auth::attempt espera esa llave.
        // Tu getAuthPassword() hace el puente a user_password en BD.
        $credentials = [
            'user_name' => $request->user_name,
            'password' => $request->password,
        ];

        // Si quisieras "remember me", necesitarías columna remember_token en tb_users.
        $remember = false;

        // Por qué: Auth::attempt hace el hashing-compare contra user_password, regenera sesión si ok.
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPathFor(Auth::user()));
        }

        // Por qué: no exponemos cuál campo falló por seguridad.
        return back()
            ->withErrors(['login' => 'Usuario o contraseña incorrectos'])
            ->withInput($request->only('user_name'));
    }

    // Cierra sesión con limpieza de sesión y token CSRF
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Decide a dónde aterriza cada usuario tras login, según sus tablas-rol
    protected function redirectPathFor(User $user): string
    {
        // Por qué: tus roles están normalizados en tablas; exists() es barato y claro.
        if (DB::table('tb_administrators')->where('id_user', $user->id_user)->exists()) {
            return route('admin.home');
        }
        if (DB::table('tb_advicer')->where('id_user', $user->id_user)->exists()) {
            return route('advisor.home');
        }
        if (DB::table('tb_carrier')->where('id_user', $user->id_user)->exists()) {
            return route('carrier.home');
        }
        if (DB::table('tb_producers')->where('id_user', $user->id_user)->exists()) {
            return route('producer.home');
        }
        if (DB::table('tb_client')->where('id_user', $user->id_user)->exists()) {
            return route('client.home');
        }

        // Fallback útil: catálogo
        return route('products.index');
    }
}