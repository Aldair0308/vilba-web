@extends('layouts.app')

@section('title', 'Calendario de Eventos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Calendario de Eventos</h1>
                    <p class="mb-0 text-muted">Vista de calendario con todos los eventos del sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>Vista Lista
                    </a>
                    <a href="{{ route('events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Evento
                    </a>
                </div>
            </div>

            <!-- Filtros del calendario -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="calendar-status" class="form-label">Estado</label>
                            <select class="form-select" id="calendar-status">
                                <option value="">Todos</option>
                                <option value="programado">Programado</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="calendar-type" class="form-label">Tipo</label>
                            <select class="form-select" id="calendar-type">
                                <option value="">Todos</option>
                                <option value="renta">Renta</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="reunion">Reunión</option>
                                <option value="entrega">Entrega</option>
                                <option value="recogida">Recogida</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="calendar-priority" class="form-label">Prioridad</label>
                            <select class="form-select" id="calendar-priority">
                                <option value="">Todas</option>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="calendar-client" class="form-label">Cliente</label>
                            <select class="form-select" id="calendar-client">
                                <option value="">Todos</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->_id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="calendar-user" class="form-label">Responsable</label>
                            <select class="form-select" id="calendar-user">
                                <option value="">Todos</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->_id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar me-2"></i>Calendario de Eventos
                    </h6>
                    <div class="d-flex gap-2">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="calendar-month">Mes</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="calendar-week">Semana</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="calendar-day">Día</button>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="calendar-today">Hoy</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear/editar evento -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Crear Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventModalForm">
                    @csrf
                    <input type="hidden" id="event-id" name="event_id">
                    <input type="hidden" id="event-method" name="_method" value="POST">
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="modal-title" class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal-title" name="title" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-type" class="form-label">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select" id="modal-type" name="type" required>
                                <option value="">Seleccionar...</option>
                                <option value="renta">Renta</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="reunion">Reunión</option>
                                <option value="entrega">Entrega</option>
                                <option value="recogida">Recogida</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-priority" class="form-label">Prioridad <span class="text-danger">*</span></label>
                            <select class="form-select" id="modal-priority" name="priority" required>
                                <option value="">Seleccionar...</option>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="modal-all-day" name="all_day" value="1">
                                <label class="form-check-label" for="modal-all-day">
                                    Todo el día
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-start-date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="modal-start-date" name="start_date" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-end-date" class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="modal-end-date" name="end_date" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-client" class="form-label">Cliente</label>
                            <select class="form-select" id="modal-client" name="client_id">
                                <option value="">Seleccionar...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->_id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modal-user" class="form-label">Responsable</label>
                            <select class="form-select" id="modal-user" name="user_id">
                                <option value="">Seleccionar...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->_id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="modal-location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="modal-location" name="location">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="modal-description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="modal-description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveEventBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del evento -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Detalles del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventDetailContent">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="editEventBtn">Editar</button>
                <button type="button" class="btn btn-primary" id="viewEventBtn">Ver Completo</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<style>
/* Calendar customizations */
.fc {
    font-family: inherit;
}

.fc-toolbar {
    margin-bottom: 1rem;
}

.fc-toolbar-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #5a5c69;
}

.fc-button {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.35rem;
}

.fc-button:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.fc-button:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
}

.fc-event {
    border-radius: 4px;
    border: none;
    padding: 2px 4px;
    font-size: 0.875rem;
    cursor: pointer;
}

.fc-event:hover {
    opacity: 0.8;
}

.fc-daygrid-event {
    margin-bottom: 1px;
}

.fc-event-title {
    font-weight: 500;
}

/* Event type indicators */
.event-renta { background-color: #28a745 !important; }
.event-mantenimiento { background-color: #ffc107 !important; color: #000 !important; }
.event-reunion { background-color: #007bff !important; }
.event-entrega { background-color: #17a2b8 !important; }
.event-recogida { background-color: #6f42c1 !important; }
.event-otro { background-color: #6c757d !important; }

/* Priority indicators */
.priority-urgente::before {
    content: "🔴 ";
}
.priority-alta::before {
    content: "🟠 ";
}
.priority-media::before {
    content: "🟡 ";
}
.priority-baja::before {
    content: "🟢 ";
}

/* Status indicators */
.status-programado { border-left: 4px solid #007bff; }
.status-en_progreso { border-left: 4px solid #ffc107; }
.status-completado { border-left: 4px solid #28a745; }
.status-cancelado { 
    border-left: 4px solid #dc3545;
    opacity: 0.6;
    text-decoration: line-through;
}

/* Modal customizations */
.modal-lg {
    max-width: 800px;
}

.text-danger {
    color: #e74a3b !important;
}

/* Calendar view buttons */
.btn-group .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    let calendar;
    let currentEvents = [];
    
    // Inicializar calendario
    function initCalendar() {
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            height: 'auto',
            events: function(fetchInfo, successCallback, failureCallback) {
                loadEvents(fetchInfo.startStr, fetchInfo.endStr, successCallback, failureCallback);
            },
            eventClick: function(info) {
                showEventDetail(info.event);
            },
            dateClick: function(info) {
                createEvent(info.dateStr);
            },
            eventDrop: function(info) {
                updateEventDate(info.event);
            },
            eventResize: function(info) {
                updateEventDate(info.event);
            },
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            weekends: true
        });
        
        calendar.render();
    }
    
    // Cargar eventos desde el servidor
    function loadEvents(start, end, successCallback, failureCallback) {
        const filters = {
            start: start,
            end: end,
            status: document.getElementById('calendar-status').value,
            type: document.getElementById('calendar-type').value,
            priority: document.getElementById('calendar-priority').value,
            client_id: document.getElementById('calendar-client').value,
            user_id: document.getElementById('calendar-user').value
        };
        
        fetch('{{ route("events.calendar-data") }}?' + new URLSearchParams(filters))
            .then(response => response.json())
            .then(data => {
                currentEvents = data.map(event => ({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end,
                    allDay: event.allDay,
                    backgroundColor: event.backgroundColor,
                    borderColor: event.borderColor,
                    textColor: event.textColor,
                    className: [
                        'event-' + event.type,
                        'priority-' + event.priority,
                        'status-' + event.status
                    ],
                    extendedProps: {
                        description: event.description,
                        type: event.type,
                        status: event.status,
                        priority: event.priority,
                        location: event.location,
                        client: event.client,
                        user: event.user,
                        crane: event.crane
                    }
                }));
                successCallback(currentEvents);
            })
            .catch(error => {
                console.error('Error loading events:', error);
                failureCallback(error);
            });
    }
    
    // Mostrar detalles del evento
    function showEventDetail(event) {
        const props = event.extendedProps;
        const content = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Información Básica</h6>
                    <p><strong>Título:</strong> ${event.title}</p>
                    <p><strong>Tipo:</strong> <span class="badge event-${props.type}">${props.type}</span></p>
                    <p><strong>Estado:</strong> <span class="badge bg-primary">${props.status}</span></p>
                    <p><strong>Prioridad:</strong> <span class="badge bg-warning">${props.priority}</span></p>
                    ${props.description ? `<p><strong>Descripción:</strong> ${props.description}</p>` : ''}
                    ${props.location ? `<p><strong>Ubicación:</strong> ${props.location}</p>` : ''}
                </div>
                <div class="col-md-6">
                    <h6>Fechas y Relaciones</h6>
                    <p><strong>Inicio:</strong> ${event.start.toLocaleString()}</p>
                    <p><strong>Fin:</strong> ${event.end ? event.end.toLocaleString() : 'No definido'}</p>
                    ${props.client ? `<p><strong>Cliente:</strong> ${props.client.name}</p>` : ''}
                    ${props.user ? `<p><strong>Responsable:</strong> ${props.user.name}</p>` : ''}
                    ${props.crane ? `<p><strong>Grúa:</strong> ${props.crane.nombre}</p>` : ''}
                </div>
            </div>
        `;
        
        document.getElementById('eventDetailContent').innerHTML = content;
        document.getElementById('editEventBtn').onclick = () => editEvent(event.id);
        document.getElementById('viewEventBtn').onclick = () => window.location.href = `{{ url('events') }}/${event.id}`;
        
        new bootstrap.Modal(document.getElementById('eventDetailModal')).show();
    }
    
    // Crear nuevo evento
    function createEvent(dateStr) {
        document.getElementById('eventModalLabel').textContent = 'Crear Evento';
        document.getElementById('eventModalForm').reset();
        document.getElementById('event-id').value = '';
        document.getElementById('event-method').value = 'POST';
        
        // Establecer fecha por defecto
        const date = new Date(dateStr);
        document.getElementById('modal-start-date').value = date.toISOString().slice(0, 16);
        
        const endDate = new Date(date);
        endDate.setHours(date.getHours() + 1);
        document.getElementById('modal-end-date').value = endDate.toISOString().slice(0, 16);
        
        // Habilitar todos los inputs del modal
        const modal = document.getElementById('eventModal');
        const inputs = modal.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = false;
            input.readOnly = false;
        });
        
        new bootstrap.Modal(document.getElementById('eventModal')).show();
    }
    
    // Editar evento
    function editEvent(eventId) {
        fetch(`{{ url('events') }}/${eventId}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(event => {
            document.getElementById('eventModalLabel').textContent = 'Editar Evento';
            document.getElementById('event-id').value = event.id;
            document.getElementById('event-method').value = 'PUT';
            document.getElementById('modal-title').value = event.title;
            document.getElementById('modal-type').value = event.type;
            document.getElementById('modal-priority').value = event.priority;
            document.getElementById('modal-all-day').checked = event.all_day;
            document.getElementById('modal-start-date').value = event.start_date;
            document.getElementById('modal-end-date').value = event.end_date;
            document.getElementById('modal-client').value = event.client_id || '';
            document.getElementById('modal-user').value = event.user_id || '';
            document.getElementById('modal-location').value = event.location || '';
            document.getElementById('modal-description').value = event.description || '';
            
            // Habilitar todos los inputs del modal
            const modal = document.getElementById('eventModal');
            const inputs = modal.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = false;
                input.readOnly = false;
            });
            
            new bootstrap.Modal(document.getElementById('eventModal')).show();
        })
        .catch(error => {
            console.error('Error loading event:', error);
            alert('Error al cargar el evento');
        });
    }
    
    // Guardar evento
    document.getElementById('saveEventBtn').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('eventModalForm'));
        const eventId = document.getElementById('event-id').value;
        const method = document.getElementById('event-method').value;
        
        const url = eventId ? `{{ url('events') }}/${eventId}` : '{{ route('events.store') }}';
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                calendar.refetchEvents();
                alert(eventId ? 'Evento actualizado correctamente' : 'Evento creado correctamente');
            } else {
                let errorMessage = 'Error técnico al guardar el evento:\n\n';
                
                if (data.errors) {
                    // Errores de validación
                    errorMessage += 'Errores de validación:\n';
                    Object.keys(data.errors).forEach(field => {
                        errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
                    });
                } else if (data.message) {
                    // Mensaje de error general
                    errorMessage += `Mensaje: ${data.message}\n`;
                } else {
                    errorMessage += 'Error desconocido del servidor\n';
                }
                
                // Agregar información adicional si está disponible
                if (data.exception) {
                    errorMessage += `\nExcepción: ${data.exception}\n`;
                }
                if (data.file) {
                    errorMessage += `Archivo: ${data.file}\n`;
                }
                if (data.line) {
                    errorMessage += `Línea: ${data.line}\n`;
                }
                
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error saving event:', error);
            let errorMessage = 'Error técnico al guardar el evento:\n\n';
            errorMessage += `Tipo: ${error.name || 'Error de red/conexión'}\n`;
            errorMessage += `Mensaje: ${error.message || 'Error desconocido'}\n`;
            errorMessage += `\nDetalles técnicos: ${error.stack || 'No disponible'}`;
            alert(errorMessage);
        });
    });
    
    // Actualizar fecha del evento (drag & drop)
    function updateEventDate(event) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        formData.append('start_date', event.start.toISOString());
        if (event.end) {
            formData.append('end_date', event.end.toISOString());
        }
        
        fetch(`{{ url('events') }}/${event.id}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error al actualizar el evento');
                calendar.refetchEvents();
            }
        })
        .catch(error => {
            console.error('Error updating event:', error);
            calendar.refetchEvents();
        });
    }
    
    // Controles de vista del calendario
    document.getElementById('calendar-month').addEventListener('click', () => {
        calendar.changeView('dayGridMonth');
        updateActiveViewButton('calendar-month');
    });
    
    document.getElementById('calendar-week').addEventListener('click', () => {
        calendar.changeView('timeGridWeek');
        updateActiveViewButton('calendar-week');
    });
    
    document.getElementById('calendar-day').addEventListener('click', () => {
        calendar.changeView('timeGridDay');
        updateActiveViewButton('calendar-day');
    });
    
    document.getElementById('calendar-today').addEventListener('click', () => {
        calendar.today();
    });
    
    function updateActiveViewButton(activeId) {
        document.querySelectorAll('#calendar-month, #calendar-week, #calendar-day').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(activeId).classList.add('active');
    }
    
    // Filtros del calendario
    document.querySelectorAll('#calendar-status, #calendar-type, #calendar-priority, #calendar-client, #calendar-user').forEach(select => {
        select.addEventListener('change', () => {
            calendar.refetchEvents();
        });
    });
    
    // Manejar checkbox de todo el día
    document.getElementById('modal-all-day').addEventListener('change', function() {
        const startInput = document.getElementById('modal-start-date');
        const endInput = document.getElementById('modal-end-date');
        
        if (this.checked) {
            startInput.type = 'date';
            endInput.type = 'date';
        } else {
            startInput.type = 'datetime-local';
            endInput.type = 'datetime-local';
        }
    });
    
    // Event listener para cuando se abra el modal
    document.getElementById('eventModal').addEventListener('shown.bs.modal', function() {
        // Asegurar que todos los inputs estén habilitados
        const inputs = this.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = false;
            input.readOnly = false;
            input.style.pointerEvents = 'auto';
        });
        
        // Enfocar el primer input
        const firstInput = this.querySelector('input[type="text"]');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    });
    
    // Inicializar
    initCalendar();
    updateActiveViewButton('calendar-month');
});
</script>
@endpush
@endsection