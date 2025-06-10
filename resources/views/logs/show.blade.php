@extends('layouts.app')

@section('title', 'Registro: ' . $log->formatted_action . ' - ' . $log->formatted_module)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logs.index') }}">Registros</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $log->formatted_action }} - {{ $log->formatted_module }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 text-gray-800">Detalle del Registro</h1>
                    <p class="mb-0 text-muted">Información completa del registro del sistema</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('logs.export', ['id' => $log->id]) }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Exportar
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Información Principal -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Información Principal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Usuario</label>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            <div class="avatar-title bg-secondary text-white rounded-circle">
                                                {{ strtoupper(substr($log->userName, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="h6 mb-0">{{ $log->userName }}</p>
                                            @if($log->user)
                                                <small class="text-muted">{{ $log->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha y Hora</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $log->createdAt->format('d/m/Y H:i:s') }}
                                        <br>
                                        <small class="text-muted">{{ $log->createdAt->diffForHumans() }}</small>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Acción</label>
                                    <div>
                                        <span class="badge bg-{{ $log->getActionColor() }} fs-6">
                                            <i class="fas fa-{{ $log->getActionIcon() }} me-1"></i>
                                            {{ $log->formatted_action }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Módulo</label>
                                    <div>
                                        <span class="badge bg-light text-dark fs-6">
                                            <i class="fas fa-{{ $log->getModuleIcon() }} me-1"></i>
                                            {{ $log->formatted_module }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">ID de Entidad</label>
                                    <p class="mb-0">
                                        <code class="fs-6">{{ $log->entityId }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre de Entidad</label>
                                    <p class="mb-0">
                                        {{ $log->entityName ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Descripción</label>
                                    <p class="mb-0">
                                        {{ $log->description ?? $log->full_description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Técnica -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-server me-2"></i>Información Técnica
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Dirección IP</label>
                                    <p class="mb-0">
                                        <code class="fs-6">{{ $log->ipAddress }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">User Agent</label>
                                    <p class="mb-0 small">
                                        {{ $log->userAgent ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">ID del Registro</label>
                                    <p class="mb-0">
                                        <code class="fs-6">{{ $log->id }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Última Actualización</label>
                                    <p class="mb-0">
                                        {{ $log->updatedAt->format('d/m/Y H:i:s') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos de Cambios -->
                    @if($log->hasDataChanges())
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-exchange-alt me-2"></i>Cambios Realizados
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($log->getChanges())
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Campo</th>
                                                    <th class="text-danger">Valor Anterior</th>
                                                    <th class="text-success">Valor Nuevo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($log->getChanges() as $field => $changes)
                                                    <tr>
                                                        <td><strong>{{ $field }}</strong></td>
                                                        <td class="text-danger">
                                                            <code>{{ $changes['old'] ?? 'N/A' }}</code>
                                                        </td>
                                                        <td class="text-success">
                                                            <code>{{ $changes['new'] ?? 'N/A' }}</code>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Panel Lateral -->
                <div class="col-lg-4">
                    <!-- Datos Anteriores -->
                    @if($log->previousData)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-danger">
                                    <i class="fas fa-minus-circle me-2"></i>Datos Anteriores
                                </h6>
                            </div>
                            <div class="card-body">
                                <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->previousData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                        </div>
                    @endif

                    <!-- Datos Nuevos -->
                    @if($log->newData)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    <i class="fas fa-plus-circle me-2"></i>Datos Nuevos
                                </h6>
                            </div>
                            <div class="card-body">
                                <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                        </div>
                    @endif

                    <!-- Acciones Relacionadas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">
                                <i class="fas fa-link me-2"></i>Acciones Relacionadas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($log->user)
                                    <a href="{{ route('users.show', $log->user->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user me-2"></i>Ver Usuario
                                    </a>
                                @endif
                                
                                <a href="{{ route('logs.index', ['user_id' => $log->userId]) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-history me-2"></i>Otros registros del usuario
                                </a>
                                
                                <a href="{{ route('logs.index', ['module' => $log->module, 'entity_id' => $log->entityId]) }}" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-search me-2"></i>Registros de esta entidad
                                </a>
                                
                                <a href="{{ route('logs.index', ['action' => $log->action]) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-filter me-2"></i>Registros de esta acción
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas Rápidas -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-secondary">
                                <i class="fas fa-chart-pie me-2"></i>Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border-end">
                                        <h5 class="text-primary mb-0">{{ \App\Models\Log::where('userId', $log->userId)->count() }}</h5>
                                        <small class="text-muted">Registros del usuario</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <h5 class="text-info mb-0">{{ \App\Models\Log::where('module', $log->module)->count() }}</h5>
                                    <small class="text-muted">Registros del módulo</small>
                                </div>
                                <div class="col-6">
                                    <div class="border-end">
                                        <h5 class="text-success mb-0">{{ \App\Models\Log::where('action', $log->action)->count() }}</h5>
                                        <small class="text-muted">Registros de la acción</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-warning mb-0">{{ \App\Models\Log::where('ipAddress', $log->ipAddress)->count() }}</h5>
                                    <small class="text-muted">Registros de la IP</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

pre {
    max-height: 300px;
    overflow-y: auto;
    font-size: 0.875rem;
}

.border-end {
    border-right: 1px solid #dee2e6;
}

.card-header h6 {
    color: #5a5c69;
}
</style>
@endsection