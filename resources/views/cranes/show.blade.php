@extends('layouts.app')

@section('title', 'Grúa: ' . $crane->nombre)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cranes.index') }}">Grúas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $crane->nombre }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 text-gray-800">{{ $crane->nombre }}</h1>
                    <p class="mb-0 text-muted">Información detallada de la grúa</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('cranes.edit', $crane->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    @if($crane->estado === 'activo')
                        <form method="POST" action="{{ route('cranes.deactivate', $crane->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary" 
                                    onclick="return confirm('¿Está seguro de desactivar esta grúa?')">
                                <i class="fas fa-pause me-2"></i>Desactivar
                            </button>
                        </form>
                    @elseif($crane->estado === 'inactivo')
                        <form method="POST" action="{{ route('cranes.activate', $crane->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-play me-2"></i>Activar
                            </button>
                        </form>
                    @endif
                    
                    @if($crane->estado !== 'mantenimiento')
                        <form method="POST" action="{{ route('cranes.maintenance', $crane->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning" 
                                    onclick="return confirm('¿Está seguro de poner esta grúa en mantenimiento?')">
                                <i class="fas fa-tools me-2"></i>Mantenimiento
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Información de la Grúa -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-truck-moving me-2"></i>Información Técnica
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre</label>
                                    <p class="h5 mb-0">{{ $crane->nombre }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Estado</label>
                                    <div>
                                        @switch($crane->estado)
                                            @case('activo')
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-check-circle me-1"></i>Activo
                                                </span>
                                                @break
                                            @case('inactivo')
                                                <span class="badge bg-secondary fs-6">
                                                    <i class="fas fa-pause-circle me-1"></i>Inactivo
                                                </span>
                                                @break
                                            @case('mantenimiento')
                                                <span class="badge bg-warning fs-6">
                                                    <i class="fas fa-tools me-1"></i>Mantenimiento
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-dark fs-6">
                                                    {{ ucfirst($crane->estado) }}
                                                </span>
                                        @endswitch
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Marca</label>
                                    <p class="mb-0">
                                        <i class="fas fa-industry me-2"></i>{{ $crane->marca }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Modelo</label>
                                    <p class="mb-0">
                                        <i class="fas fa-tag me-2"></i>{{ $crane->modelo }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Tipo</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info text-dark fs-6">
                                            <i class="fas fa-cogs me-1"></i>{{ ucfirst($crane->tipo) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Capacidad</label>
                                    <p class="mb-0">
                                        <span class="badge bg-primary fs-6">
                                            <i class="fas fa-weight-hanging me-1"></i>{{ number_format($crane->capacidad) }} ton
                                        </span>
                                    </p>
                                </div>
                                @if($crane->category)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-muted">Categoría</label>
                                        <p class="mb-0">
                                            <i class="fas fa-folder me-2"></i>{{ $crane->category }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha de Registro</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $crane->created_at ? $crane->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Última Actualización</label>
                                    <p class="mb-0">
                                        <i class="fas fa-clock me-2"></i>
                                        {{ $crane->updated_at ? $crane->updated_at->format('d/m/Y H:i') : 'No disponible' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Precios por Zona -->
                    @if(!empty($crane->precios) && count($crane->precios) > 0)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-dollar-sign me-2"></i>Precios por Zona
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($crane->precios as $index => $precio)
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-primary">
                                                <div class="card-body">
                                                    <h6 class="card-title text-primary">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ $precio['zona'] }}
                                                    </h6>
                                                    @if(isset($precio['precio']) && is_array($precio['precio']))
                                                        <div class="pricing-tiers">
                                                            @if(isset($precio['precio'][0]) && $precio['precio'][0] > 0)
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <span class="text-muted">Básico:</span>
                                                                    <span class="fw-bold text-success">${{ number_format($precio['precio'][0], 2) }}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($precio['precio'][1]) && $precio['precio'][1] > 0)
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <span class="text-muted">Estándar:</span>
                                                                    <span class="fw-bold text-info">${{ number_format($precio['precio'][1], 2) }}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($precio['precio'][2]) && $precio['precio'][2] > 0)
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-muted">Premium:</span>
                                                                    <span class="fw-bold text-warning">${{ number_format($precio['precio'][2], 2) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p class="text-muted mb-0">Sin precios configurados</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Panel lateral -->
                <div class="col-lg-4">
                    <!-- Resumen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Resumen
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="avatar-circle bg-primary text-white mb-3">
                                    <i class="fas fa-truck-moving fa-2x"></i>
                                </div>
                                <h5 class="mb-1">{{ $crane->marca }} {{ $crane->modelo }}</h5>
                                <p class="text-muted mb-0">{{ ucfirst($crane->tipo) }} - {{ number_format($crane->capacidad) }} ton</p>
                            </div>
                            
                            <hr>
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h6 class="text-primary mb-1">{{ count($crane->precios ?? []) }}</h6>
                                        <small class="text-muted">Zonas de Precio</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-success mb-1">
                                        @if($crane->estado === 'activo')
                                            <i class="fas fa-check-circle"></i> Disponible
                                        @elseif($crane->estado === 'mantenimiento')
                                            <i class="fas fa-tools text-warning"></i> Mantenimiento
                                        @else
                                            <i class="fas fa-times-circle text-danger"></i> No Disponible
                                        @endif
                                    </h6>
                                    <small class="text-muted">Estado Actual</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('cranes.edit', $crane->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Editar Información
                                </a>
                                
                                @if($crane->estado === 'activo')
                                    <form method="POST" action="{{ route('cranes.deactivate', $crane->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-secondary w-100" 
                                                onclick="return confirm('¿Está seguro de desactivar esta grúa?')">
                                            <i class="fas fa-pause me-2"></i>Desactivar Grúa
                                        </button>
                                    </form>
                                @elseif($crane->estado === 'inactivo')
                                    <form method="POST" action="{{ route('cranes.activate', $crane->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success w-100">
                                            <i class="fas fa-play me-2"></i>Activar Grúa
                                        </button>
                                    </form>
                                @endif
                                
                                @if($crane->estado !== 'mantenimiento')
                                    <form method="POST" action="{{ route('cranes.maintenance', $crane->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning w-100" 
                                                onclick="return confirm('¿Está seguro de poner esta grúa en mantenimiento?')">
                                            <i class="fas fa-tools me-2"></i>Poner en Mantenimiento
                                        </button>
                                    </form>
                                @endif
                                
                                <hr>
                                
                                <form method="POST" action="{{ route('cranes.destroy', $crane->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100" 
                                            onclick="return confirm('¿Está seguro de eliminar esta grúa? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash me-2"></i>Eliminar Grúa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Sistema -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-database me-2"></i>Información del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted d-block mb-2">
                                <strong>ID:</strong> {{ $crane->id }}
                            </small>
                            <small class="text-muted d-block mb-2">
                                <strong>Creado:</strong> {{ $crane->created_at ? $crane->created_at->format('d/m/Y H:i:s') : 'No disponible' }}
                            </small>
                            <small class="text-muted d-block">
                                <strong>Actualizado:</strong> {{ $crane->updated_at ? $crane->updated_at->format('d/m/Y H:i:s') : 'No disponible' }}
                            </small>
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
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.pricing-tiers {
    background-color: #f8f9fc;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e3e6f0;
}
</style>
@endpush