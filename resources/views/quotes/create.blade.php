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
                                            <label for="zone" class="form-label">Zona del Proyecto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('zone') is-invalid @enderror" 
                                                id="zone" name="zone" value="{{ old('zone') }}" required>
                                            @error('zone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Ubicación donde se realizará el proyecto</small>
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
                                                    <option value="{{ $user->_id }}" 
                                                        {{ old('responsibleId', auth()->user()->_id) == $user->_id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                        @if($user->_id == auth()->user()->_id)
                                                            <span class="text-muted">(Tú)</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('responsibleId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Por defecto se selecciona tu usuario, pero puedes cambiarlo si es necesario</small>
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
                                <!-- Selector de Equipos -->
                                <div class="card mb-3">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Agregar Equipos</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Seleccionar Equipo</label>
                                                <select class="form-select" id="equipmentSelector">
                                                    <option value="">Seleccionar equipo...</option>
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
                                            <div class="col-md-6 mb-3" id="zoneSelector" style="display: none;">
                                                <label class="form-label">Zona de Trabajo</label>
                                                <select class="form-select" id="zoneSelect">
                                                    <option value="">Seleccionar zona...</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3" id="daysInput" style="display: none;">
                                                <label class="form-label">Días de Alquiler</label>
                                                <input type="number" class="form-control" id="daysValue" min="1" value="1">
                                            </div>
                                            <div class="col-md-6 mb-3" id="priceDisplay" style="display: none;">
                                                <label class="form-label">Precio por Día</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">S/</span>
                                                    <input type="text" class="form-control" id="priceValue" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="addButton" style="display: none;">
                                                <button type="button" class="btn btn-success w-100" id="addToCartBtn">
                                                    <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Carrito de Equipos -->
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Equipos en Cotización</h5>
                                        <span class="badge bg-primary" id="cartCount">0</span>
                                    </div>
                                    <div class="card-body">
                                        <div id="equipmentCart">
                                            <!-- Aquí se mostrarán los equipos agregados -->
                                            <div class="alert alert-info" id="emptyCartMessage">
                                                <i class="fas fa-info-circle me-2"></i> No hay equipos agregados a la cotización.
                                            </div>
                                        </div>

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

                        <!-- Campos ocultos para enviar datos del carrito -->
                        <div id="hiddenInputs"></div>

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
        // Variables globales
        let cart = [];
        let cartIndex = 0;
        
        // Elementos del DOM
        const equipmentSelector = document.getElementById('equipmentSelector');
        const zoneSelector = document.getElementById('zoneSelector');
        const zoneSelect = document.getElementById('zoneSelect');
        const daysInput = document.getElementById('daysInput');
        const daysValue = document.getElementById('daysValue');
        const priceDisplay = document.getElementById('priceDisplay');
        const priceValue = document.getElementById('priceValue');
        const addButton = document.getElementById('addButton');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const equipmentCart = document.getElementById('equipmentCart');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartCount = document.getElementById('cartCount');
        const hiddenInputs = document.getElementById('hiddenInputs');
        
        // Elementos de IVA y totales
        const includeIvaCheckbox = document.getElementById('includeIva');
        const ivaPercentageInput = document.getElementById('iva');
        const ivaRow = document.getElementById('ivaRow');
        const ivaPercentageDisplay = document.getElementById('ivaRateDisplay');
        const totalSubtotal = document.getElementById('subtotalDisplay');
        const totalIva = document.getElementById('ivaDisplay');
        const totalFinal = document.getElementById('totalDisplay');

        // Event listener para selección de equipo
        equipmentSelector.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                try {
                    const precios = JSON.parse(selectedOption.dataset.precios || '[]');
                    
                    // Limpiar y llenar zonas
                    zoneSelect.innerHTML = '<option value="">Seleccionar zona...</option>';
                    
                    if (Array.isArray(precios) && precios.length > 0) {
                        precios.forEach(precio => {
                            if (precio.zona && precio.precio) {
                                const option = document.createElement('option');
                                option.value = precio.zona;
                                option.textContent = precio.zona;
                                option.dataset.precio = precio.precio;
                                zoneSelect.appendChild(option);
                            }
                        });
                        
                        // Mostrar selector de zona
                        zoneSelector.style.display = 'block';
                    } else {
                        // Si no hay precios, mostrar mensaje
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No hay zonas disponibles';
                        option.disabled = true;
                        zoneSelect.appendChild(option);
                        zoneSelector.style.display = 'block';
                    }
                    
                    // Ocultar otros campos hasta que se seleccione zona
                    daysInput.style.display = 'none';
                    priceDisplay.style.display = 'none';
                    addButton.style.display = 'none';
                } catch (error) {
                    console.error('Error parsing precios data:', error);
                    zoneSelector.style.display = 'none';
                }
            } else {
                // Ocultar todos los campos
                zoneSelector.style.display = 'none';
                daysInput.style.display = 'none';
                priceDisplay.style.display = 'none';
                addButton.style.display = 'none';
            }
        });

        // Event listener para selección de zona
        zoneSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const precio = selectedOption.dataset.precio;
                priceValue.value = parseFloat(precio).toFixed(2);
                
                // Mostrar campos de días, precio y botón
                daysInput.style.display = 'block';
                priceDisplay.style.display = 'block';
                addButton.style.display = 'block';
            } else {
                // Ocultar campos
                daysInput.style.display = 'none';
                priceDisplay.style.display = 'none';
                addButton.style.display = 'none';
            }
        });

        // Event listener para agregar al carrito
        addToCartBtn.addEventListener('click', function() {
            const equipmentOption = equipmentSelector.options[equipmentSelector.selectedIndex];
            const zoneOption = zoneSelect.options[zoneSelect.selectedIndex];
            const days = parseInt(daysValue.value);
            const price = parseFloat(priceValue.value);
            
            if (!equipmentOption.value || !zoneOption.value || !days || !price) {
                alert('Por favor, complete todos los campos antes de agregar al carrito.');
                return;
            }
            
            // Crear item del carrito
            const cartItem = {
                id: cartIndex++,
                craneId: equipmentOption.value,
                craneName: equipmentOption.dataset.nombre,
                craneBrand: equipmentOption.dataset.marca,
                craneModel: equipmentOption.dataset.modelo,
                craneCapacity: equipmentOption.dataset.capacidad,
                zone: zoneOption.value,
                days: days,
                pricePerDay: price,
                subtotal: days * price
            };
            
            // Agregar al carrito
            cart.push(cartItem);
            
            // Actualizar UI
            updateCartDisplay();
            updateTotals();
            updateHiddenInputs();
            
            // Limpiar formulario
            resetForm();
        });

        // Función para actualizar la visualización del carrito
        function updateCartDisplay() {
            cartCount.textContent = cart.length;
            
            if (cart.length === 0) {
                emptyCartMessage.style.display = 'block';
                return;
            }
            
            emptyCartMessage.style.display = 'none';
            
            const cartHTML = cart.map(item => `
                <div class="card mb-2" data-cart-id="${item.id}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.craneName}</h6>
                                <small class="text-muted">${item.craneBrand} ${item.craneModel} - ${item.craneCapacity} ton</small>
                                <div class="mt-2">
                                    <span class="badge bg-info me-2">Zona: ${item.zone}</span>
                                    <span class="badge bg-secondary me-2">${item.days} días</span>
                                    <span class="badge bg-success">S/ ${item.pricePerDay.toFixed(2)}/día</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="h6 mb-1">S/ ${item.subtotal.toFixed(2)}</div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            
            equipmentCart.innerHTML = cartHTML;
        }

        // Función para remover del carrito
        window.removeFromCart = function(itemId) {
            cart = cart.filter(item => item.id !== itemId);
            updateCartDisplay();
            updateTotals();
            updateHiddenInputs();
        };

        // Función para actualizar campos ocultos
        function updateHiddenInputs() {
            hiddenInputs.innerHTML = '';
            
            cart.forEach((item, index) => {
                hiddenInputs.innerHTML += `
                    <input type="hidden" name="cranes[${index}][crane]" value="${item.craneId}">
                    <input type="hidden" name="cranes[${index}][zona]" value="${item.zone}">
                    <input type="hidden" name="cranes[${index}][dias]" value="${item.days}">
                    <input type="hidden" name="cranes[${index}][precio]" value="${item.pricePerDay}">
                `;
            });
            
            // Agregar el total calculado
            const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
            let total = subtotal;
            if (includeIvaCheckbox.checked) {
                const ivaPercentage = parseFloat(ivaPercentageInput.value) || 0;
                const ivaAmount = subtotal * (ivaPercentage / 100);
                total = subtotal + ivaAmount;
            }
            
            // Actualizar el campo hidden del total
            document.getElementById('total').value = total.toFixed(2);
        }

        // Función para resetear el formulario de agregar
        function resetForm() {
            equipmentSelector.value = '';
            zoneSelect.innerHTML = '<option value="">Seleccionar zona...</option>';
            daysValue.value = 1;
            priceValue.value = '';
            
            // Ocultar campos
            zoneSelector.style.display = 'none';
            daysInput.style.display = 'none';
            priceDisplay.style.display = 'none';
            addButton.style.display = 'none';
        }

        // Función para actualizar totales
        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
            
            totalSubtotal.textContent = `S/ ${subtotal.toFixed(2)}`;
            
            // Calcular IVA si está habilitado
            let total = subtotal;
            if (includeIvaCheckbox.checked) {
                const ivaPercentage = parseFloat(ivaPercentageInput.value) || 0;
                const ivaAmount = subtotal * (ivaPercentage / 100);
                totalIva.textContent = `S/ ${ivaAmount.toFixed(2)}`;
                total = subtotal + ivaAmount;
            }
            
            totalFinal.textContent = `S/ ${total.toFixed(2)}`;
        }

        // Event listener para checkbox de IVA
        includeIvaCheckbox.addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('ivaSection').style.display = 'block';
                ivaRow.style.display = 'flex';
            } else {
                document.getElementById('ivaSection').style.display = 'none';
                ivaRow.style.display = 'none';
            }
            updateTotals();
        });

        // Event listener para porcentaje de IVA
        ivaPercentageInput.addEventListener('input', function() {
            ivaPercentageDisplay.textContent = this.value;
            updateTotals();
        });

        // Validación del formulario
        document.getElementById('quoteForm').addEventListener('submit', function(e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un equipo a la cotización.');
                return false;
            }
            
            // Debug: verificar que los campos ocultos estén presentes
            console.log('Cart data:', cart);
            console.log('Hidden inputs:', hiddenInputs.innerHTML);
            
            // Asegurar que los campos ocultos estén actualizados antes del envío
            updateHiddenInputs();
            
            // Verificar que los campos ocultos existen
            const craneInputs = document.querySelectorAll('input[name^="cranes["]');
            if (craneInputs.length === 0) {
                e.preventDefault();
                alert('Error: No se pudieron generar los datos del carrito. Por favor, intente nuevamente.');
                return false;
            }
        });

        // Inicializar estado del IVA
        if (includeIvaCheckbox.checked) {
            document.getElementById('ivaSection').style.display = 'block';
            ivaRow.style.display = 'flex';
        } else {
            document.getElementById('ivaSection').style.display = 'none';
            ivaRow.style.display = 'none';
        }
        
        // Inicializar totales
        updateTotals();
    });
</script>
@endpush