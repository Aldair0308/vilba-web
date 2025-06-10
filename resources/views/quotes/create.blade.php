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

                                        <!-- Archivo/PDF -->
                                        <div class="mb-3">
                                            <label for="fileId" class="form-label">Archivo PDF <span class="text-danger">*</span></label>
                                            <select class="form-select @error('fileId') is-invalid @enderror" 
                                                id="fileId" name="fileId" required>
                                                <option value="">Seleccionar archivo...</option>
                                                @foreach($files as $file)
                                                    @if($file->type === 'pdf')
                                                        <option value="{{ $file->_id }}" {{ old('fileId') == $file->_id ? 'selected' : '' }}>
                                                            {{ $file->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('fileId')
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
                                                                            data-norte="{{ $crane->precios['zona_norte'] ?? 0 }}" 
                                                                            data-sur="{{ $crane->precios['zona_sur'] ?? 0 }}" 
                                                                            data-centro="{{ $crane->precios['zona_centro'] ?? 0 }}" 
                                                                            data-este="{{ $crane->precios['zona_este'] ?? 0 }}" 
                                                                            data-oeste="{{ $crane->precios['zona_oeste'] ?? 0 }}">
                                                                        {{ $crane->nombre }} ({{ $crane->marca }} {{ $crane->modelo }}) - {{ $crane->capacidad }}
                                                                    </option>
                                                                @endforeach
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
                                                                <span class="input-group-text">$</span>
                                                                <input type="number" class="form-control precio-input" 
                                                                       name="cranes[INDEX][precio]" min="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-success mb-0">
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Subtotal:</span>
                                                                    <span class="crane-subtotal">$0.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- IVA -->
                                        <div class="mb-3 mt-4">
                                            <label for="iva" class="form-label">IVA (%)</label>
                                            <input type="number" class="form-control @error('iva') is-invalid @enderror" 
                                                id="iva" name="iva" value="{{ old('iva', 16) }}" min="0" max="100" step="0.01">
                                            @error('iva')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Resumen de totales -->
                                        <div class="card bg-light mt-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">Resumen</h6>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <span id="subtotalDisplay">$0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>IVA (<span id="ivaRateDisplay">16</span>%):</span>
                                                    <span id="ivaDisplay">$0.00</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Total:</span>
                                                    <span id="totalDisplay" class="text-success">$0.00</span>
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
                select.addEventListener('change', function() {
                    updatePriceBasedOnZone(this, zoneInput.value);
                    updateSubtotal(this.closest('.crane-item'));
                });
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
        
        // Función para actualizar precio basado en zona
        function updatePriceBasedOnZone(select, zone) {
            if (!select.value) return;
            
            const option = select.options[select.selectedIndex];
            const craneItem = select.closest('.crane-item');
            const precioInput = craneItem.querySelector('.precio-input');
            
            let price = 0;
            zone = zone.toLowerCase();
            
            if (zone.includes('norte')) {
                price = option.dataset.norte;
            } else if (zone.includes('sur')) {
                price = option.dataset.sur;
            } else if (zone.includes('centro')) {
                price = option.dataset.centro;
            } else if (zone.includes('este')) {
                price = option.dataset.este;
            } else if (zone.includes('oeste')) {
                price = option.dataset.oeste;
            }
            
            if (price && price > 0) {
                precioInput.value = price;
            }
        }
        
        // Función para actualizar subtotal de una grúa
        function updateSubtotal(craneItem) {
            const dias = parseFloat(craneItem.querySelector('.dias-input').value) || 0;
            const precio = parseFloat(craneItem.querySelector('.precio-input').value) || 0;
            const subtotal = dias * precio;
            
            craneItem.querySelector('.crane-subtotal').textContent = '$' + subtotal.toFixed(2);
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
            
            const ivaRate = parseFloat(ivaInput.value) || 0;
            const ivaAmount = subtotal * (ivaRate / 100);
            const total = subtotal + ivaAmount;
            
            subtotalDisplay.textContent = '$' + subtotal.toFixed(2);
            ivaDisplay.textContent = '$' + ivaAmount.toFixed(2);
            totalDisplay.textContent = '$' + total.toFixed(2);
            totalInput.value = total.toFixed(2);
        }
        
        // Escuchar cambios en la zona para actualizar precios
        zoneInput.addEventListener('input', function() {
            const craneItems = cranesContainer.querySelectorAll('.crane-item');
            craneItems.forEach(item => {
                const select = item.querySelector('.crane-select');
                updatePriceBasedOnZone(select, this.value);
                updateSubtotal(item);
            });
        });
        
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