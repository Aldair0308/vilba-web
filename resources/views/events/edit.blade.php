@extends('layouts.app')

@section('title', 'Editar Evento')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Editar Evento</h1>
                    <p class="mb-0 text-muted">Modifica la información del evento: <strong>{{ $event->title }}</strong></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.show', $event->_id) }}" class="btn btn-outline-info">
                        <i class="fas fa-eye me-2"></i>Ver Evento
                    </a>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Eventos
                    </a>
                </div>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Información del Evento
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('events.update', $event->_id) }}" id="eventForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title" class="form-label">Título del Evento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title', $event->title) }}" 
                                               placeholder="Ej: Renta de grúa para construcción" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3" 
                                                  placeholder="Describe los detalles del evento...">{{ old('description', $event->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">Tipo de Evento <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="renta" {{ old('type', $event->type) === 'renta' ? 'selected' : '' }}>Renta</option>
                                            <option value="mantenimiento" {{ old('type', $event->type) === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                            <option value="reunion" {{ old('type', $event->type) === 'reunion' ? 'selected' : '' }}>Reunión</option>
                                            <option value="entrega" {{ old('type', $event->type) === 'entrega' ? 'selected' : '' }}>Entrega</option>
                                            <option value="recogida" {{ old('type', $event->type) === 'recogida' ? 'selected' : '' }}>Recogida</option>
                                            <option value="otro" {{ old('type', $event->type) === 'otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="priority" class="form-label">Prioridad <span class="text-danger">*</span></label>
                                        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                            <option value="">Seleccionar prioridad...</option>
                                            <option value="baja" {{ old('priority', $event->priority) === 'baja' ? 'selected' : '' }}>Baja</option>
                                            <option value="media" {{ old('priority', $event->priority) === 'media' ? 'selected' : '' }}>Media</option>
                                            <option value="alta" {{ old('priority', $event->priority) === 'alta' ? 'selected' : '' }}>Alta</option>
                                            <option value="urgente" {{ old('priority', $event->priority) === 'urgente' ? 'selected' : '' }}>Urgente</option>
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="location" class="form-label">Ubicación</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                               id="location" name="location" value="{{ old('location', $event->location) }}" 
                                               placeholder="Ej: Av. Principal 123, Ciudad">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Panel lateral -->
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Configuración</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Estado</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="programado" {{ old('status', $event->status) === 'programado' ? 'selected' : '' }}>Programado</option>
                                                <option value="en_progreso" {{ old('status', $event->status) === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                                <option value="completado" {{ old('status', $event->status) === 'completado' ? 'selected' : '' }}>Completado</option>
                                                <option value="cancelado" {{ old('status', $event->status) === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Color del Evento</label>
                                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                                   id="color" name="color" value="{{ old('color', $event->color ?: '#007bff') }}">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="reminder_minutes" class="form-label">Recordatorio (minutos antes)</label>
                                            <select class="form-select @error('reminder_minutes') is-invalid @enderror" id="reminder_minutes" name="reminder_minutes">
                                                <option value="">Sin recordatorio</option>
                                                <option value="15" {{ old('reminder_minutes', $event->reminder_minutes) == '15' ? 'selected' : '' }}>15 minutos</option>
                                                <option value="30" {{ old('reminder_minutes', $event->reminder_minutes) == '30' ? 'selected' : '' }}>30 minutos</option>
                                                <option value="60" {{ old('reminder_minutes', $event->reminder_minutes) == '60' ? 'selected' : '' }}>1 hora</option>
                                                <option value="120" {{ old('reminder_minutes', $event->reminder_minutes) == '120' ? 'selected' : '' }}>2 horas</option>
                                                <option value="1440" {{ old('reminder_minutes', $event->reminder_minutes) == '1440' ? 'selected' : '' }}>1 día</option>
                                            </select>
                                            @error('reminder_minutes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Información de auditoría -->
                                        <div class="mt-4 pt-3 border-top">
                                            <h6 class="text-muted mb-2">Información</h6>
                                            <small class="text-muted d-block mb-1">
                                                <strong>Creado:</strong> {{ $event->createdAt ? $event->createdAt->format('d/m/Y H:i') : 'N/A' }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <strong>Actualizado:</strong> {{ $event->updatedAt ? $event->updatedAt->format('d/m/Y H:i') : 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fechas y horarios -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Fechas y Horarios</h5>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="all_day" name="all_day" 
                                           value="1" {{ old('all_day', $event->all_day) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all_day">
                                        Evento de todo el día
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3" id="end_date_container">
                                <label for="end_date" class="form-label">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" 
                                       value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Relaciones -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Relaciones</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="client_id" class="form-label">Cliente</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id">
                                    <option value="">Seleccionar cliente...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->_id }}" {{ old('client_id', $event->client_id) === $client->_id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="crane_id" class="form-label">Grúa</label>
                                <select class="form-select @error('crane_id') is-invalid @enderror" id="crane_id" name="crane_id">
                                    <option value="">Seleccionar grúa...</option>
                                    @foreach($cranes as $crane)
                                        <option value="{{ $crane->_id }}" {{ old('crane_id', $event->crane_id) === $crane->_id ? 'selected' : '' }}>
                                            {{ $crane->nombre }} - {{ $crane->modelo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('crane_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="user_id" class="form-label">Responsable</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                                    <option value="">Seleccionar responsable...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->_id }}" {{ old('user_id', $event->user_id) === $user->_id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Notas adicionales -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Información Adicional</h5>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">Notas</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="4" 
                                          placeholder="Notas adicionales, instrucciones especiales, etc...">{{ old('notes', $event->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('events.show', $event->_id) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                        @if($event->status === 'programado')
                                            <form method="POST" action="{{ route('events.change-status', $event->_id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="en_progreso">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-play me-2"></i>Iniciar Evento
                                                </button>
                                            </form>
                                        @elseif($event->status === 'en_progreso')
                                            <form method="POST" action="{{ route('events.change-status', $event->_id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completado">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fas fa-check me-2"></i>Completar Evento
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary" name="action" value="save">
                                            <i class="fas fa-save me-2"></i>Guardar Cambios
                                        </button>
                                        <button type="submit" class="btn btn-success" name="action" value="save_and_continue">
                                            <i class="fas fa-edit me-2"></i>Guardar y Continuar Editando
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-control-color {
    width: 100%;
    height: 38px;
}

.card.bg-light {
    border: 1px solid #e3e6f0;
}

.card.bg-light .card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.text-danger {
    color: #e74a3b !important;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-group .btn {
    margin-right: 10px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.border-top {
    border-top: 1px solid #e3e6f0 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const allDayCheckbox = document.getElementById('all_day');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const endDateContainer = document.getElementById('end_date_container');
    
    // Función para manejar el checkbox de todo el día
    function toggleAllDay() {
        if (allDayCheckbox.checked) {
            // Cambiar a tipo date
            startDateInput.type = 'date';
            endDateInput.type = 'date';
            
            // Si hay valores datetime, convertir a date
            if (startDateInput.value) {
                startDateInput.value = startDateInput.value.split('T')[0];
            }
            if (endDateInput.value) {
                endDateInput.value = endDateInput.value.split('T')[0];
            }
        } else {
            // Cambiar a tipo datetime-local
            startDateInput.type = 'datetime-local';
            endDateInput.type = 'datetime-local';
        }
    }
    
    // Evento para el checkbox
    allDayCheckbox.addEventListener('change', toggleAllDay);
    
    // Inicializar estado
    toggleAllDay();
    
    // Validación de fechas
    startDateInput.addEventListener('change', function() {
        // Validar que la fecha de fin no sea anterior a la de inicio
        if (this.value && endDateInput.value && this.value > endDateInput.value) {
            endDateInput.value = this.value;
        }
        
        // Establecer mínimo para fecha de fin
        endDateInput.min = this.value;
    });
    
    // Validación del formulario
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (startDate >= endDate) {
            e.preventDefault();
            alert('La fecha de fin debe ser posterior a la fecha de inicio.');
            return false;
        }
    });
    
    // Confirmación para cambios de estado críticos
    const statusSelect = document.getElementById('status');
    const originalStatus = '{{ $event->status }}';
    
    statusSelect.addEventListener('change', function() {
        if (originalStatus === 'completado' && this.value !== 'completado') {
            const confirm = window.confirm('¿Está seguro de cambiar el estado de un evento completado?');
            if (!confirm) {
                this.value = originalStatus;
            }
        }
        
        if (originalStatus === 'cancelado' && this.value !== 'cancelado') {
            const confirm = window.confirm('¿Está seguro de reactivar un evento cancelado?');
            if (!confirm) {
                this.value = originalStatus;
            }
        }
    });
});
</script>
@endpush
@endsection