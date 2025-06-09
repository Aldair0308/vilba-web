<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = File::query();

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%")
                      ->orWhere('responsible_id', 'like', "%{$search}%");
                });
            }

            if ($request->filled('type')) {
                $query->where('type', $request->get('type'));
            }

            if ($request->filled('department')) {
                $query->where('department', $request->get('department'));
            }

            if ($request->filled('responsible_id')) {
                $query->where('responsible_id', $request->get('responsible_id'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'createdAt');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $files = $query->paginate($perPage);

            // Obtener departamentos únicos para el filtro
            $departments = File::distinct('department')->pluck('department')->filter()->sort()->values();

            // Obtener estadísticas
            $stats = [
                'total' => File::count(),
                'pdf' => File::where('type', 'pdf')->count(),
                'excel' => File::where('type', 'excel')->count(),
                'total_size' => File::all()->sum(function($file) {
                    return $file->file_size;
                })
            ];

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $files,
                    'departments' => $departments,
                    'stats' => $stats,
                    'message' => 'Archivos obtenidos exitosamente'
                ]);
            }

            return view('files.index', compact('files', 'departments', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error al obtener archivos: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los archivos'
                ], 500);
            }

            return back()->with('error', 'Error al obtener los archivos');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'base64' => 'required|string',
                'type' => 'required|in:pdf,excel',
                'department' => 'required|string|max:255',
                'responsible_id' => 'required|string|max:255',
            ], [
                'name.required' => 'El nombre del archivo es obligatorio',
                'name.max' => 'El nombre del archivo no puede exceder 255 caracteres',
                'base64.required' => 'El contenido del archivo es obligatorio',
                'type.required' => 'El tipo de archivo es obligatorio',
                'type.in' => 'El tipo de archivo debe ser PDF o Excel',
                'department.required' => 'El departamento es obligatorio',
                'department.max' => 'El departamento no puede exceder 255 caracteres',
                'responsible_id.required' => 'El ID del responsable es obligatorio',
                'responsible_id.max' => 'El ID del responsable no puede exceder 255 caracteres',
            ]);

            // Validar que el base64 sea válido
            $base64String = $validatedData['base64'];
            if (strpos($base64String, ',') !== false) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            
            if (!base64_decode($base64String, true)) {
                throw ValidationException::withMessages([
                    'base64' => ['El contenido del archivo no es válido']
                ]);
            }

            $file = File::create($validatedData);

            Log::info('Archivo creado exitosamente', ['file_id' => $file->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $file,
                    'message' => 'Archivo creado exitosamente'
                ], 201);
            }

            return redirect()->route('files.index')
                           ->with('success', 'Archivo creado exitosamente');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al crear archivo: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al crear el archivo')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $file = File::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $file,
                    'message' => 'Archivo obtenido exitosamente'
                ]);
            }

            return view('files.show', compact('file'));
        } catch (\Exception $e) {
            Log::error('Error al obtener archivo: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Archivo no encontrado'
                ], 404);
            }

            return back()->with('error', 'Archivo no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $file = File::findOrFail($id);
            return view('files.edit', compact('file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Archivo no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $file = File::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'base64' => 'sometimes|string',
                'type' => 'required|in:pdf,excel',
                'department' => 'required|string|max:255',
                'responsible_id' => 'required|string|max:255',
            ], [
                'name.required' => 'El nombre del archivo es obligatorio',
                'name.max' => 'El nombre del archivo no puede exceder 255 caracteres',
                'type.required' => 'El tipo de archivo es obligatorio',
                'type.in' => 'El tipo de archivo debe ser PDF o Excel',
                'department.required' => 'El departamento es obligatorio',
                'department.max' => 'El departamento no puede exceder 255 caracteres',
                'responsible_id.required' => 'El ID del responsable es obligatorio',
                'responsible_id.max' => 'El ID del responsable no puede exceder 255 caracteres',
            ]);

            // Validar base64 si se proporciona
            if (isset($validatedData['base64'])) {
                $base64String = $validatedData['base64'];
                if (strpos($base64String, ',') !== false) {
                    $base64String = substr($base64String, strpos($base64String, ',') + 1);
                }
                
                if (!base64_decode($base64String, true)) {
                    throw ValidationException::withMessages([
                        'base64' => ['El contenido del archivo no es válido']
                    ]);
                }
            }

            $file->update($validatedData);

            Log::info('Archivo actualizado exitosamente', ['file_id' => $file->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $file->fresh(),
                    'message' => 'Archivo actualizado exitosamente'
                ]);
            }

            return redirect()->route('files.show', $file->id)
                           ->with('success', 'Archivo actualizado exitosamente');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar archivo: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el archivo')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $file = File::findOrFail($id);
            
            $file->delete();

            Log::info('Archivo eliminado exitosamente', ['file_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Archivo eliminado exitosamente'
                ]);
            }

            return redirect()->route('files.index')
                           ->with('success', 'Archivo eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el archivo'
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el archivo');
        }
    }

    /**
     * Download the specified file.
     */
    public function download(string $id)
    {
        try {
            $file = File::findOrFail($id);
            
            if (!$file->isValidBase64()) {
                return back()->with('error', 'El archivo no es válido para descarga');
            }

            $base64String = $file->base64;
            
            // Remover el prefijo data:type/subtype;base64, si existe
            if (strpos($base64String, ',') !== false) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            
            $fileContent = base64_decode($base64String);
            $fileName = $file->name . '.' . $file->file_extension;
            
            return response($fileContent)
                ->header('Content-Type', $file->mime_type)
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->header('Content-Length', strlen($fileContent));
                
        } catch (\Exception $e) {
            Log::error('Error al descargar archivo: ' . $e->getMessage());
            return back()->with('error', 'Error al descargar el archivo');
        }
    }

    /**
     * Preview the specified file in browser.
     */
    public function preview(string $id)
    {
        try {
            $file = File::findOrFail($id);
            
            if (!$file->isValidBase64()) {
                return back()->with('error', 'El archivo no es válido para vista previa');
            }

            $base64String = $file->base64;
            
            // Remover el prefijo data:type/subtype;base64, si existe
            if (strpos($base64String, ',') !== false) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            
            $fileContent = base64_decode($base64String);
            
            return response($fileContent)
                ->header('Content-Type', $file->mime_type)
                ->header('Content-Disposition', 'inline')
                ->header('Content-Length', strlen($fileContent));
                
        } catch (\Exception $e) {
            Log::error('Error al mostrar vista previa del archivo: ' . $e->getMessage());
            return back()->with('error', 'Error al mostrar la vista previa del archivo');
        }
    }

    /**
     * Get file statistics.
     */
    public function stats(Request $request)
    {
        try {
            $stats = File::getStats();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $stats,
                    'message' => 'Estadísticas obtenidas exitosamente'
                ]);
            }
            
            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener las estadísticas'
                ], 500);
            }
            
            return response()->json(['error' => 'Error al obtener las estadísticas'], 500);
        }
    }

    /**
     * Search files.
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $limit = $request->get('limit', 10);
            
            $files = File::where('name', 'like', "%{$query}%")
                        ->orWhere('department', 'like', "%{$query}%")
                        ->orWhere('responsible_id', 'like', "%{$query}%")
                        ->limit($limit)
                        ->get(['_id', 'name', 'type', 'department', 'responsible_id']);
            
            return response()->json([
                'success' => true,
                'data' => $files,
                'message' => 'Búsqueda completada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de archivos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda'
            ], 500);
        }
    }
}