@extends('layouts.app')

@section('title', 'Gestión de Archivos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Gestión de Archivos</h1>
                    <p class="mb-0 text-muted">Administra todos los archivos del sistema</p>
                </div>
                <a href="{{ route('files.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Archivo
                </a>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('files.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nombre del archivo...">
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Todos</option>
                                <option value="pdf" {{ request('type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="excel" {{ request('type') === 'excel' ? 'selected' : '' }}>Excel</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="department" class="form-label">Departamento</label>
                            <select class="form-select" id="department" name="department">
                                <option value="">Todos</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">Ordenar por</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="createdAt" {{ request('sort_by') === 'createdAt' ? 'selected' : '' }}>Fecha creación</option>
                                <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nombre</option>
                                <option value="type" {{ request('sort_by') === 'type' ? 'selected' : '' }}>Tipo</option>
                                <option value="department" {{ request('sort_by') === 'department' ? 'selected' : '' }}>Departamento</option>
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

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Archivos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        Archivos PDF</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pdf'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
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
                                        Archivos Excel</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['excel'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
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
                                        Tamaño Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['formatted_total_size'] ?? '0 B' }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hdd fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de archivos -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Archivos ({{ $files->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($files->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Tipo</th>
                                        <th>Departamento</th>
                                        <th>Responsable</th>
                                        <th>Tamaño</th>
                                        <th>Fecha Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="file-icon me-3">
                                                        @if($file->type === 'pdf')
                                                            <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                                        @elseif($file->type === 'excel')
                                                            <i class="fas fa-file-excel fa-2x text-success"></i>
                                                        @else
                                                            <i class="fas fa-file fa-2x text-secondary"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $file->name }}</h6>
                                                        <small class="text-muted">{{ $file->file_extension }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($file->type === 'pdf')
                                                    <span class="badge bg-danger">PDF</span>
                                                @elseif($file->type === 'excel')
                                                    <span class="badge bg-success">Excel</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ strtoupper($file->type) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $file->department }}</td>
                                            <td>{{ $file->responsible_id }}</td>
                                            <td>{{ $file->formatted_file_size }}</td>
                                            <td>{{ $file->createdAt->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('files.show', $file->id) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($file->type === 'pdf')
                                                        <a href="{{ route('files.preview', $file->id) }}" target="_blank" 
                                                           class="btn btn-sm btn-outline-secondary" title="Vista previa">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('files.download', $file->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('files.edit', $file->id) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('files.destroy', $file->id) }}" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                title="Eliminar" 
                                                                onclick="return confirm('¿Está seguro de eliminar este archivo? Esta acción no se puede deshacer.')">
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
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted mb-0">
                                    Mostrando {{ $files->firstItem() }} a {{ $files->lastItem() }} 
                                    de {{ $files->total() }} resultados
                                </p>
                            </div>
                            <div>
                                {{ $files->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron archivos</h5>
                            <p class="text-muted">No hay archivos que coincidan con los criterios de búsqueda.</p>
                            <a href="{{ route('files.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Subir primer archivo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.file-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
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

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
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