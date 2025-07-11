@extends('layouts.app')

@section('title', 'Registros del Sistema')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Registros del Sistema</h1>
                    <p class="mb-0 text-muted">Historial de actividades y cambios en el sistema</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Exportar CSV
                    </a>
                    <a href="{{ route('logs.stats') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </a>
                </div>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('logs.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Usuario, descripción, entidad...">
                        </div>
                        <div class="col-md-2">
                            <label for="action" class="form-label">Acción</label>
                            <select class="form-select" id="action" name="action">
                                <option value="">Todas</option>
                                @foreach(\App\Models\Log::getActions() as $action => $label)
                                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="module" class="form-label">Módulo</label>
                            <select class="form-select" id="module" name="module">
                                <option value="">Todos</option>
                                @foreach(\App\Models\Log::getModules() as $module => $label)
                                    <option value="{{ $module }}" {{ request('module') === $module ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">Desde</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">Hasta</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i>Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de logs -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Registros ({{ $logs->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Módulo</th>
                                        <th>Entidad</th>
                                        <th>Descripción</th>
                                        <th>IP</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-secondary text-white rounded-circle">
                                                            {{ strtoupper(substr(is_array($log->userName) ? 'S' : $log->userName, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ is_array($log->userName) ? json_encode($log->userName) : $log->userName }}</h6>
                                                        @if($log->user)
                                                            <small class="text-muted">{{ $log->user->email }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $log->getActionColor() }}">
                                                    {{ is_array($log->formatted_action) ? json_encode($log->formatted_action) : $log->formatted_action }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ is_array($log->formatted_module) ? json_encode($log->formatted_module) : $log->formatted_module }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <code class="small">{{ Str::limit(is_array($log->entityId) ? json_encode($log->entityId) : $log->entityId, 8) }}</code>
                                                    @if($log->entityName)
                                                        <br><small class="text-muted">{{ Str::limit(is_array($log->entityName) ? json_encode($log->entityName) : $log->entityName, 20) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($log->description)
                                                    <span title="{{ is_array($log->description) ? json_encode($log->description) : $log->description }}">
                                                        {{ Str::limit(is_array($log->description) ? json_encode($log->description) : $log->description, 40) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ is_array($log->full_description) ? json_encode($log->full_description) : $log->full_description }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <code class="small">{{ is_array($log->ipAddress) ? json_encode($log->ipAddress) : $log->ipAddress }}</code>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $log->createdAt->format('d/m/Y') }}
                                                    <br><small class="text-muted">{{ $log->createdAt->format('H:i:s') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('logs.show', $log->id) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($log->hasDataChanges())
                                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                                title="Ver cambios" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#changesModal{{ $log->id }}">
                                                            <i class="fas fa-exchange-alt"></i>
                                                        </button>
                                                    @endif
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
                                Mostrando <strong>{{ $logs->firstItem() }}</strong> a <strong>{{ $logs->lastItem() }}</strong> 
                                de <strong>{{ $logs->total() }}</strong> resultados
                            </div>
                            <div class="pagination-nav">
                                {{ $logs->appends(request()->query())->links('custom.pagination') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron registros</h5>
                            <p class="text-muted">No hay registros que coincidan con los criterios de búsqueda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales para ver cambios -->
@foreach($logs as $log)
    @if($log->hasDataChanges())
        <div class="modal fade" id="changesModal{{ $log->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambios realizados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if($log->previousData)
                                <div class="col-md-6">
                                    <h6 class="text-danger">Datos anteriores:</h6>
                                    <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->previousData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                </div>
                            @endif
                            @if($log->newData)
                                <div class="col-md-6">
                                    <h6 class="text-success">Datos nuevos:</h6>
                                    <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                </div>
                            @endif
                        </div>
                        @if($log->getChanges())
                            <hr>
                            <h6>Resumen de cambios:</h6>
                            <ul class="list-group list-group-flush">
                                @foreach($log->getChanges() as $field => $changes)
                                    <li class="list-group-item">
                                        <strong>{{ $field }}:</strong>
                                        <span class="text-danger">{{ is_array($changes['old'] ?? 'N/A') ? json_encode($changes['old']) : ($changes['old'] ?? 'N/A') }}</span>
                                        <span class="arrow-icon mx-2">→</span>
                                        <span class="text-success">{{ is_array($changes['new'] ?? 'N/A') ? json_encode($changes['new']) : ($changes['new'] ?? 'N/A') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    color: #5a5c69;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

pre {
    max-height: 300px;
    overflow-y: auto;
    font-size: 0.875rem;
}

/* Estilos mejorados para las flechas */
.arrow-icon {
    font-size: 1.2rem;
    font-weight: bold;
    color: #6c757d;
    display: inline-block;
    vertical-align: middle;
    line-height: 1;
}

/* Asegurar que los iconos de FontAwesome se muestren correctamente */
.fas, .far, .fab {
    font-family: "Font Awesome 5 Free", "Font Awesome 5 Pro", "Font Awesome 5 Brands" !important;
    font-weight: 900;
}

/* Mejorar la apariencia de los badges */
.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

/* Mejorar el espaciado en la tabla */
.table td {
    vertical-align: middle;
    padding: 0.75rem;
}

/* Estilos para los modales de cambios */
.modal-body pre {
    background-color: #f8f9fa !important;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

/* Mejorar la visualización de códigos */
code {
    background-color: #f8f9fa;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

/* Estilos personalizados para el paginado */
.pagination {
    margin: 0;
    justify-content: center;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    color: #6c757d;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    box-shadow: 0 2px 4px rgba(0,123,255,0.25);
}

.pagination .page-item.disabled .page-link {
    color: #adb5bd;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
    font-weight: 600;
}

.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background-color: #e9ecef;
    color: #495057;
}

/* Contenedor de paginación mejorado */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0.75rem;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.pagination-info {
    color: #495057;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.pagination-info i {
    color: #6c757d;
}

.pagination-nav {
    display: flex;
    align-items: center;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .pagination-info {
        order: 2;
        margin-top: 0.75rem;
        font-size: 0.8rem;
    }
    
    .pagination-nav {
        order: 1;
    }
    
    .pagination .page-item {
        margin: 0 1px;
    }
}

@media (max-width: 576px) {
    .pagination .page-link {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }
    
    .pagination .page-item {
        margin: 0;
    }
}
</style>
@endsection

@push('scripts')
<script>
// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const selects = form.querySelectorAll('select');
    const dateInputs = form.querySelectorAll('input[type="date"]');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            form.submit();
        });
    });
    
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            form.submit();
        });
    });
});
</script>
@endpush