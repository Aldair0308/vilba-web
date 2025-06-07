@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo Cliente</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Crear Nuevo Cliente</h1>
                <p class="mb-0 text-muted">Ingrese la información del nuevo cliente</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-plus me-2"></i>Información del Cliente
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.store') }}" id="clientForm">
                        @csrf
                        
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
                                       value="{{ old('name') }}" 
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
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="Ej: juan.perez@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('phone') }}" 
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
                                       value="{{ old('rfc') }}" 
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
                                          placeholder="Ej: Calle Reforma 123, Col. Centro, Ciudad de México, CDMX, CP 06000">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Dirección completa incluyendo código postal
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado Inicial</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status">
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Por defecto se crea como activo
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Crear Cliente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Información Importante
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Campos Obligatorios</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Nombre completo</li>
                                <li><i class="fas fa-check text-success me-2"></i>Email único</li>
                                <li><i class="fas fa-check text-success me-2"></i>Teléfono</li>
                                <li><i class="fas fa-check text-success me-2"></i>RFC único</li>
                                <li><i class="fas fa-check text-success me-2"></i>Dirección completa</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Validaciones</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-shield-alt text-warning me-2"></i>Email debe ser único</li>
                                <li><i class="fas fa-shield-alt text-warning me-2"></i>RFC debe ser único</li>
                                <li><i class="fas fa-shield-alt text-warning me-2"></i>RFC se convierte a mayúsculas</li>
                                <li><i class="fas fa-shield-alt text-warning me-2"></i>Límites de caracteres aplicados</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clientForm');
    const submitBtn = document.getElementById('submitBtn');
    const rfcInput = document.getElementById('rfc');
    
    // Auto-uppercase RFC
    rfcInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';
        
        // Re-enable button after 3 seconds in case of error
        setTimeout(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Crear Cliente';
        }, 3000);
    });
    
    // Real-time validation feedback
    const inputs = form.querySelectorAll('input, textarea, select');
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
});
</script>
@endpush