@extends('layouts.app')

@section('title', 'Editar Cliente: ' . $client->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Editar Cliente</h1>
                <p class="mb-0 text-muted">Modifique la información del cliente</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit me-2"></i>Información del Cliente
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.update', $client->id) }}" id="clientForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $client->name) }}" 
                                       required 
                                       maxlength="255"
                                       placeholder="Ej: Juan Pérez García">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $client->email) }}" 
                                       required
                                       placeholder="Ej: juan.perez@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($client->email !== old('email', $client->email))
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Cambiar el email puede afectar las notificaciones
                                    </div>
                                @endif
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $client->phone) }}" 
                                       required 
                                       maxlength="20"
                                       placeholder="Ej: +52 55 1234 5678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Incluya código de país si es necesario
                                </div>
                            </div>

                            <!-- RFC -->
                            <div class="col-md-6 mb-3">
                                <label for="rfc" class="form-label">
                                    RFC <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('rfc') is-invalid @enderror" 
                                       id="rfc" 
                                       name="rfc" 
                                       value="{{ old('rfc', $client->rfc) }}" 
                                       required 
                                       maxlength="13"
                                       placeholder="Ej: XAXX010101000"
                                       style="text-transform: uppercase;">
                                @error('rfc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    RFC de 12 o 13 caracteres (se convertirá a mayúsculas)
                                </div>
                                @if($client->rfc !== old('rfc', $client->rfc))
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Cambiar el RFC puede tener implicaciones fiscales
                                    </div>
                                @endif
                            </div>

                            <!-- Dirección -->
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">
                                    Dirección <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3" 
                                          required 
                                          maxlength="500"
                                          placeholder="Ej: Calle Reforma 123, Col. Centro, Ciudad de México, CDMX, CP 06000">{{ old('address', $client->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Dirección completa incluyendo código postal
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status">
                                    <option value="active" {{ old('status', $client->status) === 'active' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="inactive" {{ old('status', $client->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($client->status !== old('status', $client->status))
                                    <div class="form-text text-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cambio de estado detectado
                                    </div>
                                @endif
                            </div>

                            <!-- Información de historial -->
                            @if($client->rent_count > 0)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Historial de Rentas</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-info fs-6">
                                            <i class="fas fa-history me-1"></i>
                                            {{ $client->rent_count }} renta(s)
                                        </span>
                                    </div>
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Cliente con historial de rentas - eliminar no disponible
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Información de auditoría -->
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle me-2"></i>Información de Auditoría
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Creado:</strong> {{ $client->createdAt->format('d/m/Y H:i:s') }}
                                                <br>({{ $client->createdAt->diffForHumans() }})
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Última actualización:</strong> {{ $client->updatedAt->format('d/m/Y H:i:s') }}
                                                <br>({{ $client->updatedAt->diffForHumans() }})
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                                        </a>
                                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary ms-2">
                                            <i class="fas fa-list me-2"></i>Lista de Clientes
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-warning me-2" id="resetBtn">
                                            <i class="fas fa-undo me-2"></i>Restablecer
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>Actualizar Cliente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Acciones adicionales -->
            @if($client->rent_count === 0)
                <div class="card shadow mt-4 border-danger">
                    <div class="card-header bg-danger text-white py-3">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>Zona de Peligro
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Las siguientes acciones son irreversibles. Proceda con precaución.
                        </p>
                        <form method="POST" action="{{ route('clients.destroy', $client->id) }}" 
                              onsubmit="return confirm('¿Está COMPLETAMENTE seguro de eliminar este cliente?\n\nEsta acción NO se puede deshacer.\n\nEscriba ELIMINAR en el campo de confirmación para continuar.')">
                            @csrf
                            @method('DELETE')
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <label for="confirmDelete" class="form-label">
                                        Para eliminar, escriba <strong>ELIMINAR</strong> en el campo:
                                    </label>
                                    <input type="text" class="form-control" id="confirmDelete" 
                                           placeholder="Escriba ELIMINAR para confirmar" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-danger w-100" id="deleteBtn" disabled>
                                        <i class="fas fa-trash me-2"></i>Eliminar Cliente
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.text-danger {
    font-weight: bold;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.card-header h6 {
    color: #5a5c69;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2e59d9;
}

.invalid-feedback {
    font-size: 0.875rem;
}

.form-text {
    font-size: 0.8rem;
}

.badge.fs-6 {
    font-size: 0.875rem !important;
}

.alert-light {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clientForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const rfcInput = document.getElementById('rfc');
    const confirmDeleteInput = document.getElementById('confirmDelete');
    const deleteBtn = document.getElementById('deleteBtn');
    
    // Store original values
    const originalValues = {};
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        originalValues[input.name] = input.value;
    });
    
    // Auto-uppercase RFC
    rfcInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Está seguro de restablecer todos los cambios?')) {
            inputs.forEach(input => {
                input.value = originalValues[input.name] || '';
                input.classList.remove('is-valid', 'is-invalid');
            });
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        
        // Re-enable button after 3 seconds in case of error
        setTimeout(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Cliente';
        }, 3000);
    });
    
    // Real-time validation feedback
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    });
    
    // Delete confirmation
    if (confirmDeleteInput && deleteBtn) {
        confirmDeleteInput.addEventListener('input', function() {
            deleteBtn.disabled = this.value !== 'ELIMINAR';
        });
    }
    
    // Detect changes
    let hasChanges = false;
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            hasChanges = true;
        });
    });
    
    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Don't warn when submitting
    form.addEventListener('submit', function() {
        hasChanges = false;
    });
});
</script>
@endpush