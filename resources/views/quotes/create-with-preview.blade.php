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

            <div class="row">
                <!-- Formulario de creación -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{ route('quotes.store') }}" method="POST" id="quoteForm">
                                @csrf

                                <div class="mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Información General</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Nombre de la cotización -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre de la Cotización <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                    id="name" name="name" value="{{ old('name', $nextFolio) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Se genera automáticamente un folio único, pero puedes editarlo si es necesario.</small>
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
                                                        <option value="{{ $client->_id }}" 
                                                                data-rfc="{{ $client->rfc }}"
                                                                {{ old('clientId') == $client->_id ? 'selected' : '' }}>
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

                                <!-- Configuración de IVA -->
                                <div class="mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Configuración de IVA</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Switch para incluir IVA -->
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="includeIva" name="include_iva" value="1" checked>
                                                    <label class="form-check-label fw-bold" for="includeIva">
                                                        <i class="fas fa-percentage me-2"></i>Incluir IVA en la cotización
                                                    </label>
                                                </div>
                                                <small class="text-muted">Activa o desactiva el cálculo de IVA para esta cotización</small>
                                            </div>

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

                                            <!-- Resumen de totales -->
                                            <div class="card bg-light mt-3">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><i class="fas fa-calculator me-2"></i>Resumen de Totales</h6>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Subtotal:</span>
                                                        <span id="subtotalDisplay" class="fw-bold">MXN 0.00</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2" id="ivaRow">
                                                        <span>IVA (<span id="ivaRateDisplay">16</span>%):</span>
                                                        <span id="ivaDisplay" class="fw-bold text-info">MXN 0.00</span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between fw-bold fs-5">
                                                        <span>Total:</span>
                                                        <span id="totalDisplay" class="text-success">MXN 0.00</span>
                                                    </div>
                                                    <input type="hidden" id="total" name="total">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
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
                                                                                data-precios="{{ json_encode($crane->precios) }}"
                                                                                data-nombre="{{ $crane->nombre }}"
                                                                                data-marca="{{ $crane->marca }}"
                                                                                data-modelo="{{ $crane->modelo }}"
                                                                                data-capacidad="{{ $crane->capacidad }}">
                                                                            {{ $crane->nombre }} ({{ $crane->marca }} {{ $crane->modelo }}) - {{ $crane->capacidad }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
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
                                                                    <span class="input-group-text">MXN</span>
                                                                    <input type="number" class="form-control precio-input" 
                                                                           name="cranes[INDEX][precio]" min="0" step="0.01" required readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="alert alert-success mb-0">
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>Subtotal:</span>
                                                                        <span class="crane-subtotal">MXN 0.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
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

                <!-- Vista previa del PDF -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Vista Previa del PDF</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="pdfPreview" style="transform: scale(0.7); transform-origin: top left; width: 142.86%; height: auto; overflow: hidden;">
                                <!-- Aquí se mostrará la vista previa del PDF -->
                                @include('quotes.pdf-preview')
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
            updatePreview();
        });
        
        // Actualizar IVA cuando cambie
        ivaInput.addEventListener('input', function() {
            ivaRateDisplay.textContent = this.value || '0';
            updateTotals();
            updatePreview();
        });
        
        // Escuchar cambios en todos los campos para actualizar la vista previa
        document.getElementById('quoteForm').addEventListener('input', updatePreview);
        document.getElementById('quoteForm').addEventListener('change', updatePreview);
        
        // Función para agregar una grúa
        function addCrane() {
            noCranesMessage.style.display = 'none';
            
            const clone = document.importNode(craneTemplate, true);
            
            // Actualizar índices
            const selects = clone.querySelectorAll('select');
            const inputs = clone.querySelectorAll('input');
            
            selects.forEach(select => {
                select.name = select.name.replace('INDEX', craneIndex);
                
                // Agregar event listeners específicos según la clase
                if (select.classList.contains('crane-select')) {
                    select.addEventListener('change', function() {
                        handleCraneSelection(this);
                        updateSubtotal(this.closest('.crane-item'));
                        updatePreview();
                    });
                } else if (select.classList.contains('zona-select')) {
                    select.addEventListener('change', function() {
                        handleZoneSelection(this);
                        updateSubtotal(this.closest('.crane-item'));
                        updatePreview();
                    });
                }
            });
            
            inputs.forEach(input => {
                input.name = input.name.replace('INDEX', craneIndex);
                input.addEventListener('input', function() {
                    updateSubtotal(this.closest('.crane-item'));
                    updatePreview();
                });
            });
            
            // Configurar botón de eliminar
            const removeBtn = clone.querySelector('.remove-crane-btn');
            removeBtn.addEventListener('click', function() {
                this.closest('.crane-item').remove();
                updateTotals();
                updatePreview();
                
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
            updatePreview();
        }
        
        // Función para manejar la selección de grúa
        function handleCraneSelection(craneSelect) {
            const craneItem = craneSelect.closest('.crane-item');
            const zonaSelect = craneItem.querySelector('.zona-select');
            const precioInput = craneItem.querySelector('.precio-input');
            
            // Limpiar zona y precio
            zonaSelect.innerHTML = '<option value="">Seleccionar zona...</option>';
            precioInput.value = '';
            
            if (craneSelect.value) {
                const selectedOption = craneSelect.options[craneSelect.selectedIndex];
                const precios = JSON.parse(selectedOption.dataset.precios || '[]');
                
                // Llenar opciones de zona
                precios.forEach(precioObj => {
                    const option = document.createElement('option');
                    option.value = precioObj.zona;
                    option.textContent = precioObj.zona.charAt(0).toUpperCase() + precioObj.zona.slice(1);
                    option.dataset.precio = Array.isArray(precioObj.precio) ? precioObj.precio[0] : precioObj.precio;
                    zonaSelect.appendChild(option);
                });
            }
        }
        
        // Función para manejar la selección de zona
        function handleZoneSelection(zonaSelect) {
            const craneItem = zonaSelect.closest('.crane-item');
            const precioInput = craneItem.querySelector('.precio-input');
            
            if (zonaSelect.value) {
                const selectedOption = zonaSelect.options[zonaSelect.selectedIndex];
                const precio = selectedOption.dataset.precio;
                
                if (precio) {
                    precioInput.value = precio;
                }
            } else {
                precioInput.value = '';
            }
        }
        
        // Función para actualizar subtotal de una grúa
        function updateSubtotal(craneItem) {
            const dias = parseFloat(craneItem.querySelector('.dias-input').value) || 0;
            const precio = parseFloat(craneItem.querySelector('.precio-input').value) || 0;
            const subtotal = dias * precio;
            
            craneItem.querySelector('.crane-subtotal').textContent = 'MXN ' + subtotal.toFixed(2);
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
            
            subtotalDisplay.textContent = 'MXN ' + subtotal.toFixed(2);
            ivaDisplay.textContent = 'MXN ' + ivaAmount.toFixed(2);
            totalDisplay.textContent = 'MXN ' + total.toFixed(2);
            totalInput.value = total.toFixed(2);
        }
        
        // Función para actualizar la vista previa
        function updatePreview() {
            const formData = new FormData(document.getElementById('quoteForm'));
            
            // Obtener datos del cliente seleccionado
            const clientSelect = document.getElementById('clientId');
            const selectedClient = clientSelect.options[clientSelect.selectedIndex];
            
            // Obtener datos de las grúas
            const craneItems = cranesContainer.querySelectorAll('.crane-item');
            let itemsRows = '';
            
            craneItems.forEach((item, index) => {
                const select = item.querySelector('.crane-select');
                const selectedOption = select.options[select.selectedIndex];
                const zonaSelect = item.querySelector('.zona-select');
                const selectedZona = zonaSelect ? zonaSelect.options[zonaSelect.selectedIndex] : null;
                const dias = item.querySelector('.dias-input').value || 0;
                const precio = item.querySelector('.precio-input').value || 0;
                const total = (dias * precio).toFixed(2);
                
                if (selectedOption && selectedOption.value) {
                    itemsRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${selectedOption.dataset.nombre || ''} - ${selectedOption.dataset.marca || ''} ${selectedOption.dataset.modelo || ''}</td>
                            <td>${selectedZona && selectedZona.value ? selectedZona.textContent : 'N/A'}</td>
                            <td>${dias}</td>
                            <td>Días</td>
                            <td>MXN ${parseFloat(precio).toFixed(2)}</td>
                            <td>MXN ${total}</td>
                        </tr>
                    `;
                }
            });
            
            // Calcular totales
            let subtotal = 0;
            craneItems.forEach(item => {
                const dias = parseFloat(item.querySelector('.dias-input').value) || 0;
                const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
                subtotal += dias * precio;
            });
            
            const includeIva = includeIvaSwitch.checked;
            const ivaRate = includeIva ? (parseFloat(ivaInput.value) || 16) : 0;
            const ivaAmount = subtotal * (ivaRate / 100);
            const total = subtotal + ivaAmount;
            
            // Actualizar vista previa
            document.getElementById('preview-quotation-number').textContent = 'COT-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 1000)).padStart(3, '0');
            document.getElementById('preview-quotation-date').textContent = new Date().toLocaleDateString('es-ES');
            document.getElementById('preview-client-name').textContent = selectedClient ? selectedClient.textContent : 'Cliente no seleccionado';
            document.getElementById('preview-client-id').textContent = 'N/A';
            document.getElementById('preview-client-address').textContent = 'N/A';
            document.getElementById('preview-client-phone').textContent = 'N/A';
            document.getElementById('preview-client-email').textContent = 'N/A';
            document.getElementById('previewClientRfc').textContent = selectedClient && selectedClient.dataset.rfc ? selectedClient.dataset.rfc : 'N/A';
            document.getElementById('preview-project-description').textContent = document.getElementById('description').value || 'Proyecto de alquiler de grúas';
            document.getElementById('preview-items-rows').innerHTML = itemsRows;
            document.getElementById('preview-subtotal').textContent = 'MXN ' + subtotal.toFixed(2);
            document.getElementById('preview-iva-percentage').textContent = ivaRate;
            document.getElementById('preview-iva').textContent = 'MXN ' + ivaAmount.toFixed(2);
            document.getElementById('preview-total').textContent = 'MXN ' + total.toFixed(2);
            
            // Mostrar/ocultar fila de IVA en la vista previa
            const previewIvaRow = document.getElementById('preview-iva-row');
            const previewIvaTerms = document.getElementById('preview-iva-terms');
            const previewIvaRate = document.getElementById('preview-iva-rate');
            
            if (includeIva) {
                if (previewIvaRow) previewIvaRow.style.display = '';
                if (previewIvaTerms) previewIvaTerms.textContent = 'El precio incluye IVA.';
                if (previewIvaRate) previewIvaRate.textContent = ivaRate;
            } else {
                if (previewIvaRow) previewIvaRow.style.display = 'none';
                if (previewIvaTerms) previewIvaTerms.textContent = 'El precio NO incluye IVA.';
            }
            document.getElementById('preview-date').textContent = new Date().toLocaleDateString('es-ES');
        }
        
        // Escuchar cambios en el cliente para actualizar la vista previa
        document.getElementById('clientId').addEventListener('change', function() {
            updatePreview();
        });
        
        // Escuchar cambios en la descripción para actualizar la vista previa
        document.getElementById('description').addEventListener('input', function() {
            updatePreview();
        });
        
        // Escuchar cambios en la zona para actualizar precios
        zoneInput.addEventListener('input', function() {
            const craneItems = cranesContainer.querySelectorAll('.crane-item');
            craneItems.forEach(item => {
                const select = item.querySelector('.crane-select');
                updatePriceBasedOnZone(select, this.value);
                updateSubtotal(item);
            });
            updatePreview();
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
        
        // Actualizar vista previa inicial
        updatePreview();
    });
</script>
@endpush