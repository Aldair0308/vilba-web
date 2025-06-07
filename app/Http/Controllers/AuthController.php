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

        // LOGS DE DEBUG
        \Log::info('=== LOGIN DEBUG ===');
        \Log::info('Email recibido: ' . $request->email);
        \Log::info('Password recibido (primeros 20 chars): ' . substr($request->password, 0, 20));
        \Log::info('Password length: ' . strlen($request->password));
        \Log::info('Password starts with $2: ' . (str_starts_with($request->password, '$2') ? 'YES' : 'NO'));

        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            \Log::info('Usuario encontrado: ' . $user->email);
            \Log::info('Password almacenado (primeros 20 chars): ' . substr($user->password, 0, 20));
            \Log::info('Password almacenado length: ' . strlen($user->password));
            \Log::info('Password almacenado starts with $2: ' . (str_starts_with($user->password, '$2') ? 'YES' : 'NO'));
            
            if ($this->verifyPassword($request->password, $user->password)) {
                \Log::info('Password verification: SUCCESS');
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended('/dashboard')->with('success', '¡Bienvenido de vuelta!');
            } else {
                \Log::info('Password verification: FAILED');
            }
        } else {
            \Log::info('Usuario NO encontrado');
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }
    
    /**
     * Verificar contraseña con múltiples algoritmos
     */
    private function verifyPassword($plainPassword, $storedPassword)
    {
        \Log::info('=== VERIFY PASSWORD DEBUG ===');
        \Log::info('Plain password: ' . $plainPassword);
        \Log::info('Stored password: ' . $storedPassword);
        
        // Intentar verificar con Bcrypt primero (método recomendado)
        try {
            \Log::info('Intentando Hash::check...');
            if (Hash::check($plainPassword, $storedPassword)) {
                \Log::info('Hash::check SUCCESS');
                return true;
            }
            \Log::info('Hash::check FAILED');
        } catch (\Exception $e) {
            \Log::error('Hash::check ERROR: ' . $e->getMessage());
        }
        
        // Si no es Bcrypt, intentar con otros algoritmos comunes para compatibilidad
        // MD5
        $md5Hash = md5($plainPassword);
        \Log::info('MD5 hash: ' . $md5Hash);
        if ($md5Hash === $storedPassword) {
            \Log::info('MD5 match SUCCESS');
            return true;
        }
        
        // SHA1
        $sha1Hash = sha1($plainPassword);
        \Log::info('SHA1 hash: ' . $sha1Hash);
        if ($sha1Hash === $storedPassword) {
            \Log::info('SHA1 match SUCCESS');
            return true;
        }
        
        // SHA256
        $sha256Hash = hash('sha256', $plainPassword);
        \Log::info('SHA256 hash: ' . $sha256Hash);
        if ($sha256Hash === $storedPassword) {
            \Log::info('SHA256 match SUCCESS');
            return true;
        }
        
        // Verificar si es una contraseña en texto plano (no recomendado, solo para compatibilidad)
        if ($plainPassword === $storedPassword) {
            \Log::info('Plain text match SUCCESS');
            return true;
        }
        
        \Log::info('All verification methods FAILED');
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