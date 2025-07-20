@extends('layouts.app')

@section('title', 'Panel de control - Vilba')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header rounded mb-4">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">Panel de control Principal</h1>
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
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <button id="enable-notifications-btn" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-bell fa-2x mb-2"></i>
                                        <span>Activar Notificaciones</span>
                                    </button>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <button id="test-notification-btn" class="btn btn-outline-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="display: none;">
                                        <i class="fas fa-paper-plane fa-2x mb-2"></i>
                                        <span>Notificación de Prueba</span>
                                    </button>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <button id="send-token-btn" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-bell fa-2x mb-2"></i>
                                        <span>Enviar Token al API</span>
                                    </button>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-history me-2"></i>Actividad Reciente del Sistema
                                </h6>
                                <div class="d-flex align-items-center">
                                    <button id="create-test-log-btn" class="btn btn-sm btn-outline-primary me-2" onclick="createTestLog()">Crear Log de Prueba</button>
                                    <small class="text-muted me-2">Última actualización: <span id="last-update-time">--:--:--</span></small>
                                    <span id="auto-update-status" class="badge bg-success">Actualizando automáticamente</span>
                                </div>
                            </div>
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
        
        console.log('🔄 Actualizando logs...', new Date().toLocaleTimeString());
        
        fetch('/api/recent-logs?t=' + Date.now(), {
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
            console.log('📊 Datos recibidos:', {
                success: data.success,
                logsCount: data.logs ? data.logs.length : 0,
                timestamp: data.timestamp,
                totalLogs: data.total_logs,
                debugInfo: data.debug_info
            });
            
            if (data.success) {
                console.log('✅ Respuesta exitosa del servidor');
                console.log('🔍 Análisis detallado de logs:', {
                    logsExists: !!data.logs,
                    logsIsArray: Array.isArray(data.logs),
                    logsLength: data.logs ? data.logs.length : 'N/A',
                    logsType: typeof data.logs,
                    firstLogSample: data.logs && data.logs.length > 0 ? data.logs[0] : 'No hay logs'
                });
                
                if (data.logs && Array.isArray(data.logs) && data.logs.length > 0) {
                    console.log('📝 Logs válidos recibidos:', data.logs.map(log => ({
                        id: log.id,
                        userName: log.userName,
                        action: log.action,
                        rawDate: log.rawDate,
                        timeAgo: log.timeAgo
                    })));
                    updateLogsTable(data.logs);
                } else {
                    console.log('⚠️ No hay logs disponibles o logs inválidos:', {
                        logs: data.logs,
                        reason: !data.logs ? 'logs es null/undefined' : 
                               !Array.isArray(data.logs) ? 'logs no es array' : 
                               'logs array está vacío'
                    });
                    
                    // Si hay contenido inicial guardado, restaurarlo en lugar de mostrar mensaje vacío
                    if (window.initialLogsContent) {
                        console.log('🔄 Restaurando contenido inicial guardado');
                        const container = document.getElementById('recent-logs-container');
                        if (container) {
                            container.innerHTML = window.initialLogsContent;
                        }
                    } else {
                        showNoLogsMessage();
                    }
                }
            } else {
                console.log('❌ Error en respuesta del servidor:', {
                    success: data.success,
                    message: data.message || 'Sin mensaje de error',
                    fullResponse: data
                });
                
                // Si hay contenido inicial guardado, restaurarlo en lugar de mostrar mensaje vacío
                if (window.initialLogsContent) {
                    console.log('🔄 Restaurando contenido inicial por error del servidor');
                    const container = document.getElementById('recent-logs-container');
                    if (container) {
                        container.innerHTML = window.initialLogsContent;
                    }
                } else {
                    showNoLogsMessage();
                }
            }
            
            // Actualizar tiempo de última actualización
            const now = new Date();
            if (lastUpdateTime) {
                lastUpdateTime.textContent = now.toLocaleTimeString('es-ES', { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                });
            }
        })
        .catch(error => {
            console.error('❌ Error al actualizar logs:', error);
            
            // Si hay contenido inicial guardado, restaurarlo en lugar de mostrar mensaje vacío
            if (window.initialLogsContent) {
                console.log('🔄 Restaurando contenido inicial por error de red');
                const container = document.getElementById('recent-logs-container');
                if (container) {
                    container.innerHTML = window.initialLogsContent;
                }
            } else {
                showNoLogsMessage();
            }
        })
        .finally(() => {
            isUpdating = false;
        });
    }
    
    function updateLogsTable(logs) {
        console.log('🔧 Actualizando tabla con', logs.length, 'logs');
        
        const container = document.getElementById('recent-logs-container');
        if (!container) {
            console.error('❌ Contenedor recent-logs-container no encontrado');
            return;
        }
        
        // Guardar el HTML anterior para comparar
        const previousHTML = container.innerHTML;
        
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
        
        logs.forEach((log, index) => {
            console.log(`📋 Log ${index + 1}:`, {
                id: log.id,
                userName: log.userName,
                action: log.action,
                timeAgo: log.timeAgo,
                rawDate: log.rawDate
            });
            
            tableHTML += `
                <tr data-log-id="${log.id}" data-raw-date="${log.rawDate}">
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
        
        // Verificar si el contenido cambió
        const contentChanged = previousHTML !== tableHTML;
        console.log('🔄 ¿Contenido cambió?', contentChanged);
        
        if (contentChanged) {
            console.log('✅ Actualizando DOM con nuevo contenido');
        } else {
            console.log('⚠️ El contenido es idéntico al anterior');
        }
        
        container.innerHTML = tableHTML;
        console.log('✅ Tabla actualizada exitosamente');
        }
        
        // Función para crear logs de prueba (SOLO PARA DEBUG)
        function createTestLog() {
            const btn = document.getElementById('create-test-log-btn');
            btn.disabled = true;
            btn.textContent = 'Creando...';
            
            fetch('/api/create-test-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('🧪 Resultado de crear log de prueba:', data);
                if (data.success) {
                    console.log('✅ Log de prueba creado exitosamente');
                    // Forzar actualización inmediata
                    setTimeout(() => {
                        updateRecentLogs();
                    }, 500);
                } else {
                    console.error('❌ Error al crear log de prueba:', data.message);
                }
            })
            .catch(error => {
                console.error('❌ Error en la petición:', error);
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Crear Log de Prueba';
            });
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
    
    function startAutoUpdate(skipInitialUpdate = false) {
        // Solo realizar actualización inmediata si no hay contenido inicial o se especifica
        const container = document.getElementById('recent-logs-container');
        const hasInitialContent = container && container.innerHTML.trim() !== '' && !container.innerHTML.includes('No hay actividad reciente');
        
        console.log('🚀 Iniciando auto-update. ¿Saltar actualización inicial?', skipInitialUpdate, '¿Hay contenido inicial?', hasInitialContent);
        
        // Guardar el contenido inicial para poder restaurarlo si es necesario
        if (hasInitialContent && !window.initialLogsContent) {
            window.initialLogsContent = container.innerHTML;
            console.log('💾 Contenido inicial guardado para respaldo');
        }
        
        if (!skipInitialUpdate && !hasInitialContent) {
            console.log('📥 Realizando actualización inicial');
            updateRecentLogs();
        } else {
            console.log('⏭️ Saltando actualización inicial - preservando contenido existente');
        }
        
        // Configurar actualización cada 5 segundos
        updateInterval = setInterval(updateRecentLogs, 5000);
        
        // Actualizar estado
        const status = document.getElementById('auto-update-status');
        if (status) {
            status.textContent = 'Actualización automática activa';
            status.className = 'badge bg-success ms-2';
        }
    }
    
    function stopAutoUpdate() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        
        // Actualizar estado
        const status = document.getElementById('auto-update-status');
        if (status) {
            status.textContent = 'Actualización automática pausada';
            status.className = 'badge bg-warning ms-2';
        }
    }
    
    // Debug: Verificar contenido inicial al cargar la página
    console.log('🔍 Verificando contenido inicial al cargar la página');
    const initialContainer = document.getElementById('recent-logs-container');
    if (initialContainer) {
        console.log('📋 Contenido inicial encontrado:', {
            hasContent: initialContainer.innerHTML.trim() !== '',
            contentLength: initialContainer.innerHTML.length,
            containsNoLogsMessage: initialContainer.innerHTML.includes('No hay actividad reciente'),
            contentPreview: initialContainer.innerHTML.substring(0, 200) + '...'
        });
    } else {
        console.error('❌ Contenedor initial no encontrado');
    }
    
    // Esperar un poco antes de iniciar para permitir que se cargue el contenido inicial
    setTimeout(() => {
        console.log('⏰ Iniciando auto-update después de 2 segundos');
        startAutoUpdate(true); // Saltar la primera actualización para preservar contenido inicial
    }, 2000);
    
    // Pausar actualización cuando la pestaña no está visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoUpdate();
        } else {
            startAutoUpdate(false); // Permitir actualización inmediata al volver a la pestaña
        }
    });
    
    // Limpiar interval al salir de la página
    window.addEventListener('beforeunload', function() {
        stopAutoUpdate();
    });
    
    // Show Brave browser specific alert
    window.showBraveAlert = function() {
        const alertHTML = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="brave-alert">
                <h5 class="alert-heading"><i class="fab fa-brave"></i> Brave Browser Detectado</h5>
                <p><strong>Las notificaciones están deshabilitadas por defecto en Brave por razones de privacidad.</strong></p>
                <hr>
                <h6>Para habilitar las notificaciones:</h6>
                <ol>
                    <li>Ve a <code>brave://settings/privacy</code></li>
                    <li>Busca "<strong>Use Google services for push messaging</strong>"</li>
                    <li>Activa esta opción</li>
                    <li>Reinicia el navegador</li>
                    <li>Regresa a esta página y prueba nuevamente</li>
                </ol>
                <hr>
                <p class="mb-0">
                    <strong>Alternativas:</strong><br>
                    • Usa Chrome, Firefox o Edge para mejor compatibilidad<br>
                    • Las notificaciones funcionan en Brave para Android
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Insert alert at the top of the main content
        const mainContent = document.querySelector('.container-fluid');
        if (mainContent && !document.getElementById('brave-alert')) {
            mainContent.insertAdjacentHTML('afterbegin', alertHTML);
            
            // Auto-hide after 15 seconds
            setTimeout(() => {
                const alert = document.getElementById('brave-alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 15000);
        }
    };
    
    // Firebase Notifications Management
    function updateNotificationButtonState() {
        const btn = document.getElementById('enable-notifications-btn');
        const testBtn = document.getElementById('test-notification-btn');
        if (!btn) return;
        
        if ('Notification' in window) {
            const permission = Notification.permission;
            
            switch(permission) {
                case 'granted':
                    btn.innerHTML = '<i class="fas fa-bell fa-2x mb-2 text-success"></i><span>Notificaciones Activas</span>';
                    btn.className = 'btn btn-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                    btn.disabled = true;
                    if (testBtn) testBtn.style.display = 'block';
                    break;
                case 'denied':
                    btn.innerHTML = '<i class="fas fa-bell-slash fa-2x mb-2 text-danger"></i><span>Notificaciones Bloqueadas</span>';
                    btn.className = 'btn btn-danger btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                    btn.disabled = true;
                    if (testBtn) testBtn.style.display = 'none';
                    break;
                default:
                    btn.innerHTML = '<i class="fas fa-bell fa-2x mb-2"></i><span>Activar Notificaciones</span>';
                    btn.className = 'btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                    btn.disabled = false;
                    if (testBtn) testBtn.style.display = 'none';
            }
        } else {
            btn.innerHTML = '<i class="fas fa-times fa-2x mb-2 text-muted"></i><span>No Soportado</span>';
            btn.className = 'btn btn-secondary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
            btn.disabled = true;
            if (testBtn) testBtn.style.display = 'none';
        }
    }
    
    // Add click event listener to notification button
    document.getElementById('enable-notifications-btn').addEventListener('click', async function() {
        const btn = this;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin fa-2x mb-2"></i><span>Solicitando...</span>';
        btn.disabled = true;
        
        try {
            // Detailed error checking
            if (typeof firebase === 'undefined') {
                throw new Error('Firebase SDK no está cargado. Verifica la conexión a internet y que los scripts de Firebase estén incluidos correctamente.');
            }
            
            if (typeof requestNotificationPermission !== 'function') {
                const errorDetails = [];
                errorDetails.push('Función requestNotificationPermission no encontrada');
                
                if (window.firebaseError) {
                    errorDetails.push('Error de Firebase: ' + window.firebaseError);
                }
                
                if (typeof firebase !== 'undefined') {
                    errorDetails.push('Firebase SDK está cargado pero la función no se inicializó');
                }
                
                throw new Error(errorDetails.join('\n'));
            }
            
            await requestNotificationPermission();
            
        } catch (error) {
            console.error('Error requesting notification permission:', error);
            
            // Show detailed error information
            let errorMessage = 'Error al solicitar permisos de notificación:\n\n';
            errorMessage += error.message + '\n\n';
            errorMessage += 'Información técnica:\n';
            errorMessage += '- Firebase disponible: ' + (typeof firebase !== 'undefined' ? 'Sí' : 'No') + '\n';
            errorMessage += '- Función disponible: ' + (typeof requestNotificationPermission === 'function' ? 'Sí' : 'No') + '\n';
            errorMessage += '- Navegador soporta notificaciones: ' + ('Notification' in window ? 'Sí' : 'No') + '\n';
            errorMessage += '- Service Worker soportado: ' + ('serviceWorker' in navigator ? 'Sí' : 'No');
            
            alert(errorMessage);
        } finally {
            setTimeout(updateNotificationButtonState, 1000);
        }
    });
    
    // Test notification function
    function sendTestNotification() {
        console.log('🧪 Enviando notificación de prueba...');
        
        // Verificar soporte del navegador
        if (!('Notification' in window)) {
            alert('❌ Error: Tu navegador no soporta notificaciones web.');
            return;
        }
        
        // Verificar permisos
        if (Notification.permission !== 'granted') {
            alert('❌ Error: Las notificaciones no están habilitadas.\n\nPor favor, haz clic en "Activar Notificaciones" primero.');
            return;
        }
        
        try {
            // Crear notificación de prueba
            const notification = new Notification('🎉 Notificación de Prueba - Vilba', {
                body: 'Esta es una notificación de prueba del sistema Vilba. ¡Todo funciona correctamente! 🚀',
                icon: '/assets/img/favicon.ico',
                badge: '/assets/img/favicon.ico',
                tag: 'vilba-test-notification',
                requireInteraction: false,
                silent: false,
                timestamp: Date.now(),
                data: {
                    type: 'test',
                    source: 'dashboard',
                    timestamp: new Date().toISOString()
                }
            });
            
            // Manejar click en la notificación
            notification.onclick = function(event) {
                console.log('👆 Usuario hizo clic en la notificación de prueba');
                window.focus();
                notification.close();
                
                // Mostrar mensaje de confirmación
                setTimeout(() => {
                    alert('✅ ¡Perfecto! La notificación funciona correctamente.\n\nAhora puedes recibir notificaciones del sistema Vilba.');
                }, 100);
            };
            
            // Manejar errores
            notification.onerror = function(event) {
                console.error('❌ Error en la notificación:', event);
                alert('❌ Error al mostrar la notificación. Verifica la configuración del navegador.');
            };
            
            // Auto cerrar después de 8 segundos
            setTimeout(() => {
                if (notification) {
                    notification.close();
                    console.log('⏰ Notificación de prueba cerrada automáticamente');
                }
            }, 8000);
            
            console.log('✅ Notificación de prueba enviada exitosamente');
            
            // Mostrar feedback visual temporal
            const testBtn = document.getElementById('test-notification-btn');
            if (testBtn) {
                const originalHTML = testBtn.innerHTML;
                testBtn.innerHTML = '<i class="fas fa-check fa-2x mb-2 text-success"></i><span>¡Enviada!</span>';
                testBtn.disabled = true;
                
                setTimeout(() => {
                    testBtn.innerHTML = originalHTML;
                    testBtn.disabled = false;
                }, 2000);
            }
            
        } catch (error) {
            console.error('❌ Error creando notificación:', error);
            alert('❌ Error al crear la notificación:\n\n' + error.message + '\n\nVerifica que las notificaciones estén habilitadas en tu navegador.');
        }
    }
    
    // Add click event listener to test notification button
    document.getElementById('test-notification-btn').addEventListener('click', sendTestNotification);
    
    // Function to manually send token to NestJS API with retry mechanism
    async function sendTokenToNestJS() {
        const btn = document.getElementById('send-token-btn');
        const originalHTML = btn.innerHTML;
        let attempt = 0;
        const maxAttempts = 3;
        
        async function attemptTokenSend() {
            attempt++;
            console.log(`🔔 Intento ${attempt}/${maxAttempts} - Iniciando envío de token al API de NestJS...`);
            
            try {
                btn.innerHTML = `<i class="fas fa-spinner fa-spin fa-2x mb-2"></i><span>Enviando... (${attempt}/${maxAttempts})</span>`;
                btn.disabled = true;
                
                // Check if Firebase is available
                if (typeof firebase === 'undefined') {
                    throw new Error('Firebase SDK no está disponible');
                }
                
                // Check if messaging is available
                if (!firebase.messaging) {
                    throw new Error('Firebase Messaging no está disponible');
                }
                
                // Get messaging instance
                const messaging = firebase.messaging();
                
                // Get FCM token using EXACTLY the same method as firebase.js (NO token deletion)
                console.log('📱 Obteniendo token FCM usando método idéntico a firebase.js...');
                let token;
                
                try {
                    // Use EXACTLY the same method as firebase.js - no token deletion
                    token = await messaging.getToken({
                        vapidKey: 'BCiin0ow6U8uJa2FcqshHjNsElo7wwSXGA6og15X-0xv30KOAGMcA1iMaKKYlzquh9J-IhWRIpvrKloF51Oa1lQ'
                    });
                    
                    console.log('🎯 Token obtenido con método idéntico a firebase.js (sin eliminar token previo)');
                    
                } catch (tokenError) {
                    console.error('❌ Error obteniendo token FCM:', tokenError);
                    
                    // Use EXACTLY the same fallback as firebase.js
                    if (tokenError.name === 'AbortError' || tokenError.message.includes('Registration failed')) {
                        console.log('🔄 Error de registro detectado, usando fallback de firebase.js...');
                        
                        // Request permission again (same as firebase.js)
                        const permission = await Notification.requestPermission();
                        if (permission !== 'granted') {
                            throw new Error('Permisos de notificación denegados');
                        }
                        
                        // Wait and try again (same as firebase.js)
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        
                        // Try getting token again with fresh messaging instance
                        const newMessaging = firebase.messaging();
                        token = await newMessaging.getToken({
                            vapidKey: 'BCiin0ow6U8uJa2FcqshHjNsElo7wwSXGA6og15X-0xv30KOAGMcA1iMaKKYlzquh9J-IhWRIpvrKloF51Oa1lQ'
                        });
                        
                        console.log('✅ Token obtenido con método de respaldo de firebase.js');
                    } else {
                        throw tokenError;
                    }
                }
                
                if (!token) {
                     throw new Error('No se pudo obtener el token FCM después de múltiples intentos');
                 }
                 
                 // Validate token is not empty or null
                 if (typeof token !== 'string' || token.trim() === '') {
                     throw new Error(`Token FCM inválido: '${token}' (tipo: ${typeof token})`);
                 }
                 
                 console.log('✅ Token FCM obtenido y validado:', {
                     token: token,
                     length: token.length,
                     type: typeof token,
                     preview: token.substring(0, 50) + '...'
                 });
                
                // Get user ID from localStorage
                const userId = localStorage.getItem('user_id');
                console.log('👤 User ID desde localStorage:', userId);
                
                if (!userId) {
                    throw new Error('User ID no encontrado en localStorage');
                }
                
                // Prepare request body (matching NestJS API format - same as firebase.js)
                 const requestBody = {
                     token: token,  // Using 'token' field like firebase.js
                     userId: userId,
                     platform: 'web',
                     deviceInfo: {
                         brand: navigator.platform || 'Unknown',
                         modelName: navigator.userAgent.split('(')[1]?.split(')')[0] || 'Unknown',
                         osName: navigator.platform.includes('Win') ? 'Windows' : 
                                navigator.platform.includes('Mac') ? 'macOS' : 
                                navigator.platform.includes('Linux') ? 'Linux' : 'Unknown',
                         osVersion: navigator.userAgent.match(/(?:Windows NT|Mac OS X|Linux) ([\d\._]+)/)?.[1] || 'Unknown'
                     },
                     deviceName: `${navigator.userAgent.includes('Chrome') ? 'Chrome' : 
                                 navigator.userAgent.includes('Firefox') ? 'Firefox' : 
                                 navigator.userAgent.includes('Safari') ? 'Safari' : 'Unknown'} Browser - ${navigator.platform.includes('Win') ? 'Windows' : 
                                navigator.platform.includes('Mac') ? 'macOS' : 
                                navigator.platform.includes('Linux') ? 'Linux' : 'Unknown'}`,
                     appVersion: '1.0.0',
                     metadata: {
                         browser: navigator.userAgent.includes('Chrome') ? 'Chrome' : 
                                 navigator.userAgent.includes('Firefox') ? 'Firefox' : 
                                 navigator.userAgent.includes('Safari') ? 'Safari' : 'Unknown',
                         userAgent: navigator.userAgent,
                         timestamp: new Date().toISOString(),
                         attempt: attempt,
                         retryReason: attempt > 1 ? 'Token registration retry' : 'Initial attempt'
                     }
                 };
                
                console.log('📤 Datos a enviar al NestJS API:', requestBody);
                 
                 // Final validation before sending
                 if (!requestBody.token || requestBody.token.trim() === '') {
                     throw new Error(`Token vacío en requestBody: '${requestBody.token}'`);
                 }
                 
                 console.log('🔍 Validación final del token antes del envío:', {
                     tokenPresent: !!requestBody.token,
                     tokenLength: requestBody.token ? requestBody.token.length : 0,
                     tokenPreview: requestBody.token ? requestBody.token.substring(0, 30) + '...' : 'N/A'
                 });
                 
                 // Send to NestJS API with timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
                
                try {
                    const response = await fetch('http://192.168.100.169:3000/devices/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(requestBody),
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    console.log('📡 Respuesta del servidor - Status:', response.status);
                    console.log('📡 Respuesta del servidor - Headers:', Object.fromEntries(response.headers.entries()));
                    
                    const responseText = await response.text();
                    console.log('📡 Respuesta del servidor - Body:', responseText);
                    
                    if (response.ok) {
                        console.log('✅ Token enviado exitosamente al API de NestJS');
                        btn.innerHTML = '<i class="fas fa-check fa-2x mb-2 text-success"></i><span>¡Enviado!</span>';
                        btn.className = 'btn btn-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                        
                        // Show success message
                        alert(`✅ ¡Token enviado exitosamente al API de NestJS!\n\nIntento: ${attempt}/${maxAttempts}\nRespuesta del servidor: ${responseText}`);
                        return true; // Success
                    } else {
                        throw new Error(`Error del servidor: ${response.status} - ${responseText}`);
                    }
                } catch (fetchError) {
                    clearTimeout(timeoutId);
                    throw fetchError;
                }
                
            } catch (error) {
                console.error(`❌ Error en intento ${attempt}:`, error);
                
                // If this is not the last attempt, try again
                if (attempt < maxAttempts) {
                    console.log(`🔄 Reintentando en 2 segundos... (${attempt + 1}/${maxAttempts})`);
                    await new Promise(resolve => setTimeout(resolve, 2000));
                    return attemptTokenSend();
                } else {
                    // Last attempt failed, show detailed error
                    btn.innerHTML = '<i class="fas fa-times fa-2x mb-2 text-danger"></i><span>Error</span>';
                    btn.className = 'btn btn-danger btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                    
                    // Create detailed error message
                    let errorDetails = `❌ Error enviando token al API de NestJS después de ${maxAttempts} intentos:\n\n`;
                    errorDetails += `🔍 DETALLES TÉCNICOS:\n`;
                    errorDetails += `• Tipo de Error: ${error.name || 'Unknown'}\n`;
                    errorDetails += `• Mensaje: ${error.message}\n`;
                    errorDetails += `• Intentos realizados: ${attempt}/${maxAttempts}\n`;
                    errorDetails += `• Navegador: ${navigator.userAgent.includes('Chrome') ? 'Chrome' : navigator.userAgent.includes('Firefox') ? 'Firefox' : navigator.userAgent.includes('Safari') ? 'Safari' : 'Unknown'}\n`;
                    errorDetails += `• Plataforma: ${navigator.platform}\n`;
                    errorDetails += `• Permisos de notificación: ${Notification.permission}\n`;
                    errorDetails += `• Firebase disponible: ${typeof firebase !== 'undefined'}\n`;
                    errorDetails += `• Firebase Messaging disponible: ${typeof firebase !== 'undefined' && !!firebase.messaging}\n\n`;
                    
                    if (error.name === 'AbortError' || error.message.includes('Registration failed')) {
                        errorDetails += `🚨 DIAGNÓSTICO ESPECÍFICO - Error de Registro FCM:\n`;
                        errorDetails += `• Este error indica un problema con el servicio de push de Firebase\n`;
                        errorDetails += `• Posibles causas:\n`;
                        errorDetails += `  - Configuración VAPID incorrecta\n`;
                        errorDetails += `  - Problemas de conectividad con los servidores de Google\n`;
                        errorDetails += `  - Restricciones del navegador o firewall\n`;
                        errorDetails += `  - Token FCM expirado o inválido\n\n`;
                        errorDetails += `💡 SOLUCIONES SUGERIDAS:\n`;
                        errorDetails += `• Verificar conexión a internet\n`;
                        errorDetails += `• Limpiar caché del navegador\n`;
                        errorDetails += `• Verificar configuración de Firebase\n`;
                        errorDetails += `• Contactar al administrador del sistema\n`;
                    }
                    
                    errorDetails += `\n📋 Revisa la consola del navegador para logs detallados.`;
                    
                    alert(errorDetails);
                    return false; // Failure
                }
            }
        }
        
        try {
            await attemptTokenSend();
        } finally {
            // Reset button after 3 seconds
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.className = 'btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center';
                btn.disabled = false;
            }, 3000);
        }
    }
    
    // Add click event listener to send token button
    document.getElementById('send-token-btn').addEventListener('click', sendTokenToNestJS);
    
    // Store user ID in localStorage for Firebase
    localStorage.setItem('user_id', '{{ Auth::user()->_id }}');
    
    // Check notification status on page load
    updateNotificationButtonState();
});
</script>
@endpush