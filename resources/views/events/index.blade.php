@extends('layouts.app')

@section('title', 'Gestión de Eventos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Gestión de Eventos</h1>
                    <p class="mb-0 text-muted">Administra todos los eventos del sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.calendar') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar me-2"></i>Vista Calendario
                    </a>
                    <a href="{{ route('events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Evento
                    </a>
                </div>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('events.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Título, descripción o ubicación...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="programado" {{ request('status') === 'programado' ? 'selected' : '' }}>Programado</option>
                                <option value="en_progreso" {{ request('status') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                <option value="completado" {{ request('status') === 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ request('status') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Todos</option>
                                <option value="renta" {{ request('type') === 'renta' ? 'selected' : '' }}>Renta</option>
                                <option value="mantenimiento" {{ request('type') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="reunion" {{ request('type') === 'reunion' ? 'selected' : '' }}>Reunión</option>
                                <option value="entrega" {{ request('type') === 'entrega' ? 'selected' : '' }}>Entrega</option>
                                <option value="recogida" {{ request('type') === 'recogida' ? 'selected' : '' }}>Recogida</option>
                                <option value="otro" {{ request('type') === 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="priority" class="form-label">Prioridad</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="">Todas</option>
                                <option value="baja" {{ request('priority') === 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ request('priority') === 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ request('priority') === 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="urgente" {{ request('priority') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="client_id" class="form-label">Cliente</label>
                            <select class="form-select" id="client_id" name="client_id">
                                <option value="">Todos</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->_id }}" {{ request('client_id') === $client->_id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de eventos -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Eventos ({{ $events->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Evento</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                        <th>Fecha/Hora</th>
                                        <th>Cliente</th>
                                        <th>Grúa</th>
                                        <th>Responsable</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3" style="background-color: {{ $event->color ?: $event->type_color }}">
                                                        <div class="avatar-title text-white rounded-circle">
                                                            @switch($event->type)
                                                                @case('renta')
                                                                    <i class="fas fa-handshake"></i>
                                                                    @break
                                                                @case('mantenimiento')
                                                                    <i class="fas fa-tools"></i>
                                                                    @break
                                                                @case('reunion')
                                                                    <i class="fas fa-users"></i>
                                                                    @break
                                                                @case('entrega')
                                                                    <i class="fas fa-truck"></i>
                                                                    @break
                                                                @case('recogida')
                                                                    <i class="fas fa-truck-loading"></i>
                                                                    @break
                                                                @default
                                                                    <i class="fas fa-calendar"></i>
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $event->title }}</h6>
                                                        <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                                        @if($event->location)
                                                            <br><small class="text-info"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($event->location, 30) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $event->type_color }}">
                                                    {{ ucfirst($event->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @switch($event->status)
                                                    @case('programado')
                                                        <span class="badge bg-primary">Programado</span>
                                                        @break
                                                    @case('en_progreso')
                                                        <span class="badge bg-warning">En Progreso</span>
                                                        @break
                                                    @case('completado')
                                                        <span class="badge bg-success">Completado</span>
                                                        @break
                                                    @case('cancelado')
                                                        <span class="badge bg-danger">Cancelado</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($event->priority)
                                                    @case('baja')
                                                        <span class="badge bg-success">Baja</span>
                                                        @break
                                                    @case('media')
                                                        <span class="badge bg-warning">Media</span>
                                                        @break
                                                    @case('alta')
                                                        <span class="badge bg-orange">Alta</span>
                                                        @break
                                                    @case('urgente')
                                                        <span class="badge bg-danger">Urgente</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div>
                                                    @if($event->start_date)
                                                        @if($event->all_day)
                                                            <strong>{{ $event->start_date->format('d/m/Y') }}</strong>
                                                            <br><small class="text-muted">Todo el día</small>
                                                        @else
                                                            <strong>{{ $event->start_date->format('d/m/Y') }}</strong>
                                                            <br><small class="text-muted">{{ $event->start_date->format('H:i') }} - {{ $event->end_date ? $event->end_date->format('H:i') : 'Sin fin' }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Sin fecha</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($event->client)
                                                    <a href="{{ route('clients.show', $event->client->_id) }}" class="text-decoration-none">
                                                        {{ $event->client->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin cliente</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->crane)
                                                    <a href="{{ route('cranes.show', $event->crane->_id) }}" class="text-decoration-none">
                                                        {{ $event->crane->nombre }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin grúa</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->user)
                                                    {{ $event->user->name }}
                                                @else
                                                    <span class="text-muted">Sin asignar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('events.show', $event->_id) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('events.edit', $event->_id) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($event->status === 'programado')
                                                        <form method="POST" action="{{ route('events.change-status', $event->_id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="en_progreso">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary" 
                                                                    title="Iniciar">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($event->status === 'en_progreso')
                                                        <form method="POST" action="{{ route('events.change-status', $event->_id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completado">
                                                            <button type="submit" class="btn btn-sm btn-outline-success" 
                                                                    title="Completar">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(in_array($event->status, ['programado', 'en_progreso']))
                                                        <form method="POST" action="{{ route('events.change-status', $event->_id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelado">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" 
                                                                    title="Cancelar" 
                                                                    onclick="return confirm('¿Está seguro de cancelar este evento?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form method="POST" action="{{ route('events.destroy', $event->_id) }}" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                title="Eliminar" 
                                                                onclick="return confirm('¿Está seguro de eliminar este evento? Esta acción no se puede deshacer.')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <span>Mostrando <strong>{{ $events->firstItem() }}</strong> a <strong>{{ $events->lastItem() }}</strong> de <strong>{{ $events->total() }}</strong> resultados</span>
                            </div>
                            <div class="pagination-nav">
                                {{ $events->appends(request()->query())->links('custom.pagination') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron eventos</h5>
                            <p class="text-muted">No hay eventos que coincidan con los criterios de búsqueda.</p>
                            <a href="{{ route('events.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear primer evento
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Pagination Styles */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e3e6f0;
}

.pagination-info {
    color: #6c757d;
    font-size: 14px;
}

.pagination-nav .pagination {
    margin: 0;
}

/* Avatar styles */
.avatar-sm {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

/* Badge colors */
.bg-orange {
    background-color: #fd7e14 !important;
}

/* Table hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Button group spacing */
.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush

@push('scripts')
<script>
// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = document.querySelectorAll('#status, #type, #priority, #client_id');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
@endsection