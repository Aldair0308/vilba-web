<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route for registering FCM web tokens
Route::middleware('auth')->post('/register-web-token', function (Request $request) {
    try {
        $request->validate([
            'token' => 'required|string',
            'platform' => 'required|string|in:web,android,ios'
        ]);

        $user = auth()->user();
        $token = $request->input('token');
        $platform = $request->input('platform');

        // Here you can save the token to database or send to external service
        // For now, we'll just log it and return success
        \Log::info('FCM Token registered', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'token' => $token,
            'platform' => $platform,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Token registrado exitosamente',
            'data' => [
                'user_id' => $user->id,
                'platform' => $platform,
                'registered_at' => now()->toISOString()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar token: ' . $e->getMessage()
        ], 500);
    }
});

// Ruta temporal para crear logs de prueba (SOLO PARA DEBUG)
Route::middleware('auth')->post('/create-test-log', function () {
    try {
        $user = auth()->user();
        
        $testLog = Log::createLog(
            $user->id,
            $user->name,
            Log::ACTION_UPDATE,
            Log::MODULE_USER,
            'test-' . time(),
            'Prueba de actualización automática',
            null,
            null,
            'Log de prueba creado en ' . now()->format('Y-m-d H:i:s')
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Log de prueba creado exitosamente',
            'log' => [
                'id' => $testLog->id,
                'createdAt' => $testLog->createdAt->toISOString(),
                'description' => $testLog->description
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al crear log de prueba: ' . $e->getMessage()
        ], 500);
    }
});

// Ruta para obtener logs recientes para el dashboard
Route::middleware('auth')->get('/recent-logs', function () {
    try {
        // Agregar timestamp para evitar caché
        $timestamp = now()->timestamp;
        
        // Obtener logs más recientes sin caché
        $recentLogs = Log::orderBy('createdAt', 'desc')
            ->limit(6)
            ->get();
        
        $formattedLogs = $recentLogs->map(function ($log) {
            return [
                'id' => $log->id,
                'userName' => is_array($log->userName) ? 'Sistema' : ($log->userName ?? 'Sistema'),
                'userInitial' => strtoupper(substr(is_array($log->userName) ? 'S' : ($log->userName ?? 'S'), 0, 1)),
                'action' => is_array($log->formatted_action) ? 'Acción del Sistema' : ($log->formatted_action ?? $log->action),
                'actionColor' => method_exists($log, 'getActionColor') ? $log->getActionColor() : 'secondary',
                'module' => is_array($log->formatted_module) ? 'Sistema' : ($log->formatted_module ?? $log->module),
                'description' => Str::limit(is_array($log->description) ? 'Descripción del sistema' : ($log->description ?? 'Sin descripción'), 50),
                'fullDescription' => is_array($log->description) ? 'Descripción del sistema' : ($log->description ?? ''),
                'timeAgo' => $log->createdAt ? $log->createdAt->diffForHumans() : ($log->created_at ? $log->created_at->diffForHumans() : 'Fecha no disponible'),
                'rawDate' => $log->createdAt ? $log->createdAt->toISOString() : null
            ];
        });
        
        return response()->json([
            'success' => true,
            'logs' => $formattedLogs,
            'timestamp' => $timestamp,
            'total_logs' => Log::count(),
            'debug_info' => [
                'query_time' => now()->toISOString(),
                'logs_count' => $recentLogs->count()
            ]
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener los logs recientes: ' . $e->getMessage(),
            'logs' => []
        ], 500);
    }
});