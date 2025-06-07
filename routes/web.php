<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // CRUD de Clientes
    Route::resource('clients', ClientController::class);
    
    // Rutas adicionales para clientes
    Route::patch('/clients/{client}/activate', [ClientController::class, 'activate'])->name('clients.activate');
    Route::patch('/clients/{client}/deactivate', [ClientController::class, 'deactivate'])->name('clients.deactivate');
    Route::get('/clients-search', [ClientController::class, 'search'])->name('clients.search');
    Route::get('/clients-stats', [ClientController::class, 'stats'])->name('clients.stats');
});

// Rutas API para AJAX (también protegidas)
Route::middleware(['auth'])->prefix('api')->group(function () {
    // API de clientes para búsquedas AJAX
    Route::get('/clients/search', [ClientController::class, 'search'])->name('api.clients.search');
    Route::get('/clients/stats', [ClientController::class, 'stats'])->name('api.clients.stats');
    
    // API REST completa para clientes
    Route::apiResource('clients', ClientController::class, ['as' => 'api']);
    Route::patch('/clients/{client}/activate', [ClientController::class, 'activate'])->name('api.clients.activate');
    Route::patch('/clients/{client}/deactivate', [ClientController::class, 'deactivate'])->name('api.clients.deactivate');
});
