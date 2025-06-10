@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detalles del Usuario</h1>
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Información principal -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información del Usuario</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nombre:</label>
                                        <p class="form-control-plaintext">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email:</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Rol:</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge badge-{{ $user->rol === 'admin' ? 'success' : 'primary' }} badge-lg">
                                                {{ ucfirst($user->rol) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Estado de Email:</label>
                                        <p class="form-control-plaintext">
                                            @if($user->email_verified_at)
                                                <span class="badge badge-success">Verificado</span>
                                                <small class="text-muted d-block">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge badge-warning">No verificado</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Fecha de Registro:</label>
                                        <p class="form-control-plaintext">{{ $user->createdAt ? $user->createdAt->format('d/m/Y H:i') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Última Actualización:</label>
                                        <p class="form-control-plaintext">{{ $user->updatedAt ? $user->updatedAt->format('d/m/Y H:i') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto del usuario -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Foto de Perfil</h6>
                        </div>
                        <div class="card-body text-center">
                            <img src="/images/{{ $user->photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="max-width: 200px; max-height: 200px;"
                                 onerror="this.src='/images/photo_user.jpg'">
                            <h5 class="card-title">{{ $user->display_name }}</h5>
                            <p class="card-text text-muted">{{ $user->email }}</p>
                            @if($user->is_admin)
                                <span class="badge badge-success">Administrador</span>
                            @else
                                <span class="badge badge-primary">Usuario</span>
                            @endif
                        </div>
                    </div>

                    <!-- Estadísticas del usuario -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estadísticas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <div class="border-bottom pb-2">
                                        <h4 class="text-primary mb-0">{{ $user->id }}</h4>
                                        <small class="text-muted">ID de Usuario</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-right">
                                        <h5 class="text-success mb-0">{{ $user->createdAt ? $user->createdAt->diffForHumans() : 'N/A' }}</h5>
                                        <small class="text-muted">Registrado</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-info mb-0">{{ $user->updatedAt ? $user->updatedAt->diffForHumans() : 'N/A' }}</h5>
                                    <small class="text-muted">Actualizado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información del Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>ID del Usuario:</strong><br>
                                    <code>{{ $user->id }}</code>
                                </div>
                                <div class="col-md-4">
                                    <strong>Fecha de Creación:</strong><br>
                                    {{ $user->createdAt ? $user->createdAt->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Última Modificación:</strong><br>
                                    {{ $user->updatedAt ? $user->updatedAt->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
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
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush