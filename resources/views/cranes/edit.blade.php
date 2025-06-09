@extends('layouts.app')

@section('title', 'Editar Equipo: ' . $crane->nombre)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('cranes.index') }}">Equipos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cranes.show', $crane->id) }}">{{ $crane->nombre }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Editar Equipo</h1>
                    <p class="mb-0 text-muted">Modifique la información del equipo</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-truck-moving me-2"></i>Información del Equipo
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cranes.update', $crane->id) }}" id="craneForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Marca -->
                            <div class="col-md-4 mb-3">
                                <label for="marca" class="form-label">
                                    Marca <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('marca') is-invalid @enderror" 
                                        id="marca" 
                                        name="marca" 
                                        required>
                                    <option value="">Seleccione una marca</option>
                                    <option value="Caterpillar" {{ old('marca', $crane->marca) === 'Caterpillar' ? 'selected' : '' }}>Caterpillar</option>
                                    <option value="Liebherr" {{ old('marca', $crane->marca) === 'Liebherr' ? 'selected' : '' }}>Liebherr</option>
                                    <option value="Tadano" {{ old('marca', $crane->marca) === 'Tadano' ? 'selected' : '' }}>Tadano</option>
                                    <option value="Grove" {{ old('marca', $crane->marca) === 'Grove' ? 'selected' : '' }}>Grove</option>
                                    <option value="Terex" {{ old('marca', $crane->marca) === 'Terex' ? 'selected' : '' }}>Terex</option>
                                    <option value="Manitowoc" {{ old('marca', $crane->marca) === 'Manitowoc' ? 'selected' : '' }}>Manitowoc</option>
                                    <option value="Komatsu" {{ old('marca', $crane->marca) === 'Komatsu' ? 'selected' : '' }}>Komatsu</option>
                                    <option value="Kobelco" {{ old('marca', $crane->marca) === 'Kobelco' ? 'selected' : '' }}>Kobelco</option>
                                    <option value="Otro" {{ old('marca', $crane->marca) === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('marca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Modelo -->
                            <div class="col-md-4 mb-3">
                                <label for="modelo" class="form-label">
                                    Modelo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('modelo') is-invalid @enderror" 
                                       id="modelo" 
                                       name="modelo" 
                                       value="{{ old('modelo', $crane->modelo) }}" 
                                       required 
                                       maxlength="100"
                                       placeholder="Ej: RT540E">
                                @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nombre (Auto-generado) -->
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre', $crane->nombre) }}" 
                                       required 
                                       maxlength="150"
                                       placeholder="Se genera automáticamente">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Se genera automáticamente basado en marca y modelo
                                </div>
                            </div>

                            <!-- Capacidad -->
                            <div class="col-md-4 mb-3">
                                <label for="capacidad" class="form-label">
                                    Capacidad (toneladas) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('capacidad') is-invalid @enderror" 
                                       id="capacidad" 
                                       name="capacidad" 
                                       value="{{ old('capacidad', $crane->capacidad) }}" 
                                       required 
                                       min="1" 
                                       max="1000" 
                                       step="0.1"
                                       placeholder="Ej: 25">
                                @error('capacidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Capacidad máxima de carga en toneladas
                                </div>
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-4 mb-3">
                                <label for="tipo" class="form-label">
                                    Tipo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="movil" {{ old('tipo', $crane->tipo) === 'movil' ? 'selected' : '' }}>Móvil</option>
                                    <option value="torre" {{ old('tipo', $crane->tipo) === 'torre' ? 'selected' : '' }}>Torre</option>
                                    <option value="telescopica" {{ old('tipo', $crane->tipo) === 'telescopica' ? 'selected' : '' }}>Telescópica</option>
                                    <option value="todo_terreno" {{ old('tipo', $crane->tipo) === 'todo_terreno' ? 'selected' : '' }}>Todo Terreno</option>
                                    <option value="oruga" {{ old('tipo', $crane->tipo) === 'oruga' ? 'selected' : '' }}>Oruga</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado">
                                    <option value="activo" {{ old('estado', $crane->estado) === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $crane->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="mantenimiento" {{ old('estado', $crane->estado) === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="en_renta" {{ old('estado', $crane->estado) === 'en_renta' ? 'selected' : '' }}>En Renta</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($crane->estado !== old('estado', $crane->estado))
                                    <div class="form-text text-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cambio de estado detectado
                                    </div>
                                @endif
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-12 mb-3">
                                <label for="category" class="form-label">Categoría</label>
                                <input type="text" 
                                       class="form-control @error('category') is-invalid @enderror" 
                                       id="category" 
                                       name="category" 
                                       value="{{ old('category', $crane->category) }}" 
                                       maxlength="100"
                                       placeholder="Ej: Construcción, Industrial, Especial">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Categoría o clasificación especial del equipo (opcional)
                                </div>
                            </div>
                        </div>

                        <!-- Precios por Zona -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <h5 class="mb-3">
                                    <i class="fas fa-dollar-sign me-2"></i>Precios por Zona
                                </h5>
                                <div id="precios-container">
                                    @if(old('precios') || (!empty($crane->precios) && count($crane->precios) > 0))
                                        @php
                                            $precios = old('precios', $crane->precios ?? []);
                                        @endphp
                                        @foreach($precios as $index => $precio)
                                            <div class="precio-item border rounded p-3 mb-3" data-index="{{ $index }}">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">
                                                        <i class="fas fa-map-marker-alt me-2"></i>Zona {{ $index + 1 }}
                                                    </h6>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-precio">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                        <label class="form-label">Zona <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select zona-select" name="precios[{{ $index }}][zona]" required>
                                <option value="">Seleccione zona</option>
                                <option value="basica" {{ (isset($precio['zona']) && $precio['zona'] === 'basica') ? 'selected' : '' }}>Básica</option>
                                <option value="estandar" {{ (isset($precio['zona']) && $precio['zona'] === 'estandar') ? 'selected' : '' }}>Estándar</option>
                                <option value="premium" {{ (isset($precio['zona']) && $precio['zona'] === 'premium') ? 'selected' : '' }}>Premium</option>
                                <option value="custom" {{ (isset($precio['zona']) && !in_array($precio['zona'], ['basica', 'estandar', 'premium'])) ? 'selected' : '' }}>Personalizada</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary edit-zona-btn" title="Editar zona">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2 custom-zona-input" name="precios[{{ $index }}][zona_custom]" 
                               value="{{ (isset($precio['zona']) && !in_array($precio['zona'], ['basica', 'estandar', 'premium'])) ? $precio['zona'] : '' }}" 
                               placeholder="Nombre de zona personalizada" 
                               style="{{ (isset($precio['zona']) && !in_array($precio['zona'], ['basica', 'estandar', 'premium'])) ? 'display: block;' : 'display: none;' }}">
                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Precio Básico <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="precios[{{ $index }}][precio][0]" 
                                                                   value="{{ isset($precio['precio'][0]) ? $precio['precio'][0] : '' }}" 
                                                                   min="0" 
                                                                   step="0.01" 
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Precio Estándar</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="precios[{{ $index }}][precio][1]" 
                                                                   value="{{ isset($precio['precio'][1]) ? $precio['precio'][1] : '' }}" 
                                                                   min="0" 
                                                                   step="0.01">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Precio Premium</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="precios[{{ $index }}][precio][2]" 
                                                                   value="{{ isset($precio['precio'][2]) ? $precio['precio'][2] : '' }}" 
                                                                   min="0" 
                                                                   step="0.01">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary" id="add-precio">
                                    <i class="fas fa-plus me-2"></i>Agregar Zona de Precio
                                </button>
                            </div>
                        </div>

                        <!-- Información de auditoría -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle me-2"></i>Información de Auditoría
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Creado:</strong> {{ $crane->created_at ? $crane->created_at->format('d/m/Y H:i:s') : 'No disponible' }}
                                                @if($crane->created_at)
                                                    <br>({{ $crane->created_at->diffForHumans() }})
                                                @endif
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Última actualización:</strong> {{ $crane->updated_at ? $crane->updated_at->format('d/m/Y H:i:s') : 'No disponible' }}
                                                @if($crane->updated_at)
                                                    <br>({{ $crane->updated_at->diffForHumans() }})
                                                @endif
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
                                        <a href="{{ route('cranes.show', $crane->id) }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                                        </a>
                                        <a href="{{ route('cranes.index') }}" class="btn btn-outline-secondary ms-2">
                                            <i class="fas fa-list me-2"></i>Lista de Equipos
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-warning me-2" id="resetBtn">
                                            <i class="fas fa-undo me-2"></i>Restablecer
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>Actualizar Equipo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Acciones adicionales -->
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
                    <form method="POST" action="{{ route('cranes.destroy', $crane->id) }}" 
                          onsubmit="return confirm('¿Está COMPLETAMENTE seguro de eliminar este equipo?\n\nEsta acción NO se puede deshacer.\n\nEscriba ELIMINAR en el campo de confirmación para continuar.')">
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
                                    <i class="fas fa-trash me-2"></i>Eliminar Equipo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

.precio-item {
    background-color: #f8f9fc;
    border: 1px solid #e3e6f0 !important;
}

.precio-item:hover {
    border-color: #4e73df !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('craneForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const marcaSelect = document.getElementById('marca');
    const modeloInput = document.getElementById('modelo');
    const nombreInput = document.getElementById('nombre');
    const confirmDeleteInput = document.getElementById('confirmDelete');
    const deleteBtn = document.getElementById('deleteBtn');
    const preciosContainer = document.getElementById('precios-container');
    const addPrecioBtn = document.getElementById('add-precio');
    
    console.log('🚀 DOM cargado - Iniciando script de precios (EDIT)');
    console.log('📍 Elementos encontrados (EDIT):', {
        preciosContainer: !!preciosContainer,
        addPrecioBtn: !!addPrecioBtn
    });
    
    if (!preciosContainer || !addPrecioBtn) {
        console.error('❌ Error: No se encontraron los elementos necesarios (EDIT)');
    }
    
    let precioIndex = {{ count($crane->precios ?? []) }};
    console.log('📊 Índice inicial de precios (EDIT):', precioIndex);
    
    // Store original values
    const originalValues = {};
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        originalValues[input.name] = input.value;
    });
    
    // Auto-generate crane name
    function generateName() {
        const marca = marcaSelect.value;
        const modelo = modeloInput.value;
        if (marca && modelo) {
            nombreInput.value = `${marca} ${modelo}`;
        }
    }
    
    marcaSelect.addEventListener('change', generateName);
    modeloInput.addEventListener('input', generateName);
    
    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Está seguro de restablecer todos los cambios?')) {
            inputs.forEach(input => {
                input.value = originalValues[input.name] || '';
                input.classList.remove('is-valid', 'is-invalid');
            });
            // Reset precios
            location.reload();
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        
        // Re-enable button after 3 seconds in case of error
        setTimeout(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Equipo';
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
    
    // Precios management
    function createPrecioItem(index) {
        return `
            <div class="precio-item border rounded p-3 mb-3" data-index="${index}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Zona ${index + 1}
                    </h6>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2 duplicate-precio" title="Duplicar zona">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-precio" title="Eliminar zona">
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
                                <option value="basica">Básica</option>
                                <option value="estandar">Estándar</option>
                                <option value="premium">Premium</option>
                                <option value="custom">Personalizada</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary edit-zona-btn" title="Editar zona">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2 custom-zona-input" name="precios[${index}][zona_custom]" 
                               placeholder="Nombre de zona personalizada" style="display: none;">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio Básico <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="precios[${index}][precio][0]" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio Estándar</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="precios[${index}][precio][1]" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio Premium</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="precios[${index}][precio][2]" min="0" step="0.01">
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add precio
    console.log('🔧 Configurando event listener para botón add-precio (EDIT)');
    
    addPrecioBtn.addEventListener('click', function(e) {
        console.log('🖱️ CLICK detectado en botón add-precio (EDIT)');
        console.log('📊 Estado actual - precioIndex:', precioIndex);
        
        try {
            console.log('⚙️ Creando nuevo item de precio...');
            const newItemHTML = createPrecioItem(precioIndex);
            console.log('✅ HTML generado:', newItemHTML.substring(0, 100) + '...');
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newItemHTML;
            const newItem = tempDiv.firstElementChild;
            console.log('✅ Elemento DOM creado:', newItem);
            
            console.log('📝 Agregando item al contenedor...');
            preciosContainer.appendChild(newItem);
            console.log('✅ Item agregado al DOM');
            
            precioIndex++;
            console.log('📈 Índice actualizado a:', precioIndex);
            console.log('🎉 Nueva zona de precio agregada exitosamente! (EDIT)');
        } catch (error) {
            console.error('💥 ERROR al crear el item de precio (EDIT):', error);
            console.error('📋 Stack trace:', error.stack);
        }
    });
    
    console.log('✅ Event listener configurado correctamente (EDIT)');
    
    // Handle precio actions
    preciosContainer.addEventListener('click', function(e) {
        // Remove precio
        if (e.target.closest('.remove-precio')) {
            if (confirm('¿Está seguro de eliminar esta zona de precio?')) {
                e.target.closest('.precio-item').remove();
                updatePrecioIndexes();
            }
        }
        
        // Duplicate precio
        if (e.target.closest('.duplicate-precio')) {
            const precioItem = e.target.closest('.precio-item');
            const newItem = precioItem.cloneNode(true);
            
            // Update indexes and clear values
            const newIndex = precioIndex++;
            newItem.setAttribute('data-index', newIndex);
            newItem.querySelector('h6').innerHTML = `<i class="fas fa-map-marker-alt me-2"></i>Zona ${newIndex + 1}`;
            
            // Update form names
            newItem.querySelectorAll('[name]').forEach(input => {
                const oldName = input.getAttribute('name');
                const newName = oldName.replace(/\[\d+\]/, `[${newIndex}]`);
                input.setAttribute('name', newName);
                
                // Clear values except zona selection
                if (!input.classList.contains('zona-select')) {
                    input.value = '';
                }
            });
            
            precioItem.parentNode.insertBefore(newItem, precioItem.nextSibling);
        }
        
        // Edit zona button
        if (e.target.closest('.edit-zona-btn')) {
            const precioItem = e.target.closest('.precio-item');
            const zonaSelect = precioItem.querySelector('.zona-select');
            const customInput = precioItem.querySelector('.custom-zona-input');
            
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
                }
            }
        }
    });
    
    // Handle zona select changes
    preciosContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('zona-select')) {
            const customInput = e.target.closest('.precio-item').querySelector('.custom-zona-input');
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
    
    // Update precio indexes
    function updatePrecioIndexes() {
        const precioItems = preciosContainer.querySelectorAll('.precio-item');
        precioItems.forEach((item, index) => {
            item.setAttribute('data-index', index);
            item.querySelector('h6').innerHTML = `<i class="fas fa-map-marker-alt me-2"></i>Zona ${index + 1}`;
            
            // Update form names
            item.querySelectorAll('[name]').forEach(input => {
                const oldName = input.getAttribute('name');
                const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', newName);
            });
        });
        precioIndex = precioItems.length;
    }
    
    // Detect changes
    let hasChanges = false;
    form.addEventListener('input', function() {
        hasChanges = true;
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