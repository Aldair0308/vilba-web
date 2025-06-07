<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crane;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CraneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Crane::query();

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('marca', 'like', "%{$search}%")
                      ->orWhere('modelo', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            }

            if ($request->filled('estado')) {
                $query->where('estado', $request->get('estado'));
            }

            if ($request->filled('tipo')) {
                $query->where('tipo', $request->get('tipo'));
            }

            if ($request->filled('category')) {
                $query->where('category', $request->get('category'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'createdAt');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $cranes = $query->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json($cranes);
            }

            return view('cranes.index', compact('cranes'));
        } catch (\Exception $e) {
            Log::error('Error al obtener grúas: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener las grúas'
                ], 500);
            }

            return back()->with('error', 'Error al obtener las grúas');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cranes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'marca' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'capacidad' => 'required|integer|min:1',
                'tipo' => 'required|in:torre,móvil,oruga,camión',
                'estado' => 'sometimes|in:activo,inactivo,mantenimiento',
                'category' => 'nullable|string|max:255',
                'precios' => 'nullable|array',
                'precios.*.zona' => 'required_with:precios|string|max:255',
                'precios.*.precio' => 'required_with:precios|array',
                'precios.*.precio.*' => 'required_with:precios|numeric|min:0'
            ], [
                'marca.required' => 'La marca es obligatoria',
                'modelo.required' => 'El modelo es obligatorio',
                'nombre.required' => 'El nombre es obligatorio',
                'capacidad.required' => 'La capacidad es obligatoria',
                'capacidad.integer' => 'La capacidad debe ser un número entero',
                'capacidad.min' => 'La capacidad debe ser mayor a 0',
                'tipo.required' => 'El tipo es obligatorio',
                'tipo.in' => 'El tipo debe ser: torre, móvil, oruga o camión',
                'estado.in' => 'El estado debe ser: activo, inactivo o mantenimiento',
                'precios.*.zona.required_with' => 'La zona es obligatoria cuando se especifican precios',
                'precios.*.precio.required_with' => 'Los precios son obligatorios cuando se especifica una zona',
                'precios.*.precio.*.numeric' => 'Los precios deben ser números',
                'precios.*.precio.*.min' => 'Los precios deben ser mayores o iguales a 0'
            ]);

            // No formatting needed - keep original values
            
            if (!isset($validatedData['estado'])) {
                $validatedData['estado'] = Crane::STATUS_ACTIVE;
            }

            if (!isset($validatedData['precios'])) {
                $validatedData['precios'] = [];
            }

            $crane = Crane::create($validatedData);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane,
                    'message' => 'Grúa creada exitosamente'
                ], 201);
            }

            return redirect()->route('cranes.index')
                           ->with('success', 'Grúa creada exitosamente.');
        } catch (ValidationException $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al crear grúa: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la grúa'
                ], 500);
            }

            return back()->with('error', 'Error al crear la grúa')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane,
                    'message' => 'Grúa obtenida exitosamente'
                ]);
            }

            return view('cranes.show', compact('crane'));
        } catch (\Exception $e) {
            Log::error('Error al obtener grúa: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Grúa no encontrada'
                ], 404);
            }

            return back()->with('error', 'Grúa no encontrada');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);
            return view('cranes.edit', compact('crane'));
        } catch (\Exception $e) {
            return back()->with('error', 'Grúa no encontrada');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $crane = Crane::findOrFail($id);

            $validatedData = $request->validate([
                'marca' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'capacidad' => 'required|integer|min:1',
                'tipo' => 'required|in:torre,móvil,oruga,camión',
                'estado' => 'sometimes|in:activo,inactivo,mantenimiento',
                'category' => 'nullable|string|max:255',
                'precios' => 'nullable|array',
                'precios.*.zona' => 'required_with:precios|string|max:255',
                'precios.*.precio' => 'required_with:precios|array',
                'precios.*.precio.*' => 'required_with:precios|numeric|min:0'
            ], [
                'marca.required' => 'La marca es obligatoria',
                'modelo.required' => 'El modelo es obligatorio',
                'nombre.required' => 'El nombre es obligatorio',
                'capacidad.required' => 'La capacidad es obligatoria',
                'capacidad.integer' => 'La capacidad debe ser un número entero',
                'capacidad.min' => 'La capacidad debe ser mayor a 0',
                'tipo.required' => 'El tipo es obligatorio',
                'tipo.in' => 'El tipo debe ser: torre, móvil, oruga o camión',
                'estado.in' => 'El estado debe ser: activo, inactivo o mantenimiento',
                'precios.*.zona.required_with' => 'La zona es obligatoria cuando se especifican precios',
                'precios.*.precio.required_with' => 'Los precios son obligatorios cuando se especifica una zona',
                'precios.*.precio.*.numeric' => 'Los precios deben ser números',
                'precios.*.precio.*.min' => 'Los precios deben ser mayores o iguales a 0'
            ]);

            // No formatting needed - keep original values

            if (!isset($validatedData['precios'])) {
                $validatedData['precios'] = [];
            }

            $crane->update($validatedData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Grúa actualizada exitosamente'
                ]);
            }

            return redirect()->route('cranes.show', $crane->id)
                           ->with('success', 'Grúa actualizada exitosamente.');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar grúa: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la grúa'
                ], 500);
            }

            return back()->with('error', 'Error al actualizar la grúa')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);
            
            // Verificar si la grúa puede ser eliminada (no tiene rentas activas, etc.)
            // Esta lógica se puede expandir según las reglas de negocio
            
            $crane->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Grúa eliminada exitosamente'
                ]);
            }

            return redirect()->route('cranes.index')
                           ->with('success', 'Grúa eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar grúa: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la grúa'
                ], 500);
            }

            return back()->with('error', 'Error al eliminar la grúa');
        }
    }

    /**
     * Activate the specified crane.
     */
    public function activate(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);
            $crane->activate();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Grúa activada exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Grúa activada exitosamente.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al activar la grúa'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al activar la grúa');
        }
    }

    /**
     * Deactivate the specified crane.
     */
    public function deactivate(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);
            $crane->deactivate();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Grúa desactivada exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Grúa desactivada exitosamente.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la grúa'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al desactivar la grúa');
        }
    }

    /**
     * Set the specified crane to maintenance.
     */
    public function setMaintenance(string $id)
    {
        try {
            $crane = Crane::findOrFail($id);
            $crane->setMaintenance();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Grúa puesta en mantenimiento exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Grúa puesta en mantenimiento exitosamente.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al poner la grúa en mantenimiento'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al poner la grúa en mantenimiento');
        }
    }

    /**
     * Get crane statistics.
     */
    public function stats()
    {
        try {
            $total = Crane::count();
            $activo = Crane::where('estado', Crane::STATUS_ACTIVE)->count();
            $inactivo = Crane::where('estado', Crane::STATUS_INACTIVE)->count();
            $mantenimiento = Crane::where('estado', Crane::STATUS_MAINTENANCE)->count();
            
            // Estadísticas por tipo
            $byType = [
                'torre' => Crane::where('tipo', 'torre')->count(),
                'móvil' => Crane::where('tipo', 'móvil')->count(),
                'oruga' => Crane::where('tipo', 'oruga')->count(),
                'camión' => Crane::where('tipo', 'camión')->count()
            ];
            
            // Capacidad promedio
            $averageCapacity = Crane::avg('capacidad') ?? 0;
            
            $withPrices = Crane::whereNotNull('precios')
                              ->where('precios', '!=', [])
                              ->count();
            $recent = Crane::where('created_at', '>=', now()->subDays(30))->count();

            return response()->json([
                'total' => $total,
                'activo' => $activo,
                'inactivo' => $inactivo,
                'mantenimiento' => $mantenimiento,
                'by_type' => $byType,
                'average_capacity' => round($averageCapacity, 2),
                'with_prices' => $withPrices,
                'recent' => $recent
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de grúas: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las estadísticas'
            ], 500);
        }
    }

    /**
     * Add a new price zone to a crane.
     */
    public function addPriceZone(Request $request, string $id)
    {
        try {
            $crane = Crane::findOrFail($id);

            $validatedData = $request->validate([
                'zona' => 'required|string|max:255',
                'precio' => 'required|array|min:1',
                'precio.*' => 'required|numeric|min:0'
            ], [
                'zona.required' => 'La zona es obligatoria',
                'zona.string' => 'La zona debe ser texto',
                'zona.max' => 'La zona no puede exceder 255 caracteres',
                'precio.required' => 'Los precios son obligatorios',
                'precio.array' => 'Los precios deben ser un arreglo',
                'precio.min' => 'Debe especificar al menos un precio',
                'precio.*.required' => 'Cada precio es obligatorio',
                'precio.*.numeric' => 'Los precios deben ser números',
                'precio.*.min' => 'Los precios deben ser mayores o iguales a 0'
            ]);

            // Verificar si la zona ya existe
            $currentPrices = $crane->precios ?? [];
            foreach ($currentPrices as $priceData) {
                if ($priceData['zona'] === $validatedData['zona']) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'La zona ya existe para esta grúa'
                        ], 422);
                    }
                    return back()->with('error', 'La zona ya existe para esta grúa');
                }
            }

            // Agregar nueva zona
            $crane->addPriceForZone($validatedData['zona'], $validatedData['precio']);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Zona de precios agregada exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Zona de precios agregada exitosamente.');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al agregar zona de precios: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar la zona de precios'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al agregar la zona de precios');
        }
    }

    /**
     * Update a price zone for a crane.
     */
    public function updatePriceZone(Request $request, string $id, string $zona)
    {
        try {
            $crane = Crane::findOrFail($id);

            $validatedData = $request->validate([
                'precio' => 'required|array|min:1',
                'precio.*' => 'required|numeric|min:0'
            ], [
                'precio.required' => 'Los precios son obligatorios',
                'precio.array' => 'Los precios deben ser un arreglo',
                'precio.min' => 'Debe especificar al menos un precio',
                'precio.*.required' => 'Cada precio es obligatorio',
                'precio.*.numeric' => 'Los precios deben ser números',
                'precio.*.min' => 'Los precios deben ser mayores o iguales a 0'
            ]);

            // Verificar si la zona existe
            $currentPrices = $crane->precios ?? [];
            $zoneExists = false;
            foreach ($currentPrices as $index => $priceData) {
                if ($priceData['zona'] === $zona) {
                    $currentPrices[$index]['precio'] = $validatedData['precio'];
                    $zoneExists = true;
                    break;
                }
            }

            if (!$zoneExists) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La zona no existe para esta grúa'
                    ], 404);
                }
                return back()->with('error', 'La zona no existe para esta grúa');
            }

            $crane->precios = $currentPrices;
            $crane->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Zona de precios actualizada exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Zona de precios actualizada exitosamente.');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar zona de precios: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la zona de precios'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al actualizar la zona de precios');
        }
    }

    /**
     * Remove a price zone from a crane.
     */
    public function removePriceZone(Request $request, string $id, string $zona)
    {
        try {
            $crane = Crane::findOrFail($id);

            $currentPrices = $crane->precios ?? [];
            $newPrices = [];
            $zoneFound = false;

            foreach ($currentPrices as $priceData) {
                if ($priceData['zona'] !== $zona) {
                    $newPrices[] = $priceData;
                } else {
                    $zoneFound = true;
                }
            }

            if (!$zoneFound) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La zona no existe para esta grúa'
                    ], 404);
                }
                return back()->with('error', 'La zona no existe para esta grúa');
            }

            $crane->precios = $newPrices;
            $crane->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $crane->fresh(),
                    'message' => 'Zona de precios eliminada exitosamente'
                ]);
            }

            return redirect()->back()->with('success', 'Zona de precios eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar zona de precios: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la zona de precios'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al eliminar la zona de precios');
        }
    }
}