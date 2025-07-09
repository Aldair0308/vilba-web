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

// Ruta para obtener logs recientes para el dashboard
Route::middleware('auth')->get('/recent-logs', function () {
    try {
        $recentLogs = Log::orderBy('createdAt', 'desc')
            ->limit(6)
            ->get();
        
        $formattedLogs = $recentLogs->map(function ($log) {
            return [
                'id' => $log->id,
                'userName' => is_array($log->userName) ? 'Sistema' : ($log->userName ?? 'Sistema'),
                'userInitial' => strtoupper(substr(is_array($log->userName) ? 'S' : ($log->userName ?? 'S'), 0, 1)),
                'action' => is_array($log->formatted_action) ? 'Acción del Sistema' : ($log->formatted_action ?? $log->action),
                'actionColor' => 'primary',
                'module' => is_array($log->formatted_module) ? 'Sistema' : ($log->formatted_module ?? $log->module),
                'description' => Str::limit(is_array($log->description) ? 'Descripción del sistema' : ($log->description ?? 'Sin descripción'), 50),
                'fullDescription' => is_array($log->description) ? 'Descripción del sistema' : ($log->description ?? ''),
                'timeAgo' => $log->createdAt ? $log->createdAt->diffForHumans() : ($log->created_at ? $log->created_at->diffForHumans() : 'Fecha no disponible')
            ];
        });
        
        return response()->json([
            'success' => true,
            'logs' => $formattedLogs
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener los logs recientes',
            'logs' => []
        ], 500);
    }
});