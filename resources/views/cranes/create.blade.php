@extends('layouts.app')

@section('title', 'Nueva Grúa')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('cranes.index') }}">Grúas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nueva Grúa</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Crear Nueva Grúa</h1>
                <p class="mb-0 text-muted">Ingrese la información de la nueva grúa</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-truck-moving me-2"></i>Información de la Grúa
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cranes.store') }}" id="craneForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre de la Grúa <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       required 
                                       maxlength="255"
                                       placeholder="Ej: Grúa Principal Norte">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Marca -->
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">
                                    Marca <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('marca') is-invalid @enderror" 
                                       id="marca" 
                                       name="marca" 
                                       value="{{ old('marca') }}" 
                                       required
                                       maxlength="100"
                                       placeholder="Ej: Liebherr, Manitowoc, Caterpillar">
                                @error('marca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Modelo -->
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">
                                    Modelo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('modelo') is-invalid @enderror" 
                                       id="modelo" 
                                       name="modelo" 
                                       value="{{ old('modelo') }}" 
                                       required 
                                       maxlength="100"
                                       placeholder="Ej: LTM1200, MLC300, CT660">
                                @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capacidad -->
                            <div class="col-md-6 mb-3">
                                <label for="capacidad" class="form-label">
                                    Capacidad (toneladas) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('capacidad') is-invalid @enderror" 
                                       id="capacidad" 
                                       name="capacidad" 
                                       value="{{ old('capacidad') }}" 
                                       required 
                                       min="1"
                                       max="10000"
                                       placeholder="Ej: 200">
                                @error('capacidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Capacidad máxima de carga en toneladas
                                </div>
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">
                                    Tipo de Grúa <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="torre" {{ old('tipo') === 'torre' ? 'selected' : '' }}>Torre</option>
                                    <option value="móvil" {{ old('tipo') === 'móvil' ? 'selected' : '' }}>Móvil</option>
                                    <option value="oruga" {{ old('tipo') === 'oruga' ? 'selected' : '' }}>Oruga</option>
                                    <option value="camión" {{ old('tipo') === 'camión' ? 'selected' : '' }}>Camión</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    Estado
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado">
                                    <option value="activo" {{ old('estado', 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div class="col-12 mb-4">
                                <label for="category" class="form-label">
                                    Categoría
                                </label>
                                <input type="text" 
                                       class="form-control @error('category') is-invalid @enderror" 
                                       id="category" 
                                       name="category" 
                                       value="{{ old('category') }}" 
                                       maxlength="100"
                                       placeholder="Ej: Construcción, Industrial, Minería">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Categoría o sector de uso de la grúa (opcional)
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Precios por Zona -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-secondary">
                                    <i class="fas fa-dollar-sign me-2"></i>Precios por Zona
                                </h6>
                                <small class="text-muted">Configure los precios de alquiler por zona geográfica (opcional)</small>
                            </div>
                            <div class="card-body">
                                <div id="pricing-container">
                                    <!-- Los precios se agregarán dinámicamente aquí -->
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-pricing">
                                    <i class="fas fa-plus me-2"></i>Agregar Zona de Precios
                                </button>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('cranes.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Crear Grúa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let pricingIndex = 0;
    const pricingContainer = document.getElementById('pricing-container');
    const addPricingBtn = document.getElementById('add-pricing');

    // Función para crear una nueva sección de precios
    function createPricingSection(index, zona = '', precios = ['', '', '']) {
        const div = document.createElement('div');
        div.className = 'pricing-section border rounded p-3 mb-3';
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Zona ${index + 1}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-pricing">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre de la Zona</label>
                    <input type="text" 
                           class="form-control" 
                           name="precios[${index}][zona]" 
                           value="${zona}"
                           placeholder="Ej: Norte, Sur, Centro">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Precio Básico</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control" 
                               name="precios[${index}][precio][0]" 
                               value="${precios[0]}"
                               min="0" 
                               step="0.01"
                               placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Precio Estándar</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control" 
                               name="precios[${index}][precio][1]" 
                               value="${precios[1]}"
                               min="0" 
                               step="0.01"
                               placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Precio Premium</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control" 
                               name="precios[${index}][precio][2]" 
                               value="${precios[2]}"
                               min="0" 
                               step="0.01"
                               placeholder="0.00">
                    </div>
                </div>
            </div>
        `;
        return div;
    }

    // Agregar nueva sección de precios
    addPricingBtn.addEventListener('click', function() {
        const section = createPricingSection(pricingIndex);
        pricingContainer.appendChild(section);
        pricingIndex++;
    });

    // Eliminar sección de precios
    pricingContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-pricing')) {
            e.target.closest('.pricing-section').remove();
        }
    });

    // Restaurar datos antiguos si hay errores de validación
    @if(old('precios'))
        const oldPricing = @json(old('precios'));
        oldPricing.forEach((pricing, index) => {
            const section = createPricingSection(index, pricing.zona, pricing.precio || ['', '', '']);
            pricingContainer.appendChild(section);
            pricingIndex++;
        });
    @endif

    // Validación del formulario
    document.getElementById('craneForm').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const marca = document.getElementById('marca').value.trim();
        const modelo = document.getElementById('modelo').value.trim();
        const capacidad = document.getElementById('capacidad').value;
        const tipo = document.getElementById('tipo').value;

        if (!nombre || !marca || !modelo || !capacidad || !tipo) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
            return false;
        }

        if (capacidad <= 0) {
            e.preventDefault();
            alert('La capacidad debe ser mayor a 0.');
            return false;
        }
    });

    // Auto-generar nombre basado en marca y modelo
    const marcaInput = document.getElementById('marca');
    const modeloInput = document.getElementById('modelo');
    const nombreInput = document.getElementById('nombre');

    function updateNombre() {
        if (marcaInput.value && modeloInput.value && !nombreInput.value) {
            nombreInput.value = `${marcaInput.value} ${modeloInput.value}`;
        }
    }

    marcaInput.addEventListener('blur', updateNombre);
    modeloInput.addEventListener('blur', updateNombre);
});
</script>
@endpush