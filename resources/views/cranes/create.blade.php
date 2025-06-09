@extends('layouts.app')

@section('title', 'Nuevo Equipo')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('cranes.index') }}">Equipos</a></li>
<li class="breadcrumb-item active" aria-current="page">Nuevo Equipo</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Crear Nuevo Equipo</h1>
<p class="mb-0 text-muted">Ingrese la información del nuevo equipo</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-truck-moving me-2"></i>Información del Equipo
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cranes.store') }}" id="craneForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre del Equipo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       required 
                                       maxlength="255"
                                       placeholder="Ej: Equipo Principal Norte">
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
                                    Tipo de Equipo <span class="text-danger">*</span>
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
                            <option value="en_renta" {{ old('estado') === 'en_renta' ? 'selected' : '' }}>En Renta</option>
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
                                    Categoría o sector de uso del equipo (opcional)
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
                                        <i class="fas fa-save me-2"></i>Crear Equipo
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
    console.log('🚀 DOM cargado - Iniciando script de precios');
    
    let pricingIndex = 0;
    const pricingContainer = document.getElementById('pricing-container');
    const addPricingBtn = document.getElementById('add-pricing');
    
    console.log('📍 Elementos encontrados:', {
        pricingContainer: !!pricingContainer,
        addPricingBtn: !!addPricingBtn
    });
    
    if (!pricingContainer || !addPricingBtn) {
        console.error('❌ Error: No se encontraron los elementos necesarios');
        return;
    }

    // Función para crear una nueva sección de precios
    function createPricingSection(index, zona = '', precios = ['', '', ''], zonaCustom = '') {
        const div = document.createElement('div');
        div.className = 'pricing-section border rounded p-3 mb-3';
        
        // Determine if it's a custom zone
        const isCustomZone = zona && !['basica', 'estandar', 'premium'].includes(zona);
        const selectedZona = isCustomZone ? 'custom' : zona;
        const customZonaValue = isCustomZone ? zona : zonaCustom;
        
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Zona ${index + 1}</h6>
                <div>
                    <button type="button" class="btn btn-outline-primary btn-sm me-2 duplicate-pricing" title="Duplicar zona">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-pricing" title="Eliminar zona">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Zona <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-select zona-select" name="precios[${index}][zona]" required>
                            <option value="">Seleccione zona</option>
                            <option value="basica" ${selectedZona === 'basica' ? 'selected' : ''}>Básica</option>
                            <option value="estandar" ${selectedZona === 'estandar' ? 'selected' : ''}>Estándar</option>
                            <option value="premium" ${selectedZona === 'premium' ? 'selected' : ''}>Premium</option>
                            <option value="custom" ${selectedZona === 'custom' ? 'selected' : ''}>Personalizada</option>
                        </select>
                        <button type="button" class="btn btn-outline-secondary edit-zona-btn" title="Editar zona">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control mt-2 custom-zona-input" name="precios[${index}][zona_custom]" 
                           value="${customZonaValue}" 
                           placeholder="Nombre de zona personalizada" 
                           style="${selectedZona === 'custom' ? 'display: block;' : 'display: none;'}" 
                           ${selectedZona === 'custom' ? 'required' : ''}>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Precio Básico <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control" 
                               name="precios[${index}][precio][0]" 
                               value="${precios[0]}"
                               min="0" 
                               step="0.01"
                               placeholder="0.00"
                               required>
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
    console.log('🔧 Configurando event listener para botón add-pricing');
    
    addPricingBtn.addEventListener('click', function(e) {
        console.log('🖱️ CLICK detectado en botón add-pricing');
        console.log('📊 Estado actual - pricingIndex:', pricingIndex);
        
        try {
            console.log('⚙️ Creando nueva sección de precios...');
            const section = createPricingSection(pricingIndex);
            console.log('✅ Sección creada exitosamente:', section);
            
            console.log('📝 Agregando sección al contenedor...');
            pricingContainer.appendChild(section);
            console.log('✅ Sección agregada al DOM');
            
            pricingIndex++;
            console.log('📈 Índice actualizado a:', pricingIndex);
            console.log('🎉 Nueva zona de precio agregada exitosamente!');
        } catch (error) {
            console.error('💥 ERROR al crear la sección de precios:', error);
            console.error('📋 Stack trace:', error.stack);
        }
    });
    
    console.log('✅ Event listener configurado correctamente');

    // Handle pricing actions
    pricingContainer.addEventListener('click', function(e) {
        // Remove pricing
        if (e.target.closest('.remove-pricing')) {
            if (confirm('¿Está seguro de eliminar esta zona de precio?')) {
                e.target.closest('.pricing-section').remove();
                updatePricingIndexes();
            }
        }
        
        // Duplicate pricing
        if (e.target.closest('.duplicate-pricing')) {
            const pricingSection = e.target.closest('.pricing-section');
            const zonaSelect = pricingSection.querySelector('.zona-select');
            const customInput = pricingSection.querySelector('.custom-zona-input');
            const priceInputs = pricingSection.querySelectorAll('input[type="number"]');
            
            const zona = zonaSelect.value === 'custom' ? customInput.value : zonaSelect.value;
            const precios = Array.from(priceInputs).map(input => input.value);
            
            const newSection = createPricingSection(pricingIndex, zona, precios);
            pricingSection.parentNode.insertBefore(newSection, pricingSection.nextSibling);
            pricingIndex++;
        }
        
        // Edit zona button
        if (e.target.closest('.edit-zona-btn')) {
            const pricingSection = e.target.closest('.pricing-section');
            const zonaSelect = pricingSection.querySelector('.zona-select');
            const customInput = pricingSection.querySelector('.custom-zona-input');
            
            if (zonaSelect.value === 'custom') {
                const newName = prompt('Ingrese el nombre de la zona:', customInput.value);
                if (newName && newName.trim()) {
                    customInput.value = newName.trim();
                }
            } else {
                const newName = prompt('Ingrese el nombre de la nueva zona:', '');
                if (newName && newName.trim()) {
                    zonaSelect.value = 'custom';
                    customInput.value = newName.trim();
                    customInput.style.display = 'block';
                    customInput.required = true;
                }
            }
        }
    });
    
    // Handle zona select changes
    pricingContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('zona-select')) {
            const customInput = e.target.closest('.pricing-section').querySelector('.custom-zona-input');
            if (e.target.value === 'custom') {
                customInput.style.display = 'block';
                customInput.required = true;
            } else {
                customInput.style.display = 'none';
                customInput.required = false;
                customInput.value = '';
            }
        }
    });
    
    // Update pricing indexes
    function updatePricingIndexes() {
        const pricingSections = pricingContainer.querySelectorAll('.pricing-section');
        pricingSections.forEach((section, index) => {
            section.querySelector('h6').innerHTML = `Zona ${index + 1}`;
            
            // Update form names
            section.querySelectorAll('[name]').forEach(input => {
                const oldName = input.getAttribute('name');
                const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', newName);
            });
        });
        pricingIndex = pricingSections.length;
    }

    // Restaurar datos antiguos si hay errores de validación
    @if(old('precios'))
        const oldPricing = @json(old('precios'));
        oldPricing.forEach((pricing, index) => {
            const section = createPricingSection(index, pricing.zona, pricing.precio || ['', '', ''], pricing.zona_custom || '');
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