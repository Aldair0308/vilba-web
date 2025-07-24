@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-envelope me-2"></i>
                        Mensajes de Contacto
                    </h3>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-info btn-sm" onclick="loadStats()">
                            <i class="fas fa-chart-bar me-1"></i>
                            Estadísticas
                        </button>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('contact-messages.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Estado</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Todos</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendientes</option>
                                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Leídos</option>
                                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Respondidos</option>
                                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archivados</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Buscar por nombre, email o asunto..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Filtrar
                            </button>
                            <a href="{{ route('contact-messages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Estado</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Asunto</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="{{ $message->status === 'pending' ? 'table-warning' : '' }}">
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $message->status === 'pending' ? 'warning' : 
                                                    ($message->status === 'read' ? 'info' : 
                                                    ($message->status === 'replied' ? 'success' : 'secondary')) 
                                                }}">
                                                    {{ $message->getStatusInSpanish() }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $message->name }}</strong>
                                                @if($message->phone)
                                                    <br><small class="text-muted">{{ $message->phone }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ Str::limit($message->subject, 40) }}</td>
                                            <td>
                                                <small>
                                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                                    <br>
                                                    <span class="text-muted">{{ $message->created_at->diffForHumans() }}</span>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('contact-messages.show', $message) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($message->status !== 'replied')
                                                        <a href="{{ route('contact-messages.reply', $message) }}" 
                                                           class="btn btn-sm btn-outline-success" title="Responder">
                                                            <i class="fas fa-reply"></i>
                                                        </a>
                                                    @endif
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                                type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" 
                                                                   onclick="updateStatus({{ $message->id }}, 'read')">
                                                                <i class="fas fa-eye me-2"></i>Marcar como leído
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="#" 
                                                                   onclick="updateStatus({{ $message->id }}, 'archived')">
                                                                <i class="fas fa-archive me-2"></i>Archivar
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="#" 
                                                                   onclick="deleteMessage({{ $message->id }})">
                                                                <i class="fas fa-trash me-2"></i>Eliminar
                                                            </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="card-footer">
                            {{ $messages->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay mensajes de contacto</h5>
                            <p class="text-muted">Los mensajes aparecerán aquí cuando los clientes llenen el formulario de contacto.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Estadísticas -->
<div class="modal fade" id="statsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estadísticas de Mensajes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="statsContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateStatus(messageId, status) {
    if (confirm('¿Estás seguro de cambiar el estado de este mensaje?')) {
        fetch(`/contact-messages/${messageId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el estado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar el estado');
        });
    }
}

function deleteMessage(messageId) {
    if (confirm('¿Estás seguro de eliminar este mensaje? Esta acción no se puede deshacer.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/contact-messages/${messageId}`;
        form.innerHTML = `
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function loadStats() {
    const modal = new bootstrap.Modal(document.getElementById('statsModal'));
    modal.show();
    
    fetch('/contact-messages/stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('statsContent').innerHTML = `
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h3>${data.total}</h3>
                                <p class="mb-0">Total</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h3>${data.pending}</h3>
                                <p class="mb-0">Pendientes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h3>${data.read}</h3>
                                <p class="mb-0">Leídos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h3>${data.replied}</h3>
                                <p class="mb-0">Respondidos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h3>${data.today}</h3>
                                <p class="mb-0">Hoy</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <h3>${data.this_week}</h3>
                                <p class="mb-0">Esta semana</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('statsContent').innerHTML = `
                <div class="alert alert-danger">
                    Error al cargar las estadísticas
                </div>
            `;
        });
}
</script>
@endpush