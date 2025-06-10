<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('role') && $request->role !== 'all') {
                $query->where('rol', $request->get('role'));
            }

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->get('status'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $users = $query->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $users,
                    'message' => 'Usuarios obtenidos exitosamente'
                ]);
            }

            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error al obtener usuarios: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los usuarios'
                ], 500);
            }

            return back()->with('error', 'Error al obtener los usuarios');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'photo' => 'nullable|string|max:255',
                'rol' => 'required|in:admin,user',
                'status' => 'sometimes|in:active,inactive'
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.max' => 'El nombre no puede exceder 255 caracteres',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe tener un formato válido',
                'email.unique' => 'Este email ya está registrado',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'La confirmación de contraseña no coincide',
                'rol.required' => 'El rol es obligatorio',
                'rol.in' => 'El rol debe ser admin o user',
                'status.in' => 'El estado debe ser activo o inactivo'
            ]);

            // Hash the password
            $validatedData['password'] = Hash::make($validatedData['password']);
            
            // Set default photo if not provided
            if (!isset($validatedData['photo'])) {
                $validatedData['photo'] = 'photo_user.jpg';
            }

            $user = User::create($validatedData);

            Log::info('Usuario creado exitosamente', ['user_id' => $user->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $user,
                    'message' => 'Usuario creado exitosamente'
                ], 201);
            }

            return redirect()->route('users.index')
                           ->with('success', 'Usuario creado exitosamente');
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
            Log::error('Error al crear usuario: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al crear el usuario')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $user,
                    'message' => 'Usuario obtenido exitosamente'
                ]);
            }

            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error al obtener usuario: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return back()->with('error', 'Usuario no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return back()->with('error', 'Usuario no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8|confirmed',
                'photo' => 'nullable|string|max:255',
                'rol' => 'required|in:admin,user',
                'status' => 'sometimes|in:active,inactive'
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.max' => 'El nombre no puede exceder 255 caracteres',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe tener un formato válido',
                'email.unique' => 'Este email ya está registrado',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'La confirmación de contraseña no coincide',
                'rol.required' => 'El rol es obligatorio',
                'rol.in' => 'El rol debe ser admin o user',
                'status.in' => 'El estado debe ser activo o inactivo'
            ]);

            // Hash password if provided
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

            $user->update($validatedData);

            Log::info('Usuario actualizado exitosamente', ['user_id' => $user->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $user->fresh(),
                    'message' => 'Usuario actualizado exitosamente'
                ]);
            }

            return redirect()->route('users.show', $user->id)
                           ->with('success', 'Usuario actualizado exitosamente');
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
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el usuario')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deletion of the currently authenticated user
            if (auth()->id() === $user->id) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes eliminar tu propia cuenta'
                    ], 422);
                }
                
                return back()->with('error', 'No puedes eliminar tu propia cuenta');
            }
            
            $user->delete();

            Log::info('Usuario eliminado exitosamente', ['user_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario eliminado exitosamente'
                ]);
            }

            return redirect()->route('users.index')
                           ->with('success', 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el usuario');
        }
    }

    /**
     * Search users via AJAX.
     */
    public function search(Request $request)
    {
        try {
            $query = User::query();
            
            if ($request->filled('q')) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }
            
            $users = $query->limit(10)->get(['id', 'name', 'email', 'rol']);
            
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Búsqueda completada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de usuarios: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda'
            ], 500);
        }
    }

    /**
     * Activar usuario
     */
    public function activate(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->activate();

            Log::info('Usuario activado exitosamente', ['user_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $user->fresh(),
                    'message' => 'Usuario activado exitosamente'
                ]);
            }

            return back()->with('success', 'Usuario activado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al activar usuario: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al activar el usuario'
                ], 500);
            }

            return back()->with('error', 'Error al activar el usuario');
        }
    }

    /**
     * Desactivar usuario
     */
    public function deactivate(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deactivation of the currently authenticated user
            if (auth()->id() === $user->id) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes desactivar tu propia cuenta'
                    ], 422);
                }
                
                return back()->with('error', 'No puedes desactivar tu propia cuenta');
            }
            
            $user->deactivate();

            Log::info('Usuario desactivado exitosamente', ['user_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $user->fresh(),
                    'message' => 'Usuario desactivado exitosamente'
                ]);
            }

            return back()->with('success', 'Usuario desactivado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al desactivar usuario: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar el usuario'
                ], 500);
            }

            return back()->with('error', 'Error al desactivar el usuario');
        }
    }

    /**
     * Get user statistics.
     */
    public function stats(Request $request)
    {
        try {
            $stats = [
                'total' => User::count(),
                'active' => User::active()->count(),
                'inactive' => User::inactive()->count(),
                'admins' => User::admins()->count(),
                'regular_users' => User::regularUsers()->count(),
                'recent' => User::where('created_at', '>=', now()->subDays(30))->count()
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de usuarios: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }
}