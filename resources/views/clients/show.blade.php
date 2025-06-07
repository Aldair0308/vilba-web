@extends('layouts.app')

@section('title', 'Cliente: ' . $client->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $client->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 text-gray-800">{{ $client->name }}</h1>
                    <p class="mb-0 text-muted">Información detallada del cliente</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    @if($client->status === 'active')
                        <form method="POST" action="{{ route('clients.deactivate', $client->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary" 
                                    onclick="return confirm('¿Está seguro de desactivar este cliente?')">
                                <i class="fas fa-pause me-2"></i>Desactivar
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('clients.activate', $client->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-play me-2"></i>Activar
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Información del Cliente -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user me-2"></i>Información Personal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre Completo</label>
                                    <p class="h5 mb-0">{{ $client->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Estado</label>
                                    <div>
                                        @if($client->status === 'active')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-check-circle me-1"></i>Activo
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">
                                                <i class="fas fa-pause-circle me-1"></i>Inactivo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="mb-0">
                                        <a href="mailto:{{ $client->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-2"></i>{{ $client->email }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Teléfono</label>
                                    <p class="mb-0">
                                        <a href="tel:{{ $client->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-2"></i>{{ $client->formatted_phone }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">RFC</label>
                                    <p class="mb-0">
                                        <code class="fs-6">{{ $client->formatted_rfc }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha de Registro</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $client->createdAt->format('d/m/Y H:i') }}
                                        <small class="text-muted">({{ $client->createdAt->diffForHumans() }})</small>
                                    </p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Dirección</label>
                                    <p class="mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i>{{ $client->address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Rentas -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history me-2"></i>Historial de Rentas
                                <span class="badge bg-info ms-2">{{ $client->rent_count }}</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($client->rent_count > 0)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Este cliente tiene <strong>{{ $client->rent_count }}</strong> renta(s) en su historial.
                                    <br><small>El historial detallado se mostrará cuando se implemente el módulo de rentas.</small>
                                </div>
                                
                                <!-- Placeholder para futuro historial detallado -->
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID Renta</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($client->rentHistory as $index => $rentId)
                                                <tr>
                                                    <td><code>{{ $rentId }}</code></td>
                                                    <td><span class="text-muted">Pendiente de implementar</span></td>
                                                    <td><span class="badge bg-warning">Por definir</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Sin historial de rentas</h5>
                                    <p class="text-muted">Este cliente aún no tiene rentas registradas.</p>
                                    <button class="btn btn-primary" disabled>
                                        <i class="fas fa-plus me-2"></i>Crear nueva renta
                                        <small class="d-block">(Disponible próximamente)</small>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel lateral -->
                <div class="col-lg-4">
                    <!-- Estadísticas rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-0">{{ $client->rent_count }}</h4>
                                        <small class="text-muted">Rentas</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <h4 class="text-success mb-0">{{ $client->createdAt->diffInDays() }}</h4>
                                    <small class="text-muted">Días registrado</small>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Última actualización: {{ $client->updatedAt->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="mailto:{{ $client->email }}" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope me-2"></i>Enviar Email
                                </a>
                                <a href="tel:{{ $client->phone }}" class="btn btn-outline-success">
                                    <i class="fas fa-phone me-2"></i>Llamar
                                </a>
                                <button class="btn btn-outline-info" disabled>
                                    <i class="fas fa-file-contract me-2"></i>Nueva Renta
                                    <small class="d-block">(Próximamente)</small>
                                </button>
                                <hr>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Editar Cliente
                                </a>
                                @if(empty($client->rentHistory) || count($client->rentHistory) === 0)
                                    <form method="POST" action="{{ route('clients.destroy', $client->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100" 
                                                onclick="return confirm('¿Está seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                                            <i class="fas fa-trash me-2"></i>Eliminar Cliente
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información del sistema -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Información del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <strong>ID:</strong> {{ $client->id }}<br>
                                <strong>Creado:</strong> {{ $client->createdAt->format('d/m/Y H:i:s') }}<br>
                                <strong>Actualizado:</strong> {{ $client->updatedAt->format('d/m/Y H:i:s') }}<br>
                                <strong>Colección:</strong> clients
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge.fs-6 {
    font-size: 0.875rem !important;
}

.border-end {
    border-right: 1px solid #e3e6f0 !important;
}

.card-header h6 {
    color: #5a5c69;
}

.btn:disabled {
    opacity: 0.6;
}

.btn:disabled small {
    font-size: 0.7rem;
    font-weight: normal;
}
</style>
@endsection