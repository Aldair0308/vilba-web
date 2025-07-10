@extends('layouts.app')

@section('title', 'Detalle del Evento')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">{{ $event->title }}</h1>
                    <p class="mb-0 text-muted">Detalles del evento</p>
                </div>
                <div class="d-flex gap-2">
                    @if(in_array($event->status, ['programado', 'en_progreso']))
                        <a href="{{ route('events.edit', $event->_id) }}" class="btn btn-outline-warning">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                    @endif
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Eventos
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Información principal -->
                <div class="col-lg-8">
                    <!-- Detalles del evento -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Información del Evento
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm" style="background-color: {{ $event->color ?: $event->type_color }}">
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
                                <span class="badge" style="background-color: {{ $event->type_color }}">
                                    {{ ucfirst($event->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="info-label">Título:</label>
                                        <div class="info-value">{{ $event->title }}</div>
                                    </div>
                                    
                                    @if($event->description)
                                        <div class="info-item mb-3">
                                            <label class="info-label">Descripción:</label>
                                            <div class="info-value">{{ $event->description }}</div>
                                        </div>
                                    @endif
                                    
                                    <div class="info-item mb-3">
                                        <label class="info-label">Estado:</label>
                                        <div class="info-value">
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
                                        </div>
                                    </div>
                                    
                                    <div class="info-item mb-3">
                                        <label class="info-label">Prioridad:</label>
                                        <div class="info-value">
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
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="info-label">Fecha y Hora:</label>
                                        <div class="info-value">
                                            @if($event->all_day)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-day me-2 text-info"></i>
                                                    <div>
                                                        <strong>{{ $event->start_date->format('d/m/Y') }}</strong>
                                                        <br><small class="text-muted">Todo el día</small>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock me-2 text-info"></i>
                                                    <div>
                                                        <strong>{{ $event->start_date->format('d/m/Y') }}</strong>
                                                        <br><small class="text-muted">{{ $event->start_date->format('H:i') }} - {{ $event->end_date ? $event->end_date->format('H:i') : 'Sin fin' }}</small>
                                                        @if($event->duration)
                                                            <br><small class="text-info">Duración: {{ $event->duration }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($event->location)
                                        <div class="info-item mb-3">
                                            <label class="info-label">Ubicación:</label>
                                            <div class="info-value">
                                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                                {{ $event->location }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($event->reminder_minutes)
                                        <div class="info-item mb-3">
                                            <label class="info-label">Recordatorio:</label>
                                            <div class="info-value">
                                                <i class="fas fa-bell me-2 text-warning"></i>
                                                @if($event->reminder_minutes < 60)
                                                    {{ $event->reminder_minutes }} minutos antes
                                                @elseif($event->reminder_minutes < 1440)
                                                    {{ $event->reminder_minutes / 60 }} hora(s) antes
                                                @else
                                                    {{ $event->reminder_minutes / 1440 }} día(s) antes
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($event->notes)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="info-item">
                                            <label class="info-label">Notas:</label>
                                            <div class="info-value bg-light p-3 rounded">
                                                {{ $event->notes }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Relaciones -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-link me-2"></i>Relaciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="relation-card">
                                        <div class="relation-header">
                                            <i class="fas fa-user text-primary"></i>
                                            <span>Cliente</span>
                                        </div>
                                        <div class="relation-content">
                                            @if($event->client)
                                                <a href="{{ route('clients.show', $event->client->_id) }}" class="text-decoration-none">
                                                    <strong>{{ $event->client->name }}</strong>
                                                </a>
                                                @if($event->client->email)
                                                    <br><small class="text-muted">{{ $event->client->email }}</small>
                                                @endif
                                                @if($event->client->phone)
                                                    <br><small class="text-muted">{{ $event->client->phone }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Sin cliente asignado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="relation-card">
                                        <div class="relation-header">
                                            <i class="fas fa-truck text-warning"></i>
                                            <span>Grúa</span>
                                        </div>
                                        <div class="relation-content">
                                            @if($event->crane)
                                                <a href="{{ route('cranes.show', $event->crane->_id) }}" class="text-decoration-none">
                                                    <strong>{{ $event->crane->nombre }}</strong>
                                                </a>
                                                @if($event->crane->modelo)
                                                    <br><small class="text-muted">{{ $event->crane->modelo }}</small>
                                                @endif
                                                @if($event->crane->capacidad)
                                                    <br><small class="text-muted">{{ $event->crane->capacidad }} ton</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Sin grúa asignada</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="relation-card">
                                        <div class="relation-header">
                                            <i class="fas fa-user-tie text-success"></i>
                                            <span>Responsable</span>
                                        </div>
                                        <div class="relation-content">
                                            @if($event->user)
                                                <strong>{{ $event->user->name }}</strong>
                                                @if($event->user->email)
                                                    <br><small class="text-muted">{{ $event->user->email }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Sin responsable asignado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel lateral -->
                <div class="col-lg-4">
                    <!-- Acciones rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($event->status === 'programado')
                                    <form method="POST" action="{{ route('events.change-status', $event->_id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="en_progreso">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Iniciar Evento
                                        </button>
                                    </form>
                                @elseif($event->status === 'en_progreso')
                                    <form method="POST" action="{{ route('events.change-status', $event->_id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completado">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-2"></i>Completar Evento
                                        </button>
                                    </form>
                                @endif
                                
                                @if(in_array($event->status, ['programado', 'en_progreso']))
                                    <a href="{{ route('events.edit', $event->_id) }}" class="btn btn-outline-warning">
                                        <i class="fas fa-edit me-2"></i>Editar Evento
                                    </a>
                                    
                                    <form method="POST" action="{{ route('events.change-status', $event->_id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelado">
                                        <button type="submit" class="btn btn-outline-secondary" 
                                                onclick="return confirm('¿Está seguro de cancelar este evento?')">
                                            <i class="fas fa-times me-2"></i>Cancelar Evento
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('events.create') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>Crear Evento Similar
                                </a>
                                
                                <form method="POST" action="{{ route('events.destroy', $event->_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('¿Está seguro de eliminar este evento? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash me-2"></i>Eliminar Evento
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información del sistema -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info me-2"></i>Información del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="info-label">ID del Evento:</label>
                                <div class="info-value">
                                    <code>{{ $event->_id }}</code>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="info-label">Creado:</label>
                                <div class="info-value">
                                    {{ $event->createdAt ? $event->createdAt->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="info-label">Última Actualización:</label>
                                <div class="info-value">
                                    {{ $event->updatedAt ? $event->updatedAt->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
                            </div>
                            
                            @if($event->color)
                                <div class="info-item mb-3">
                                    <label class="info-label">Color del Evento:</label>
                                    <div class="info-value d-flex align-items-center">
                                        <div class="color-preview me-2" style="background-color: {{ $event->color }}"></div>
                                        <code>{{ $event->color }}</code>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Estadísticas rápidas -->
                    @if($event->client && $event->client->rentHistory)
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-chart-bar me-2"></i>Estadísticas del Cliente
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="stat-item">
                                    <div class="stat-value">{{ $event->client->rentCount }}</div>
                                    <div class="stat-label">Rentas Totales</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-value">
                                        @switch($event->client->status)
                                            @case('activo')
                                                <span class="badge bg-success">Activo</span>
                                                @break
                                            @case('inactivo')
                                                <span class="badge bg-secondary">Inactivo</span>
                                                @break
                                            @default
                                                <span class="badge bg-warning">Desconocido</span>
                                        @endswitch
                                    </div>
                                    <div class="stat-label">Estado del Cliente</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Info items */
.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    color: #3a3b45;
    font-size: 0.95rem;
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

/* Relation cards */
.relation-card {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    padding: 1rem;
    height: 100%;
    background-color: #f8f9fc;
}

.relation-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: #5a5c69;
}

.relation-header i {
    margin-right: 0.5rem;
    font-size: 1.1rem;
}

.relation-content {
    color: #3a3b45;
}

/* Color preview */
.color-preview {
    width: 20px;
    height: 20px;
    border-radius: 3px;
    border: 1px solid #dee2e6;
}

/* Statistics */
.stat-item {
    text-align: center;
    margin-bottom: 1rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #5a5c69;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #858796;
    text-transform: uppercase;
    letter-spacing: 0.05rem;
}

/* Button spacing */
.d-grid.gap-2 > * {
    margin-bottom: 0.5rem;
}

.d-grid.gap-2 > *:last-child {
    margin-bottom: 0;
}

/* Code styling */
code {
    background-color: #f8f9fc;
    color: #6c757d;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación para acciones críticas
    const deleteForm = document.querySelector('form[action*="destroy"]');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const confirmed = confirm('¿Está seguro de eliminar este evento? Esta acción no se puede deshacer.');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }
    
    // Confirmación para cancelar evento
    const cancelForm = document.querySelector('form input[value="cancelado"]');
    if (cancelForm) {
        cancelForm.closest('form').addEventListener('submit', function(e) {
            const confirmed = confirm('¿Está seguro de cancelar este evento?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush
@endsection