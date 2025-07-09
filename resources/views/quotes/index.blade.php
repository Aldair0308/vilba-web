@extends('layouts.app')

@section('title', 'Gestión de Cotizaciones')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header rounded mb-4">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">Gestión de Cotizaciones</h1>
                            <p class="mb-0 opacity-75">Administra todas las cotizaciones del sistema</p>
                        </div>
                        <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nueva Cotización
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('quotes.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nombre, zona o total...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="client_id" class="form-label">Cliente</label>
                            <select class="form-select" id="client_id" name="client_id">
                                <option value="">Todos</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->_id }}" {{ request('client_id') === $client->_id ? 'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">Ordenar por</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="createdAt" {{ request('sort_by') === 'createdAt' ? 'selected' : '' }}>Fecha creación</option>
                                <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nombre</option>
                                <option value="zone" {{ request('sort_by') === 'zone' ? 'selected' : '' }}>Zona</option>
                                <option value="total" {{ request('sort_by') === 'total' ? 'selected' : '' }}>Total</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="sort_order" class="form-label">Orden</label>
                            <select class="form-select" id="sort_order" name="sort_order">
                                <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Desc</option>
                                <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Asc</option>
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

            <!-- Tabla de cotizaciones -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Cotizaciones ({{ $quotes->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($quotes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cliente</th>
                                        <th>Zona</th>
                                        <th>Estado</th>
                                        <th>Grúas</th>
                                        <th>Total</th>
                                        <th>Responsable</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotes as $quote)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-info text-white rounded-circle">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $quote->name }}</h6>
                                                        <small class="text-muted">ID: {{ substr($quote->_id, -8) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($quote->client)
                                                    <span class="fw-bold">{{ $quote->client->name }}</span><br>
                                                    <small class="text-muted">{{ $quote->client->email }}</small>
                                                @else
                                                    <span class="text-muted">Cliente no encontrado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $quote->zone }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                        'active' => 'primary',
                                                        'completed' => 'info'
                                                    ];
                                                    $status = $quote->status ?? 'pending';
                                                    $color = (is_string($status) && isset($statusColors[$status])) ? $statusColors[$status] : 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">{{ (is_string($status) && isset($statuses[$status])) ? $statuses[$status] : $status }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ is_array($quote->cranes) ? count($quote->cranes) : 0 }} grúa(s)</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($quote->total, 2) }}</span>
                                                @if($quote->iva)
                                                    <br><small class="text-muted">IVA: {{ $quote->iva }}%</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($quote->responsible)
                                                    {{ $quote->responsible->name }}
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $quote->createdAt->format('d/m/Y') }}</span><br>
                                                <small class="text-muted">{{ $quote->createdAt->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('quotes.show', $quote->_id) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('quotes.edit', $quote->_id) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Eliminar"
                                                            onclick="confirmDelete('{{ $quote->_id }}', '{{ $quote->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                                <span>Mostrando <strong>{{ $quotes->firstItem() }}</strong> a <strong>{{ $quotes->lastItem() }}</strong> de <strong>{{ $quotes->total() }}</strong> resultados</span>
                            </div>
                            <div class="pagination-nav">
                                {{ $quotes->appends(request()->query())->links('custom.pagination') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-file-invoice fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No se encontraron cotizaciones</h5>
                            <p class="text-muted">No hay cotizaciones que coincidan con los criterios de búsqueda.</p>
                            <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Primera Cotización
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la cotización <strong id="quoteName"></strong>?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
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
function confirmDelete(quoteId, quoteName) {
    document.getElementById('quoteName').textContent = quoteName;
    document.getElementById('deleteForm').action = `/quotes/${quoteId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush