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
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                                        <span>Nuevo Cliente</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="{{ route('cranes.create') }}" class="btn btn-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                        <span>Nuevo Equipo</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="{{ route('quotes.create') }}" class="btn btn-info btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                                        <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                                        <span>Nueva Cotización</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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
});
</script>
@endpush