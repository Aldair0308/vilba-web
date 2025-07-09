@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Gestión de Clientes</h1>
                    <p class="mb-0 text-muted">Administra todos los clientes del sistema</p>
                </div>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Cliente
                </a>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('clients.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nombre, email, RFC o teléfono...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">Ordenar por</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="createdAt" {{ request('sort_by') === 'createdAt' ? 'selected' : '' }}>Fecha creación</option>
                                <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nombre</option>
                                <option value="email" {{ request('sort_by') === 'email' ? 'selected' : '' }}>Email</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_order" class="form-label">Orden</label>
                            <select class="form-select" id="sort_order" name="sort_order">
                                <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Descendente</option>
                                <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                            </select>
                        </div>
                        <div class="col-md-2">
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

            <!-- Tabla de clientes -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Clientes ({{ $clients->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($clients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>RFC</th>
                                        <th>Estado</th>
                                        <th>Rentas</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-primary text-white rounded-circle">
                                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $client->name }}</h6>
                                                        <small class="text-muted">{{ Str::limit($client->address, 30) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->formatted_phone }}</td>
                                            <td><code>{{ $client->formatted_rfc }}</code></td>
                                            <td>
                                                @if($client->status === 'active')
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $client->rent_count }}</span>
                                            </td>
                                            <td>{{ $client->createdAt->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('clients.show', $client->id) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('clients.edit', $client->id) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($client->status === 'active')
                                                        <form method="POST" action="{{ route('clients.deactivate', $client->id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" 
                                                                    title="Desactivar" 
                                                                    onclick="return confirm('¿Está seguro de desactivar este cliente?')">
                                                                <i class="fas fa-pause"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('clients.activate', $client->id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-success" 
                                                                    title="Activar">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(empty($client->rentHistory) || count($client->rentHistory) === 0)
                                                        <form method="POST" action="{{ route('clients.destroy', $client->id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    title="Eliminar" 
                                                                    onclick="return confirm('¿Está seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
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
                                <span>Mostrando <strong>{{ $clients->firstItem() }}</strong> a <strong>{{ $clients->lastItem() }}</strong> de <strong>{{ $clients->total() }}</strong> resultados</span>
                            </div>
                            <div class="pagination-nav">
                                {{ $clients->appends(request()->query())->links('custom.pagination') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron clientes</h5>
                            <p class="text-muted">No hay clientes que coincidan con los criterios de búsqueda.</p>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear primer cliente
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
</style>
@endsection

@push('scripts')
<script>
// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const selects = form.querySelectorAll('select');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            form.submit();
        });
    });
});
</script>
@endpush