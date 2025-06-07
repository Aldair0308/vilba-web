<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();
        
        if ($user && $this->verifyPassword($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido de vuelta!');
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }
    
    /**
     * Verificar contraseña con múltiples algoritmos
     */
    private function verifyPassword($plainPassword, $hashedPassword)
    {
        // Intentar verificar con Bcrypt primero
        if (Hash::check($plainPassword, $hashedPassword)) {
            return true;
        }
        
        // Si no es Bcrypt, intentar con otros algoritmos comunes
        // MD5
        if (md5($plainPassword) === $hashedPassword) {
            return true;
        }
        
        // SHA1
        if (sha1($plainPassword) === $hashedPassword) {
            return true;
        }
        
        // SHA256
        if (hash('sha256', $plainPassword) === $hashedPassword) {
            return true;
        }
        
        // Verificar si es una contraseña en texto plano (no recomendado)
        if ($plainPassword === $hashedPassword) {
            return true;
        }
        
        return false;
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Mostrar el formulario de registro
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Procesar el registro
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', '¡Cuenta creada exitosamente!');
    }

    /**
     * Dashboard del usuario autenticado
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Mostrar información del usuario actual
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }
}