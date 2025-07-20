@extends('layouts.app')

@section('title', 'Crear Nueva Cotización')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header rounded mb-4">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">Crear Nueva Cotización</h1>
                            <p class="mb-0 opacity-75">Completa el formulario para crear una nueva cotización</p>
                        </div>
                        <a href="{{ route('quotes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulario de creación -->
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('quotes.store') }}" method="POST" id="quoteForm">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Información General</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nombre de la cotización -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre de la Cotización <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Zona -->
                                        <div class="mb-3">
                                            <label for="zone" class="form-label">Zona <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('zone') is-invalid @enderror" 
                                                id="zone" name="zone" value="{{ old('zone') }}" required>
                                            @error('zone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Ejemplo: Norte, Sur, Centro, etc.</small>
                                        </div>

                                        <!-- Cliente -->
                                        <div class="mb-3">
                                            <label for="clientId" class="form-label">Cliente <span class="text-danger">*</span></label>
                                            <select class="form-select @error('clientId') is-invalid @enderror" 
                                                id="clientId" name="clientId" required>
                                                <option value="">Seleccionar cliente...</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->_id }}" {{ old('clientId') == $client->_id ? 'selected' : '' }}>
                                                        {{ $client->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('clientId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Descripción -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="3" 
                                                placeholder="Descripción adicional de la cotización...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Responsable -->
                                        <div class="mb-3">
                                            <label for="responsibleId" class="form-label">Responsable <span class="text-danger">*</span></label>
                                            <select class="form-select @error('responsibleId') is-invalid @enderror" 
                                                id="responsibleId" name="responsibleId" required>
                                                <option value="">Seleccionar responsable...</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->_id }}" {{ old('responsibleId') == $user->_id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('responsibleId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Estado -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Estado</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status">
                                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Aprobada</option>
                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activa</option>
                                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Grúas y Precios</h5>
                                        <button type="button" class="btn btn-sm btn-primary" id="addCraneBtn">
                                            <i class="fas fa-plus"></i> Agregar Grúa
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="cranesContainer">
                                            <!-- Aquí se agregarán dinámicamente las grúas -->
                                            <div class="alert alert-info" id="noCranesMessage">
                                                <i class="fas fa-info-circle me-2"></i> Agrega al menos una grúa a la cotización.
                                            </div>
                                        </div>

                                        <template id="craneTemplate">
                                            <div class="crane-item card mb-3">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 crane-title">Grúa</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-crane-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Seleccionar Grúa <span class="text-danger">*</span></label>
                                                            <select class="form-select crane-select" name="cranes[INDEX][crane]" required>
                                                                <option value="">Seleccionar grúa...</option>
                                                                @foreach($cranes as $crane)
                                                                    <option value="{{ $crane->_id }}" 
                                                                            data-precios="{{ json_encode($crane->precios ?? []) }}"
                                                                            data-nombre="{{ $crane->nombre }}"
                                                                            data-marca="{{ $crane->marca }}"
                                                                            data-modelo="{{ $crane->modelo }}"
                                                                            data-capacidad="{{ $crane->capacidad }}">
                                                                        {{ $crane->nombre }} ({{ $crane->marca }} {{ $crane->modelo }}) - {{ $crane->capacidad }} ton
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 mb-3 zona-container" style="display: none;">
                                                            <label class="form-label">Zona <span class="text-danger">*</span></label>
                                                            <select class="form-select zona-select" name="cranes[INDEX][zona]" required>
                                                                <option value="">Seleccionar zona...</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Días <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control dias-input" 
                                                                   name="cranes[INDEX][dias]" min="1" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Precio por Día <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">S/</span>
                                                                <input type="number" class="form-control precio-input" 
                                                                       name="cranes[INDEX][precio]" min="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-success mb-0">
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Subtotal:</span>
                                                                    <span class="crane-subtotal">S/ 0.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Configuración de IVA -->
                                        <div class="mb-4 mt-4">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h5 class="mb-0">Configuración de IVA</h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Switch para incluir IVA -->
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <!-- Campo hidden para asegurar que siempre se envíe un valor -->
                                                            <input type="hidden" name="include_iva" value="0">
                                                            <input class="form-check-input" type="checkbox" id="includeIva" name="include_iva" value="1" checked>
                                                            <label class="form-check-label fw-bold" for="includeIva">
                                                                <i class="fas fa-percentage me-2"></i>Incluir IVA en la cotización
                                                            </label>
                                                        </div>
                                                        <small class="text-muted">Activa o desactiva el cálculo de IVA para esta cotización</small>
                                                    </div>

                                                    <!-- Campo de porcentaje de IVA -->
                                                    <div class="mb-3" id="ivaSection">
                                                        <label for="iva" class="form-label">Porcentaje de IVA (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control @error('iva') is-invalid @enderror" 
                                                                id="iva" name="iva" value="{{ old('iva', 16) }}" min="0" max="100" step="0.01">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        @error('iva')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="text-muted">Ingresa el porcentaje de IVA a aplicar</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Resumen de totales -->
                                        <div class="card bg-light mt-3">
                                            <div class="card-body">
                                                <h6 class="mb-3"><i class="fas fa-calculator me-2"></i>Resumen de Totales</h6>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <span id="subtotalDisplay" class="fw-bold">S/ 0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2" id="ivaRow">
                                                    <span>IVA (<span id="ivaRateDisplay">16</span>%):</span>
                                                    <span id="ivaDisplay" class="fw-bold text-info">S/ 0.00</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold fs-5">
                                                    <span>Total:</span>
                                                    <span id="totalDisplay" class="text-success">S/ 0.00</span>
                                                </div>
                                                <input type="hidden" id="total" name="total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cotización
                            </button>
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
        let craneIndex = 0;
        const cranesContainer = document.getElementById('cranesContainer');
        const noCranesMessage = document.getElementById('noCranesMessage');
        const addCraneBtn = document.getElementById('addCraneBtn');
        const craneTemplate = document.getElementById('craneTemplate').content;
        const ivaInput = document.getElementById('iva');
        const includeIvaSwitch = document.getElementById('includeIva');
        const ivaSection = document.getElementById('ivaSection');
        const ivaRow = document.getElementById('ivaRow');
        const ivaRateDisplay = document.getElementById('ivaRateDisplay');
        const subtotalDisplay = document.getElementById('subtotalDisplay');
        const ivaDisplay = document.getElementById('ivaDisplay');
        const totalDisplay = document.getElementById('totalDisplay');
        const totalInput = document.getElementById('total');
        const zoneInput = document.getElementById('zone');
        
        // Agregar grúa
        addCraneBtn.addEventListener('click', function() {
            addCrane();
        });
        
        // Manejar switch de IVA
        includeIvaSwitch.addEventListener('change', function() {
            if (this.checked) {
                ivaSection.style.display = 'block';
                ivaRow.style.display = 'flex';
            } else {
                ivaSection.style.display = 'none';
                ivaRow.style.display = 'none';
                ivaInput.value = 0;
            }
            updateTotals();
        });
        
        // Actualizar IVA cuando cambie
        ivaInput.addEventListener('input', function() {
            ivaRateDisplay.textContent = this.value || '0';
            updateTotals();
        });
        
        // Función para agregar una grúa
        function addCrane() {
            noCranesMessage.style.display = 'none';
            
            const clone = document.importNode(craneTemplate, true);
            
            // Actualizar índices
            const selects = clone.querySelectorAll('select');
            const inputs = clone.querySelectorAll('input');
            
            selects.forEach(select => {
                select.name = select.name.replace('INDEX', craneIndex);
                
                if (select.classList.contains('crane-select')) {
                    select.addEventListener('change', function() {
                        handleCraneSelection(this);
                    });
                } else if (select.classList.contains('zona-select')) {
                    select.addEventListener('change', function() {
                        handleZoneSelection(this);
                    });
                }
            });
            
            inputs.forEach(input => {
                input.name = input.name.replace('INDEX', craneIndex);
                input.addEventListener('input', function() {
                    updateSubtotal(this.closest('.crane-item'));
                });
            });
            
            // Configurar botón de eliminar
            const removeBtn = clone.querySelector('.remove-crane-btn');
            removeBtn.addEventListener('click', function() {
                this.closest('.crane-item').remove();
                updateTotals();
                
                // Mostrar mensaje si no hay grúas
                if (cranesContainer.querySelectorAll('.crane-item').length === 0) {
                    noCranesMessage.style.display = 'block';
                }
            });
            
            // Actualizar título
            clone.querySelector('.crane-title').textContent = `Grúa ${craneIndex + 1}`;
            
            cranesContainer.appendChild(clone);
            craneIndex++;
            updateTotals();
        }
        
        // Función para manejar la selección de grúa
        function handleCraneSelection(select) {
            const craneItem = select.closest('.crane-item');
            const zonaContainer = craneItem.querySelector('.zona-container');
            const zonaSelect = craneItem.querySelector('.zona-select');
            
            if (!select.value) {
                zonaContainer.style.display = 'none';
                zonaSelect.innerHTML = '<option value="">Seleccionar zona...</option>';
                return;
            }
            
            const option = select.options[select.selectedIndex];
            const precios = JSON.parse(option.dataset.precios || '[]');
            
            // Limpiar y llenar el select de zonas
            zonaSelect.innerHTML = '<option value="">Seleccionar zona...</option>';
            
            precios.forEach(precio => {
                const optionElement = document.createElement('option');
                optionElement.value = precio.zona;
                optionElement.textContent = precio.zona;
                optionElement.dataset.precio = precio.precio;
                zonaSelect.appendChild(optionElement);
            });
            
            zonaContainer.style.display = 'block';
        }
        
        // Función para manejar la selección de zona
        function handleZoneSelection(select) {
            const craneItem = select.closest('.crane-item');
            const precioInput = craneItem.querySelector('.precio-input');
            
            if (!select.value) {
                precioInput.value = '';
                updateSubtotal(craneItem);
                return;
            }
            
            const option = select.options[select.selectedIndex];
            const precio = option.dataset.precio;
            
            if (precio) {
                precioInput.value = precio;
                updateSubtotal(craneItem);
            }
        }
        
        // Función para actualizar subtotal de una grúa
        function updateSubtotal(craneItem) {
            const dias = parseFloat(craneItem.querySelector('.dias-input').value) || 0;
            const precio = parseFloat(craneItem.querySelector('.precio-input').value) || 0;
            const subtotal = dias * precio;
            
            craneItem.querySelector('.crane-subtotal').textContent = 'S/ ' + subtotal.toFixed(2);
            updateTotals();
        }
        
        // Función para actualizar totales generales
        function updateTotals() {
            let subtotal = 0;
            const craneItems = cranesContainer.querySelectorAll('.crane-item');
            
            craneItems.forEach(item => {
                const dias = parseFloat(item.querySelector('.dias-input').value) || 0;
                const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
                subtotal += dias * precio;
            });
            
            const includeIva = includeIvaSwitch.checked;
            const ivaRate = includeIva ? (parseFloat(ivaInput.value) || 0) : 0;
            const ivaAmount = subtotal * (ivaRate / 100);
            const total = subtotal + ivaAmount;
            
            subtotalDisplay.textContent = 'S/ ' + subtotal.toFixed(2);
            ivaDisplay.textContent = 'S/ ' + ivaAmount.toFixed(2);
            totalDisplay.textContent = 'S/ ' + total.toFixed(2);
            totalInput.value = total.toFixed(2);
        }
        
        // Validar formulario antes de enviar
        document.getElementById('quoteForm').addEventListener('submit', function(e) {
            const craneItems = cranesContainer.querySelectorAll('.crane-item');
            if (craneItems.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos una grúa a la cotización.');
                return false;
            }
            return true;
        });
        
        // Agregar una grúa inicial
        addCrane();
    });
</script>
@endpush