<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Client;
use App\Models\Crane;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Event::with(['client', 'crane', 'user']);

            // Filtros
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->filled('type')) {
                $query->where('type', $request->get('type'));
            }

            if ($request->filled('priority')) {
                $query->where('priority', $request->get('priority'));
            }

            if ($request->filled('client_id')) {
                $query->where('client_id', $request->get('client_id'));
            }

            if ($request->filled('crane_id')) {
                $query->where('crane_id', $request->get('crane_id'));
            }

            if ($request->filled('date_from')) {
                $query->where('start_date', '>=', $request->get('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->where('end_date', '<=', $request->get('date_to'));
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'start_date');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $events = $query->paginate($perPage);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $events,
                    'message' => 'Eventos obtenidos exitosamente'
                ]);
            }

            // Obtener datos para filtros
            $clients = Client::active()->orderBy('name')->get(['_id', 'name']);
            $cranes = Crane::where('estado', 'activo')->orderBy('nombre')->get(['_id', 'nombre']);
            $users = User::orderBy('name')->get(['_id', 'name']);

            return view('events.index', compact('events', 'clients', 'cranes', 'users'));
        } catch (\Exception $e) {
            Log::error('Error al obtener eventos: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los eventos'
                ], 500);
            }

            return back()->with('error', 'Error al obtener los eventos');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::active()->orderBy('name')->get(['_id', 'name']);
        $cranes = Crane::where('estado', 'activo')->orderBy('nombre')->get(['_id', 'nombre']);
        $users = User::orderBy('name')->get(['_id', 'name']);

        return view('events.create', compact('clients', 'cranes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'type' => 'required|in:renta,mantenimiento,reunion,entrega,recogida,otro',
                'status' => 'sometimes|in:programado,en_progreso,completado,cancelado',
                'priority' => 'required|in:baja,media,alta,urgente',
                'start_date' => 'required|date|after_or_equal:now',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'all_day' => 'sometimes|boolean',
                'location' => 'nullable|string|max:255',
                'client_id' => 'nullable|string|exists:clients,_id',
                'crane_id' => 'nullable|string|exists:cranes,_id',
                'user_id' => 'nullable|string|exists:users,_id',
                'notes' => 'nullable|string|max:1000',
                'color' => 'nullable|string|max:7',
                'reminder_minutes' => 'nullable|integer|min:0',
                'attendees' => 'nullable|array',
                'attendees.*' => 'string|max:255',
            ], [
                'title.required' => 'El título es obligatorio',
                'title.max' => 'El título no puede exceder 255 caracteres',
                'type.required' => 'El tipo de evento es obligatorio',
                'type.in' => 'El tipo de evento debe ser válido',
                'priority.required' => 'La prioridad es obligatoria',
                'priority.in' => 'La prioridad debe ser válida',
                'start_date.required' => 'La fecha de inicio es obligatoria',
                'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
                'start_date.after_or_equal' => 'La fecha de inicio no puede ser en el pasado',
                'start_date.after_or_equal' => 'La fecha de inicio no puede ser en el pasado',
                'end_date.date' => 'La fecha de fin debe ser una fecha válida',
                'end_date.date' => 'La fecha de fin debe ser una fecha válida',
                'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
                'client_id.exists' => 'El cliente seleccionado no existe',
                'crane_id.exists' => 'La grúa seleccionada no existe',
                'user_id.exists' => 'El usuario seleccionado no existe',
                'color.max' => 'El color debe ser un código hexadecimal válido',
                'reminder_minutes.integer' => 'Los minutos de recordatorio deben ser un número entero',
                'reminder_minutes.min' => 'Los minutos de recordatorio deben ser mayor o igual a 0',
            ]);

            // Convertir fechas
            $validatedData['start_date'] = Carbon::parse($validatedData['start_date']);
            if (!empty($validatedData['end_date'])) {
                $validatedData['end_date'] = Carbon::parse($validatedData['end_date']);
            }

            // Procesar attendees
            if (isset($validatedData['attendees'])) {
                $validatedData['attendees'] = array_filter($validatedData['attendees']);
            }

            $event = Event::create($validatedData);

            Log::info('Evento creado exitosamente', ['event_id' => $event->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event->load(['client', 'crane', 'user']),
                    'message' => 'Evento creado exitosamente'
                ], 201);
            }

            return redirect()->route('events.index')
                           ->with('success', 'Evento creado exitosamente');
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
            Log::error('Error al crear evento: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al crear el evento')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $event = Event::with(['client', 'crane', 'user'])->findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json($event);
            }

            return view('events.show', compact('event'));
        } catch (\Exception $e) {
            Log::error('Error al obtener evento: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Evento no encontrado'
                ], 404);
            }

            return back()->with('error', 'Evento no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $clients = Client::active()->orderBy('name')->get(['_id', 'name']);
            $cranes = Crane::where('estado', 'activo')->orderBy('nombre')->get(['_id', 'nombre']);
            $users = User::orderBy('name')->get(['_id', 'name']);

            return view('events.edit', compact('event', 'clients', 'cranes', 'users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Evento no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'type' => 'required|in:renta,mantenimiento,reunion,entrega,recogida,otro',
                'status' => 'sometimes|in:programado,en_progreso,completado,cancelado',
                'priority' => 'required|in:baja,media,alta,urgente',
                'start_date' => 'required|date|after_or_equal:now',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'all_day' => 'sometimes|boolean',
                'location' => 'nullable|string|max:255',
                'client_id' => 'nullable|string|exists:clients,_id',
                'crane_id' => 'nullable|string|exists:cranes,_id',
                'user_id' => 'nullable|string|exists:users,_id',
                'notes' => 'nullable|string|max:1000',
                'color' => 'nullable|string|max:7',
                'reminder_minutes' => 'nullable|integer|min:0',
                'attendees' => 'nullable|array',
                'attendees.*' => 'string|max:255',
            ], [
                'title.required' => 'El título es obligatorio',
                'title.max' => 'El título no puede exceder 255 caracteres',
                'type.required' => 'El tipo de evento es obligatorio',
                'type.in' => 'El tipo de evento debe ser válido',
                'priority.required' => 'La prioridad es obligatoria',
                'priority.in' => 'La prioridad debe ser válida',
                'start_date.required' => 'La fecha de inicio es obligatoria',
                'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
                'end_date.date' => 'La fecha de fin debe ser una fecha válida',
                'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
                'client_id.exists' => 'El cliente seleccionado no existe',
                'crane_id.exists' => 'La grúa seleccionada no existe',
                'user_id.exists' => 'El usuario seleccionado no existe',
                'color.max' => 'El color debe ser un código hexadecimal válido',
                'reminder_minutes.integer' => 'Los minutos de recordatorio deben ser un número entero',
                'reminder_minutes.min' => 'Los minutos de recordatorio deben ser mayor o igual a 0',
            ]);

            // Convertir fechas
            $validatedData['start_date'] = Carbon::parse($validatedData['start_date']);
            if (!empty($validatedData['end_date'])) {
                $validatedData['end_date'] = Carbon::parse($validatedData['end_date']);
            }

            // Procesar attendees
            if (isset($validatedData['attendees'])) {
                $validatedData['attendees'] = array_filter($validatedData['attendees']);
            }

            $event->update($validatedData);

            Log::info('Evento actualizado exitosamente', ['event_id' => $event->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event->load(['client', 'crane', 'user']),
                    'message' => 'Evento actualizado exitosamente'
                ]);
            }

            return redirect()->route('events.show', $event->_id)
                           ->with('success', 'Evento actualizado exitosamente');
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
            Log::error('Error al actualizar evento: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el evento')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            Log::info('Evento eliminado exitosamente', ['event_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Evento eliminado exitosamente'
                ]);
            }

            return redirect()->route('events.index')
                           ->with('success', 'Evento eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar evento: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el evento'
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el evento');
        }
    }

    /**
     * Cambiar el estado del evento
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);
            
            $validatedData = $request->validate([
                'status' => 'required|in:programado,en_progreso,completado,cancelado'
            ]);

            $event->status = $validatedData['status'];
            $event->save();

            Log::info('Estado del evento cambiado', ['event_id' => $id, 'new_status' => $validatedData['status']]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event,
                    'message' => 'Estado del evento actualizado exitosamente'
                ]);
            }

            return back()->with('success', 'Estado del evento actualizado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del evento: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar el estado del evento'
                ], 500);
            }

            return back()->with('error', 'Error al cambiar el estado del evento');
        }
    }

    /**
     * Mostrar vista del calendario
     */
    public function calendar()
    {
        $clients = Client::active()->orderBy('name')->get(['_id', 'name']);
        $users = User::orderBy('name')->get(['_id', 'name']);

        return view('events.calendar', compact('clients', 'users'));
    }

    /**
     * Obtener eventos para el calendario (API)
     */
    public function calendarData(Request $request)
    {
        try {
            $start = $request->get('start');
            $end = $request->get('end');

            $query = Event::with(['client', 'crane', 'user']);

            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }

            $events = $query->get()->map(function ($event) {
                return [
                    'id' => $event->_id,
                    'title' => $event->title,
                    'start' => $event->start_date->toISOString(),
                    'end' => $event->end_date->toISOString(),
                    'allDay' => $event->all_day,
                    'backgroundColor' => $event->color ?: '#007bff',
                    'borderColor' => $event->color ?: '#007bff',
                    'textColor' => '#ffffff',
                    'description' => $event->description,
                    'type' => $event->type,
                    'status' => $event->status,
                    'priority' => $event->priority,
                    'location' => $event->location,
                    'client' => $event->client ? $event->client->name : null,
                    'crane' => $event->crane ? $event->crane->nombre : null,
                    'user' => $event->user ? $event->user->name : null,
                ];
            });

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Error al obtener eventos del calendario: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener eventos del calendario'
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de eventos
     */
    public function stats(Request $request)
    {
        try {
            $totalEvents = Event::count();
            
            $byStatus = [
                'programado' => Event::where('status', 'programado')->count(),
                'en_progreso' => Event::where('status', 'en_progreso')->count(),
                'completado' => Event::where('status', 'completado')->count(),
                'cancelado' => Event::where('status', 'cancelado')->count(),
            ];
            
            $byType = [
                'renta' => Event::where('type', 'renta')->count(),
                'mantenimiento' => Event::where('type', 'mantenimiento')->count(),
                'reunion' => Event::where('type', 'reunion')->count(),
                'entrega' => Event::where('type', 'entrega')->count(),
                'recogida' => Event::where('type', 'recogida')->count(),
                'otro' => Event::where('type', 'otro')->count(),
            ];
            
            $byPriority = [
                'baja' => Event::where('priority', 'baja')->count(),
                'media' => Event::where('priority', 'media')->count(),
                'alta' => Event::where('priority', 'alta')->count(),
                'urgente' => Event::where('priority', 'urgente')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'total_events' => $totalEvents,
                    'by_status' => $byStatus,
                    'by_type' => $byType,
                    'by_priority' => $byPriority,
                ],
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de eventos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Buscar eventos
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $limit = $request->get('limit', 10);

            $events = Event::with(['client', 'crane', 'user'])
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('location', 'like', "%{$query}%");
                })
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $events,
                'message' => 'Búsqueda completada'
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de eventos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda'
            ], 500);
        }
    }

    /**
     * Marcar evento como iniciado
     */
    public function start(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->status = 'en_progreso';
            $event->save();

            Log::info('Evento iniciado', ['event_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event,
                    'message' => 'Evento iniciado exitosamente'
                ]);
            }

            return back()->with('success', 'Evento iniciado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al iniciar evento: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al iniciar el evento'
                ], 500);
            }

            return back()->with('error', 'Error al iniciar el evento');
        }
    }

    /**
     * Marcar evento como completado
     */
    public function complete(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->status = 'completado';
            $event->save();

            Log::info('Evento completado', ['event_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event,
                    'message' => 'Evento completado exitosamente'
                ]);
            }

            return back()->with('success', 'Evento completado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al completar evento: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al completar el evento'
                ], 500);
            }

            return back()->with('error', 'Error al completar el evento');
        }
    }

    /**
     * Marcar evento como cancelado
     */
    public function cancel(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->status = 'cancelado';
            $event->save();

            Log::info('Evento cancelado', ['event_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $event,
                    'message' => 'Evento cancelado exitosamente'
                ]);
            }

            return back()->with('success', 'Evento cancelado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al cancelar evento: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cancelar el evento'
                ], 500);
            }

            return back()->with('error', 'Error al cancelar el evento');
        }
    }
}