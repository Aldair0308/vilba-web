<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Client::query();

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('rfc', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->get('status'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'createdAt');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $clients = $query->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $clients,
                    'message' => 'Clientes obtenidos exitosamente'
                ]);
            }

            return view('clients.index', compact('clients'));
        } catch (\Exception $e) {
            Log::error('Error al obtener clientes: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los clientes'
                ], 500);
            }

            return back()->with('error', 'Error al obtener los clientes');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'required|string|max:20',
                'rfc' => 'required|string|max:13|unique:clients,rfc',
                'address' => 'required|string|max:500',
                'status' => 'sometimes|in:active,inactive'
            ], [
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe tener un formato válido',
                'email.unique' => 'Este email ya está registrado',
                'phone.required' => 'El teléfono es obligatorio',
                'rfc.required' => 'El RFC es obligatorio',
                'rfc.unique' => 'Este RFC ya está registrado',
                'address.required' => 'La dirección es obligatoria',
                'status.in' => 'El estado debe ser activo o inactivo'
            ]);

            // Formatear RFC
            $validatedData['rfc'] = strtoupper($validatedData['rfc']);

            $client = Client::create($validatedData);

            Log::info('Cliente creado exitosamente', ['client_id' => $client->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $client,
                    'message' => 'Cliente creado exitosamente'
                ], 201);
            }

            return redirect()->route('clients.index')
                           ->with('success', 'Cliente creado exitosamente');
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
            Log::error('Error al crear cliente: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al crear el cliente')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $client = Client::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $client,
                    'message' => 'Cliente obtenido exitosamente'
                ]);
            }

            return view('clients.show', compact('client'));
        } catch (\Exception $e) {
            Log::error('Error al obtener cliente: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            return back()->with('error', 'Cliente no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            return view('clients.edit', compact('client'));
        } catch (\Exception $e) {
            return back()->with('error', 'Cliente no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $client = Client::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email,' . $id,
                'phone' => 'required|string|max:20',
                'rfc' => 'required|string|max:13|unique:clients,rfc,' . $id,
                'address' => 'required|string|max:500',
                'status' => 'sometimes|in:active,inactive'
            ], [
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe tener un formato válido',
                'email.unique' => 'Este email ya está registrado',
                'phone.required' => 'El teléfono es obligatorio',
                'rfc.required' => 'El RFC es obligatorio',
                'rfc.unique' => 'Este RFC ya está registrado',
                'address.required' => 'La dirección es obligatoria',
                'status.in' => 'El estado debe ser activo o inactivo'
            ]);

            // Formatear RFC
            $validatedData['rfc'] = strtoupper($validatedData['rfc']);

            $client->update($validatedData);

            Log::info('Cliente actualizado exitosamente', ['client_id' => $client->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $client->fresh(),
                    'message' => 'Cliente actualizado exitosamente'
                ]);
            }

            return redirect()->route('clients.show', $client->id)
                           ->with('success', 'Cliente actualizado exitosamente');
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
            Log::error('Error al actualizar cliente: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el cliente')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            
            // Verificar si el cliente tiene rentas activas
            if (!empty($client->rentHistory) && count($client->rentHistory) > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar un cliente con historial de rentas. Considere desactivarlo.'
                    ], 400);
                }

                return back()->with('error', 'No se puede eliminar un cliente con historial de rentas. Considere desactivarlo.');
            }

            $client->delete();

            Log::info('Cliente eliminado exitosamente', ['client_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cliente eliminado exitosamente'
                ]);
            }

            return redirect()->route('clients.index')
                           ->with('success', 'Cliente eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar cliente: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el cliente'
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el cliente');
        }
    }

    /**
     * Activar cliente
     */
    public function activate(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->activate();

            Log::info('Cliente activado exitosamente', ['client_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $client->fresh(),
                    'message' => 'Cliente activado exitosamente'
                ]);
            }

            return back()->with('success', 'Cliente activado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al activar cliente: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al activar el cliente'
                ], 500);
            }

            return back()->with('error', 'Error al activar el cliente');
        }
    }

    /**
     * Desactivar cliente
     */
    public function deactivate(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->deactivate();

            Log::info('Cliente desactivado exitosamente', ['client_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $client->fresh(),
                    'message' => 'Cliente desactivado exitosamente'
                ]);
            }

            return back()->with('success', 'Cliente desactivado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al desactivar cliente: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar el cliente'
                ], 500);
            }

            return back()->with('error', 'Error al desactivar el cliente');
        }
    }

    /**
     * Búsqueda de clientes
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            
            if (empty($query)) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Consulta vacía'
                ]);
            }

            $clients = Client::where('name', 'like', "%{$query}%")
                           ->orWhere('email', 'like', "%{$query}%")
                           ->orWhere('rfc', 'like', "%{$query}%")
                           ->orWhere('phone', 'like', "%{$query}%")
                           ->limit(10)
                           ->get();

            return response()->json([
                'success' => true,
                'data' => $clients,
                'message' => 'Búsqueda completada'
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de clientes: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda'
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de clientes
     */
    public function stats()
    {
        try {
            $stats = [
                'total' => Client::count(),
                'active' => Client::active()->count(),
                'inactive' => Client::inactive()->count(),
                'with_rents' => Client::whereNotNull('rentHistory')
                                    ->where('rentHistory', '!=', [])
                                    ->count(),
                'recent' => Client::where('createdAt', '>=', now()->subDays(30))->count()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }
}