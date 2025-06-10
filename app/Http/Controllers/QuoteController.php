<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Client;
use App\Models\File;
use App\Models\Crane;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Quote::query();

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('zone', 'like', "%{$search}%")
                      ->orWhere('total', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->filled('zone')) {
                $query->where('zone', $request->get('zone'));
            }

            if ($request->filled('client_id')) {
                $query->where('clientId', $request->get('client_id'));
            }

            if ($request->filled('responsible_id')) {
                $query->where('responsibleId', $request->get('responsible_id'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'createdAt');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $quotes = $query->with(['client', 'file', 'responsible'])->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $quotes,
                    'message' => 'Cotizaciones obtenidas exitosamente'
                ]);
            }

            // Datos adicionales para la vista
            $clients = Client::where('status', Client::STATUS_ACTIVE)->get(['_id', 'name']);
            $users = User::all(['_id', 'name']);
            $statuses = [
                Quote::STATUS_PENDING => 'Pendiente',
                Quote::STATUS_APPROVED => 'Aprobada',
                Quote::STATUS_REJECTED => 'Rechazada',
                Quote::STATUS_ACTIVE => 'Activa',
                Quote::STATUS_COMPLETED => 'Completada'
            ];

            return view('quotes.index', compact('quotes', 'clients', 'users', 'statuses'));

        } catch (\Exception $e) {
            Log::error('Error al obtener cotizaciones: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener las cotizaciones'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al obtener las cotizaciones');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $clients = Client::where('status', Client::STATUS_ACTIVE)->get(['_id', 'name']);
            $files = File::all(['_id', 'name', 'type']);
            $cranes = Crane::where('estado', Crane::STATUS_ACTIVE)->get(['_id', 'nombre', 'marca', 'modelo', 'capacidad', 'tipo', 'precios']);
            $users = User::all(['_id', 'name']);

            return view('quotes.create', compact('clients', 'files', 'cranes', 'users'));

        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de creación de cotización: ' . $e->getMessage());
            return redirect()->route('quotes.index')->with('error', 'Error al cargar el formulario');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'zone' => 'required|string|max:255',
                'clientId' => 'required|string|exists:clients,_id',
                'fileId' => 'required|string|exists:files,_id',
                'status' => ['sometimes', Rule::in([Quote::STATUS_PENDING, Quote::STATUS_APPROVED, Quote::STATUS_REJECTED, Quote::STATUS_ACTIVE, Quote::STATUS_COMPLETED])],
                'cranes' => 'required|array|min:1',
                'cranes.*.crane' => 'required|string|exists:cranes,_id',
                'cranes.*.dias' => 'required|numeric|min:1',
                'cranes.*.precio' => 'required|numeric|min:0',
                'iva' => 'nullable|numeric|min:0|max:100',
                'total' => 'nullable|string',
                'responsibleId' => 'required|string|exists:users,_id',
            ]);

            // Crear la cotización
            $quote = Quote::create($validatedData);

            // Calcular el total automáticamente si no se proporcionó
            if (!$quote->total) {
                $quote->total = (string) $quote->calculated_total;
                $quote->save();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $quote->load(['client', 'file', 'responsible']),
                    'message' => 'Cotización creada exitosamente'
                ], 201);
            }

            return redirect()->route('quotes.show', $quote->_id)
                           ->with('success', 'Cotización creada exitosamente');

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();

        } catch (\Exception $e) {
            Log::error('Error al crear cotización: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error al crear la cotización')
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $quote = Quote::with(['client', 'file', 'responsible'])->findOrFail($id);
            
            // Obtener información detallada de las grúas
            $craneDetails = $quote->crane_details;

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => array_merge($quote->toArray(), [
                        'crane_details' => $craneDetails,
                        'subtotal' => $quote->subtotal,
                        'iva_amount' => $quote->iva_amount,
                        'calculated_total' => $quote->calculated_total
                    ]),
                    'message' => 'Cotización obtenida exitosamente'
                ]);
            }

            return view('quotes.show', compact('quote', 'craneDetails'));

        } catch (\Exception $e) {
            Log::error('Error al obtener cotización: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cotización no encontrada'
                ], 404);
            }

            return redirect()->route('quotes.index')
                           ->with('error', 'Cotización no encontrada');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $quote = Quote::with(['client', 'file', 'responsible'])->findOrFail($id);
            $clients = Client::where('status', Client::STATUS_ACTIVE)->get(['_id', 'name']);
            $files = File::all(['_id', 'name', 'type']);
            $cranes = Crane::where('estado', Crane::STATUS_ACTIVE)->get(['_id', 'nombre', 'marca', 'modelo', 'capacidad', 'tipo', 'precios']);
            $users = User::all(['_id', 'name']);

            return view('quotes.edit', compact('quote', 'clients', 'files', 'cranes', 'users'));

        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de edición de cotización: ' . $e->getMessage());
            return redirect()->route('quotes.index')->with('error', 'Cotización no encontrada');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $quote = Quote::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'zone' => 'required|string|max:255',
                'clientId' => 'required|string|exists:clients,_id',
                'fileId' => 'required|string|exists:files,_id',
                'status' => ['sometimes', Rule::in([Quote::STATUS_PENDING, Quote::STATUS_APPROVED, Quote::STATUS_REJECTED, Quote::STATUS_ACTIVE, Quote::STATUS_COMPLETED])],
                'cranes' => 'required|array|min:1',
                'cranes.*.crane' => 'required|string|exists:cranes,_id',
                'cranes.*.dias' => 'required|numeric|min:1',
                'cranes.*.precio' => 'required|numeric|min:0',
                'iva' => 'nullable|numeric|min:0|max:100',
                'total' => 'nullable|string',
                'responsibleId' => 'required|string|exists:users,_id',
            ]);

            $quote->update($validatedData);

            // Recalcular el total si no se proporcionó
            if (!$quote->total) {
                $quote->total = (string) $quote->calculated_total;
                $quote->save();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $quote->load(['client', 'file', 'responsible']),
                    'message' => 'Cotización actualizada exitosamente'
                ]);
            }

            return redirect()->route('quotes.show', $quote->_id)
                           ->with('success', 'Cotización actualizada exitosamente');

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();

        } catch (\Exception $e) {
            Log::error('Error al actualizar cotización: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error al actualizar la cotización')
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $quote = Quote::findOrFail($id);
            $quote->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cotización eliminada exitosamente'
                ]);
            }

            return redirect()->route('quotes.index')
                           ->with('success', 'Cotización eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar cotización: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la cotización'
                ], 500);
            }

            return redirect()->route('quotes.index')
                           ->with('error', 'Error al eliminar la cotización');
        }
    }

    /**
     * Cambiar el estado de una cotización
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $quote = Quote::findOrFail($id);

            $validatedData = $request->validate([
                'status' => ['required', Rule::in([Quote::STATUS_PENDING, Quote::STATUS_APPROVED, Quote::STATUS_REJECTED, Quote::STATUS_ACTIVE, Quote::STATUS_COMPLETED])],
            ]);

            $quote->update($validatedData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $quote,
                    'message' => 'Estado de cotización actualizado exitosamente'
                ]);
            }

            return redirect()->back()
                           ->with('success', 'Estado de cotización actualizado exitosamente');

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado inválido',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                           ->withErrors($e->errors());

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de cotización: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error al cambiar el estado de la cotización');
        }
    }

    /**
     * Obtener cotizaciones por cliente
     */
    public function byClient(string $clientId)
    {
        try {
            $quotes = Quote::where('clientId', $clientId)
                          ->with(['file', 'responsible'])
                          ->orderBy('createdAt', 'desc')
                          ->get();

            return response()->json([
                'success' => true,
                'data' => $quotes,
                'message' => 'Cotizaciones del cliente obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener cotizaciones por cliente: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las cotizaciones del cliente'
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de cotizaciones
     */
    public function stats()
    {
        try {
            $stats = [
                'total' => Quote::count(),
                'pending' => Quote::pending()->count(),
                'approved' => Quote::approved()->count(),
                'active' => Quote::active()->count(),
                'completed' => Quote::completed()->count(),
                'rejected' => Quote::rejected()->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de cotizaciones: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las estadísticas'
            ], 500);
        }
    }
}