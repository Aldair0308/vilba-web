@extends('layouts.app')

@section('title', 'Gestión de Equipos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Gestión de Equipos</h1>
<p class="mb-0 text-muted">Administra todos los equipos del sistema</p>
                </div>
                <a href="{{ route('cranes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Equipo
                </a>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('cranes.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Marca, modelo, nombre...">
                        </div>
                        <div class="col-md-2">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="mantenimiento" {{ request('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="en_renta" {{ request('estado') === 'en_renta' ? 'selected' : '' }}>En Renta</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="">Todos</option>
                                <option value="torre" {{ request('tipo') === 'torre' ? 'selected' : '' }}>Torre</option>
                                <option value="móvil" {{ request('tipo') === 'móvil' ? 'selected' : '' }}>Móvil</option>
                                <option value="oruga" {{ request('tipo') === 'oruga' ? 'selected' : '' }}>Oruga</option>
                                <option value="camión" {{ request('tipo') === 'camión' ? 'selected' : '' }}>Camión</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Ordenar por</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Fecha creación</option>
                                <option value="nombre" {{ request('sort') === 'nombre' ? 'selected' : '' }}>Nombre</option>
                                <option value="marca" {{ request('sort') === 'marca' ? 'selected' : '' }}>Marca</option>
                                <option value="capacidad" {{ request('sort') === 'capacidad' ? 'selected' : '' }}>Capacidad</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="direction" class="form-label">Orden</label>
                            <select class="form-select" id="direction" name="direction">
                                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Descendente</option>
                                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Equipos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cranes->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-truck-moving fa-2x text-gray-300"></i>
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
                                        Equipos Activos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $cranes->where('estado', 'activo')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        En Mantenimiento
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $cranes->where('estado', 'mantenimiento')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-2x text-gray-300"></i>
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
                                        En Renta
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $cranes->where('estado', 'en_renta')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-handshake fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Equipos Inactivos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $cranes->where('estado', 'inactivo')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de equipos -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Equipos</h6>
                </div>
                <div class="card-body">
                    @if($cranes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Tipo</th>
                                        <th>Capacidad</th>
                                        <th>Estado</th>
                                        <th>Categoría</th>
                                        <th>Precios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cranes as $crane)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3">
                                                        <div class="fw-bold">{{ $crane->nombre }}</div>
                                                        <div class="text-muted small">ID: {{ $crane->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $crane->marca }}</td>
                                            <td>{{ $crane->modelo }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ ucfirst($crane->tipo) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($crane->capacidad) }} ton</td>
                                            <td>
                                                @switch($crane->estado)
                                                    @case('activo')
                                                        <span class="badge bg-success">Activo</span>
                                                        @break
                                                    @case('inactivo')
                                                        <span class="badge bg-danger">Inactivo</span>
                                                        @break
                                                    @case('mantenimiento')
                                                        <span class="badge bg-warning text-dark">Mantenimiento</span>
                                                        @break
                                                    @case('en_renta')
                                                        <span class="badge bg-info">En Renta</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($crane->estado) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $crane->category ?? 'Sin categoría' }}</td>
                                            <td>
                                                @if(!empty($crane->precios) && count($crane->precios) > 0)
                                                    <span class="badge bg-primary">{{ count($crane->precios) }} zona(s)</span>
                                                @else
                                                    <span class="text-muted">Sin precios</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('cranes.show', $crane) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('cranes.edit', $crane) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    @if($crane->estado === 'activo')
                                                        <form action="{{ route('cranes.deactivate', $crane) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-warning" 
                                                                    title="Desactivar"
                                                                    onclick="return confirm('¿Estás seguro de que quieres desactivar este equipo?')">
                                                                <i class="fas fa-pause"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($crane->estado === 'inactivo')
                                                        <form action="{{ route('cranes.activate', $crane) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success" 
                                                                    title="Activar">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if($crane->estado === 'activo')
                                                        <form action="{{ route('cranes.rented', $crane) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-info" 
                                                                    title="Poner en renta"
                                                                    onclick="return confirm('¿Estás seguro de que quieres poner este equipo en renta?')">
                                                                <i class="fas fa-handshake"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($crane->estado === 'en_renta')
                                                        <form action="{{ route('cranes.activate', $crane) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success" 
                                                                    title="Devolver de renta">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if($crane->estado !== 'mantenimiento' && $crane->estado !== 'en_renta')
                                                        <form action="{{ route('cranes.maintenance', $crane) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-warning" 
                                                                    title="Poner en mantenimiento"
                                                                    onclick="return confirm('¿Estás seguro de que quieres poner este equipo en mantenimiento?')">
                                                                <i class="fas fa-tools"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('cranes.destroy', $crane) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Eliminar"
                                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo? Esta acción no se puede deshacer.')">
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
                                <span>Mostrando <strong>{{ $cranes->firstItem() }}</strong> a <strong>{{ $cranes->lastItem() }}</strong> de <strong>{{ $cranes->total() }}</strong> resultados</span>
                            </div>
                            <div class="pagination-nav">
                                {{ $cranes->appends(request()->query())->links('custom.pagination') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck-moving fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">No se encontraron equipos</h5>
<p class="text-muted mb-4">No hay equipos que coincidan con los criterios de búsqueda.</p>
                            <a href="{{ route('cranes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Primer Equipo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Pagination Styles */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.pagination-info {
    display: flex;
    align-items: center;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 500;
}

.pagination-info i {
    color: #007bff;
    margin-right: 0.5rem;
}

.pagination-nav .pagination {
    margin: 0;
    gap: 0.25rem;
}

.pagination-nav .page-item .page-link {
    border: 1px solid #dee2e6;
    color: #495057;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    background: white;
}

.pagination-nav .page-item .page-link:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.pagination-nav .page-item.active .page-link {
    background: #007bff;
    border-color: #007bff;
    color: white;
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.pagination-nav .page-item.disabled .page-link {
    color: #6c757d;
    background: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination-nav .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination-info {
        justify-content: center;
    }
    
    .pagination-nav .page-item .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit form when filters change
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const selects = form.querySelectorAll('select');
        
        selects.forEach(select => {
            select.addEventListener('change', function() {
                form.submit();
            });
        });
        
        // Search input with debounce
        const searchInput = document.getElementById('search');
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                form.submit();
            }, 500);
        });
    });
</script>
@endpush