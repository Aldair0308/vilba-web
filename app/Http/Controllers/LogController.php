<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log as LaravelLog;
use Exception;

class LogController extends Controller
{
    /**
     * Display a listing of the logs.
     */
    public function index(Request $request): JsonResponse|View
    {
        try {
            $query = Log::query();

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('userName', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('entityName', 'like', "%{$search}%")
                      ->orWhere('entityId', 'like', "%{$search}%");
                });
            }

            // Filter by action
            if ($request->filled('action')) {
                $query->where('action', $request->get('action'));
            }

            // Filter by module
            if ($request->filled('module')) {
                $query->where('module', $request->get('module'));
            }

            // Filter by user
            if ($request->filled('user_id')) {
                $query->where('userId', $request->get('user_id'));
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->where('createdAt', '>=', $request->get('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->where('createdAt', '<=', $request->get('date_to') . ' 23:59:59');
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'createdAt');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 15);
            $logs = $query->with('user')->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $logs,
                    'actions' => Log::getActions(),
                    'modules' => Log::getModules()
                ]);
            }

            return view('logs.index', [
                'logs' => $logs,
                'actions' => Log::getActions(),
                'modules' => Log::getModules(),
                'users' => User::active()->get()
            ]);
        } catch (Exception $e) {
            LaravelLog::error('Error fetching logs: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los registros'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al obtener los registros');
        }
    }

    /**
     * Display the specified log.
     */
    public function show(Request $request, string $id): JsonResponse|View
    {
        try {
            $log = Log::with('user')->findOrFail($id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $log
                ]);
            }

            return view('logs.show', compact('log'));
        } catch (Exception $e) {
            LaravelLog::error('Error fetching log: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ], 404);
            }

            return redirect()->route('logs.index')->with('error', 'Registro no encontrado');
        }
    }

    /**
     * Search logs.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->get('search', '');
            $limit = $request->get('limit', 10);

            $logs = Log::where(function ($query) use ($search) {
                $query->where('userName', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('entityName', 'like', "%{$search}%")
                      ->orWhere('entityId', 'like', "%{$search}%");
            })
            ->with('user')
            ->orderBy('createdAt', 'desc')
            ->limit($limit)
            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Búsqueda completada exitosamente',
                'data' => $logs
            ]);
        } catch (Exception $e) {
            LaravelLog::error('Error searching logs: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda'
            ], 500);
        }
    }

    /**
     * Get logs statistics.
     */
    public function stats(Request $request): JsonResponse
    {
        try {
            $stats = [
                'total' => Log::count(),
                'today' => Log::whereDate('createdAt', today())->count(),
                'this_week' => Log::whereBetween('createdAt', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'this_month' => Log::whereMonth('createdAt', now()->month)
                                  ->whereYear('createdAt', now()->year)
                                  ->count(),
                'by_action' => [],
                'by_module' => [],
                'recent_activity' => Log::with('user')
                                       ->orderBy('createdAt', 'desc')
                                       ->limit(5)
                                       ->get()
            ];

            // Stats by action
            foreach (Log::getActions() as $action) {
                $stats['by_action'][$action] = Log::where('action', $action)->count();
            }

            // Stats by module
            foreach (Log::getModules() as $module) {
                $stats['by_module'][$module] = Log::where('module', $module)->count();
            }

            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas exitosamente',
                'data' => $stats
            ]);
        } catch (Exception $e) {
            LaravelLog::error('Error fetching log stats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Export logs to CSV.
     */
    public function export(Request $request)
    {
        try {
            $query = Log::query();

            // Apply same filters as index
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('userName', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('entityName', 'like', "%{$search}%")
                      ->orWhere('entityId', 'like', "%{$search}%");
                });
            }

            if ($request->filled('action')) {
                $query->where('action', $request->get('action'));
            }

            if ($request->filled('module')) {
                $query->where('module', $request->get('module'));
            }

            if ($request->filled('user_id')) {
                $query->where('userId', $request->get('user_id'));
            }

            if ($request->filled('date_from')) {
                $query->where('createdAt', '>=', $request->get('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->where('createdAt', '<=', $request->get('date_to') . ' 23:59:59');
            }

            $logs = $query->with('user')->orderBy('createdAt', 'desc')->get();

            $filename = 'logs_export_' . now()->format('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($logs) {
                $file = fopen('php://output', 'w');
                
                // CSV headers
                fputcsv($file, [
                    'ID',
                    'Usuario',
                    'Acción',
                    'Módulo',
                    'ID Entidad',
                    'Nombre Entidad',
                    'Descripción',
                    'IP',
                    'User Agent',
                    'Fecha Creación'
                ]);

                foreach ($logs as $log) {
                    fputcsv($file, [
                        $log->id,
                        $log->userName,
                        $log->formatted_action,
                        $log->formatted_module,
                        $log->entityId,
                        $log->entityName ?? '',
                        $log->description ?? '',
                        $log->ipAddress,
                        $log->userAgent ?? '',
                        $log->createdAt->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            LaravelLog::error('Error exporting logs: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error al exportar los registros');
        }
    }
}