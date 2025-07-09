@extends('layouts.app')

@section('title', 'Dashboard - Vilba')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header rounded mb-4">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">Dashboard Principal</h1>
                            <p class="mb-0 opacity-75">Bienvenido, {{ Auth::user()->name }}. Aquí tienes un resumen de tu sistema.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('profile') }}" class="btn btn-outline-light">
                                <i class="fas fa-user me-2"></i>Mi Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Principales -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Clientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClients ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Equipos Disponibles
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $availableEquipment ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-truck-moving fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Cotizaciones Activas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeQuotes ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Equipos en Renta
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rentedEquipment ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-handshake fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda fila de estadísticas -->            
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Registros del Sistema
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLogs ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Actividad Hoy
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayActivity ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-dark shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Usuarios Activos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUsers ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-purple shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">
                                        Errores Recientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentErrors ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                                        <span>Nuevo Cliente</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('cranes.create') }}" class="btn btn-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                        <span>Nuevo Equipo</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('quotes.create') }}" class="btn btn-info btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                                        <span>Nueva Cotización</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('logs.index') }}" class="btn btn-danger btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                        <span>Ver Logs</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('logs.stats') }}" class="btn btn-secondary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                        <span>Estadísticas</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <a href="{{ route('profile') }}" class="btn btn-warning btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-user-cog fa-2x mb-2"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Usuario y Actividad Reciente -->
            <div class="row">
                <!-- Información del Usuario -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user me-2"></i>Información de tu Cuenta
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong class="text-muted">Nombre:</strong><br>
                                    <span class="text-dark">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong class="text-muted">Email:</strong><br>
                                    <span class="text-dark">{{ Auth::user()->email }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong class="text-muted">ID de Usuario:</strong><br>
                                    <code>{{ Auth::user()->_id }}</code>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong class="text-muted">Fecha de Registro:</strong><br>
                                    <span class="text-dark">
                                        {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a href="{{ route('profile') }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Editar Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navegación Rápida -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-compass me-2"></i>Navegación Rápida
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('clients.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <strong>Gestión de Clientes</strong>
                                        <br><small class="text-muted">Administra todos los clientes del sistema</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                                <a href="{{ route('cranes.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-truck-moving text-success me-2"></i>
                                        <strong>Gestión de Equipos</strong>
                                        <br><small class="text-muted">Administra todos los equipos disponibles</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                                <a href="{{ route('quotes.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-invoice text-info me-2"></i>
                                        <strong>Gestión de Cotizaciones</strong>
                                        <br><small class="text-muted">Administra todas las cotizaciones</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                                <a href="{{ route('logs.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-clipboard-list text-danger me-2"></i>
                                        <strong>Registros del Sistema</strong>
                                        <br><small class="text-muted">Historial de actividades y cambios</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente del Sistema -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history me-2"></i>Actividad Reciente del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Indicador de actualización -->
                            <div id="update-indicator" class="d-none">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                        <span class="visually-hidden">Actualizando...</span>
                                    </div>
                                    <small class="text-muted">Actualizando datos...</small>
                                </div>
                            </div>
                            
                            <!-- Contenedor de la tabla que se actualizará -->
                            <div id="recent-logs-container">
                                @if(isset($recentLogs) && $recentLogs->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Acción</th>
                                                    <th>Módulo</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody id="logs-tbody">
                                                @foreach($recentLogs as $log)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title bg-secondary text-white rounded-circle">
                                                                        {{ strtoupper(substr($log->userName ?? 'S', 0, 1)) }}
                                                                    </div>
                                                                </div>
                                                                <span class="fw-bold">{{ $log->userName ?? 'Sistema' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $log->getActionColor() ?? 'secondary' }}">
                                                                {{ $log->formatted_action ?? $log->action }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">
                                                                {{ $log->formatted_module ?? $log->module }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span title="{{ $log->description ?? $log->full_description ?? '' }}">
                                                                {{ Str::limit($log->description ?? $log->full_description ?? 'Sin descripción', 50) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                {{ $log->createdAt ? $log->createdAt->diffForHumans() : ($log->created_at ? $log->created_at->diffForHumans() : 'Fecha no disponible') }}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye me-2"></i>Ver Todos los Registros
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4" id="no-logs-message">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay actividad reciente</h5>
                                        <p class="text-muted">Los registros de actividad aparecerán aquí cuando se realicen acciones en el sistema.</p>
                                        <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-clipboard-list me-2"></i>Ver Registros del Sistema
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Indicador de última actualización -->
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Última actualización: <span id="last-update-time">{{ now()->format('H:i:s') }}</span>
                                    <span class="badge bg-success ms-2" id="auto-update-status">Actualización automática activa</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Estilos para la sección de logs con actualización automática */
.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
}

/* Animación suave para las actualizaciones */
#recent-logs-container {
    transition: opacity 0.3s ease-in-out;
}

#recent-logs-container.updating {
    opacity: 0.7;
}

/* Estilos para el indicador de actualización */
#update-indicator {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 8px;
    padding: 8px 16px;
    border: 1px solid #90caf9;
}

/* Animación del spinner */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

/* Estilos para el indicador de estado */
#auto-update-status {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

/* Animación para las filas nuevas */
@keyframes fadeInRow {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table tbody tr {
    animation: fadeInRow 0.3s ease-in-out;
}

/* Hover effects mejorados */
.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Estilos para badges mejorados */
.badge {
    font-size: 0.7rem;
    padding: 0.35rem 0.65rem;
    border-radius: 6px;
    font-weight: 500;
}

/* Indicador de tiempo de actualización */
#last-update-time {
    font-weight: 600;
    color: #495057;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .avatar-sm {
        width: 28px;
        height: 28px;
    }
    
    .avatar-title {
        font-size: 10px;
    }
    
    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Animaciones para las tarjetas de estadísticas
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Funcionalidad de actualización automática de logs
    let updateInterval;
    let isUpdating = false;
    
    function updateRecentLogs() {
        if (isUpdating) return;
        
        isUpdating = true;
        const updateIndicator = document.getElementById('update-indicator');
        const container = document.getElementById('recent-logs-container');
        const lastUpdateTime = document.getElementById('last-update-time');
        
        // Mostrar indicador de carga
        updateIndicator.classList.remove('d-none');
        
        fetch('/api/recent-logs', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.logs.length > 0) {
                updateLogsTable(data.logs);
            }
            // Si no hay logs nuevos, mantener el contenido actual
            // No llamar a showNoLogsMessage() para preservar los logs iniciales
            
            // Actualizar tiempo de última actualización
            const now = new Date();
            lastUpdateTime.textContent = now.toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
        })
        .catch(error => {
            console.error('Error al actualizar logs:', error);
            // En caso de error, mantener el contenido actual
        })
        .finally(() => {
            // Ocultar indicador de carga
            updateIndicator.classList.add('d-none');
            isUpdating = false;
        });
    }
    
    function updateLogsTable(logs) {
        const container = document.getElementById('recent-logs-container');
        
        let tableHTML = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Módulo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="logs-tbody">`;
        
        logs.forEach(log => {
            tableHTML += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title bg-secondary text-white rounded-circle">
                                    ${log.userInitial}
                                </div>
                            </div>
                            <span class="fw-bold">${log.userName}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-${log.actionColor}">
                            ${log.action}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">
                            ${log.module}
                        </span>
                    </td>
                    <td>
                        <span title="${log.fullDescription}">
                            ${log.description}
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">
                            ${log.timeAgo}
                        </small>
                    </td>
                </tr>`;
        });
        
        tableHTML += `
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-eye me-2"></i>Ver Todos los Registros
                </a>
            </div>`;
        
        container.innerHTML = tableHTML;
    }
    
    function showNoLogsMessage() {
        const container = document.getElementById('recent-logs-container');
        container.innerHTML = `
            <div class="text-center py-4" id="no-logs-message">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay actividad reciente</h5>
                <p class="text-muted">Los registros de actividad aparecerán aquí cuando se realicen acciones en el sistema.</p>
                <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-clipboard-list me-2"></i>Ver Registros del Sistema
                </a>
            </div>`;
    }
    
    function startAutoUpdate() {
        // No actualizar inmediatamente para preservar el contenido inicial
        // Solo configurar la actualización automática
        
        // Configurar actualización cada 5 segundos
        updateInterval = setInterval(updateRecentLogs, 5000);
        
        // Actualizar estado
        const status = document.getElementById('auto-update-status');
        status.textContent = 'Actualización automática activa';
        status.className = 'badge bg-success ms-2';
    }
    
    function stopAutoUpdate() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        
        // Actualizar estado
        const status = document.getElementById('auto-update-status');
        status.textContent = 'Actualización automática pausada';
        status.className = 'badge bg-warning ms-2';
    }
    
    // Iniciar actualización automática
    startAutoUpdate();
    
    // Pausar actualización cuando la pestaña no está visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoUpdate();
        } else {
            startAutoUpdate();
        }
    });
    
    // Limpiar interval al salir de la página
    window.addEventListener('beforeunload', function() {
        stopAutoUpdate();
    });
});
</script>
@endpush