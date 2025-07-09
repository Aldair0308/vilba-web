<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CraneController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

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

// Rutas principales con soporte de idioma
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/acerca', [HomeController::class, 'about'])->name('about');
Route::get('/contacto', [HomeController::class, 'contact'])->name('contact');
Route::get('/servicios', [HomeController::class, 'services'])->name('services');
Route::get('/equipos', [HomeController::class, 'equipos'])->name('equipos');
Route::get('/equipos/{slug}', [HomeController::class, 'equiposDetail'])->name('equipos.detail');
Route::get('/detalle-servicio', [HomeController::class, 'servicesDetails'])->name('services-detail');

// Rutas específicas por idioma
Route::prefix('ES')->group(function () {
    Route::get('/', [HomeController::class, 'indexEs'])->name('home.ES');
    Route::get('/acerca', [HomeController::class, 'aboutEs'])->name('about.ES');
    Route::get('/contacto', [HomeController::class, 'contactEs'])->name('contact.ES');
    Route::get('/servicios', [HomeController::class, 'servicesEs'])->name('services.ES');
    Route::get('/equipos', [HomeController::class, 'equiposEs'])->name('equipos.ES');
    Route::get('/equipos/{slug}', [HomeController::class, 'equiposDetailEs'])->name('equipos.detail.ES');
    Route::get('/detalle-servicio', [HomeController::class, 'servicesDetailsEs'])->name('services-detail.ES');
    
});

Route::prefix('EN')->group(function () {
    Route::get('/', [HomeController::class, 'indexEn'])->name('home.EN');
    Route::get('/about', [HomeController::class, 'aboutEn'])->name('about.EN');
    Route::get('/contact', [HomeController::class, 'contactEn'])->name('contact.EN');
    Route::get('/services', [HomeController::class, 'servicesEn'])->name('services.EN');
    Route::get('/equipment', [HomeController::class, 'equiposEn'])->name('equipos.EN');
    Route::get('/equipment/{slug}', [HomeController::class, 'equiposDetailEn'])->name('equipos.detail.EN');
    Route::get('/detalle-servicio', [HomeController::class, 'servicesDetailsEn'])->name('services-detail.EN');
});

// Ruta para cambiar idioma
Route::get('/cambiar-idioma/{language}', [HomeController::class, 'changeLanguage'])->name('change.language');
Route::post('/cambiar-idioma/{language}', [HomeController::class, 'changeLanguage'])->name('change.language.post');


// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    // CRUD de Grúas
    Route::resource('cranes', CraneController::class);
    
    // Rutas adicionales para grúas
    Route::patch('/cranes/{crane}/activate', [CraneController::class, 'activate'])->name('cranes.activate');
Route::patch('/cranes/{crane}/deactivate', [CraneController::class, 'deactivate'])->name('cranes.deactivate');
Route::patch('/cranes/{crane}/maintenance', [CraneController::class, 'setMaintenance'])->name('cranes.maintenance');
Route::patch('/cranes/{crane}/rented', [CraneController::class, 'setRented'])->name('cranes.rented');
    Route::get('/cranes-stats', [CraneController::class, 'stats'])->name('cranes.stats');
    
    // Rutas para gestión de zonas de precios
    Route::post('/cranes/{crane}/price-zones', [CraneController::class, 'addPriceZone'])->name('cranes.price-zones.store');
    Route::put('/cranes/{crane}/price-zones/{zona}', [CraneController::class, 'updatePriceZone'])->name('cranes.price-zones.update');
    Route::delete('/cranes/{crane}/price-zones/{zona}', [CraneController::class, 'removePriceZone'])->name('cranes.price-zones.destroy');
    
    // CRUD de Archivos
    Route::resource('files', FileController::class);
    
    // Rutas adicionales para archivos
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::get('/files/{file}/preview', [FileController::class, 'preview'])->name('files.preview');
    Route::get('/files-search', [FileController::class, 'search'])->name('files.search');
    Route::get('/files-stats', [FileController::class, 'stats'])->name('files.stats');
    
    // CRUD de Cotizaciones
    Route::resource('quotes', QuoteController::class);
    
    // Rutas adicionales para cotizaciones
    Route::patch('/quotes/{quote}/status', [QuoteController::class, 'changeStatus'])->name('quotes.change-status');
    Route::get('/quotes/client/{client}', [QuoteController::class, 'byClient'])->name('quotes.by-client');
    Route::get('/quotes-stats', [QuoteController::class, 'stats'])->name('quotes.stats');
    
    // Rutas para usuarios
    Route::resource('users', UserController::class);
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/users-stats', [UserController::class, 'stats'])->name('users.stats');
    
    // CRUD de Logs (solo lectura)
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{log}', [LogController::class, 'show'])->name('logs.show');
    
    // Rutas adicionales para logs
    Route::get('/logs-search', [LogController::class, 'search'])->name('logs.search');
    Route::get('/logs-stats', [LogController::class, 'stats'])->name('logs.stats');
    Route::get('/logs-export', [LogController::class, 'export'])->name('logs.export');
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
    
    // API para gestión de zonas de precios de grúas
    Route::post('/cranes/{crane}/price-zones', [CraneController::class, 'addPriceZone'])->name('api.cranes.price-zones.store');
    Route::put('/cranes/{crane}/price-zones/{zona}', [CraneController::class, 'updatePriceZone'])->name('api.cranes.price-zones.update');
    Route::delete('/cranes/{crane}/price-zones/{zona}', [CraneController::class, 'removePriceZone'])->name('api.cranes.price-zones.destroy');
    Route::get('/cranes-stats', [CraneController::class, 'stats'])->name('api.cranes.stats');
    
    // API de archivos para búsquedas AJAX
    Route::get('/files/search', [FileController::class, 'search'])->name('api.files.search');
    Route::get('/files/stats', [FileController::class, 'stats'])->name('api.files.stats');
    
    // API de cotizaciones para búsquedas AJAX
    Route::get('/quotes/search', [QuoteController::class, 'search'])->name('api.quotes.search');
    Route::get('/quotes/stats', [QuoteController::class, 'stats'])->name('api.quotes.stats');
    Route::get('/quotes/client/{client}', [QuoteController::class, 'byClient'])->name('api.quotes.by-client');
    
    // API REST completa para cotizaciones
    Route::apiResource('quotes', QuoteController::class, ['as' => 'api']);
    Route::patch('/quotes/{quote}/status', [QuoteController::class, 'changeStatus'])->name('api.quotes.change-status');
    
    // API REST completa para archivos
    Route::apiResource('files', FileController::class, ['as' => 'api']);
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('api.files.download');
    
    // API de usuarios para búsquedas AJAX
    Route::get('/users/search', [UserController::class, 'search'])->name('api.users.search');
    Route::get('/users/stats', [UserController::class, 'stats'])->name('api.users.stats');
    
    // API REST completa para usuarios
    Route::apiResource('users', UserController::class, ['as' => 'api']);
    
    // API de logs para búsquedas AJAX
    Route::get('/logs/search', [LogController::class, 'search'])->name('api.logs.search');
    Route::get('/logs/stats', [LogController::class, 'stats'])->name('api.logs.stats');
    Route::get('/logs/export', [LogController::class, 'export'])->name('api.logs.export');
    
    // API REST para logs (solo lectura)
    Route::get('/logs', [LogController::class, 'index'])->name('api.logs.index');
    Route::get('/logs/{log}', [LogController::class, 'show'])->name('api.logs.show');
    
    // API de dashboard para estadísticas
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('api.dashboard.stats');
});
