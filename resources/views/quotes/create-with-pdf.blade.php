@extends('layouts.app')

@section('title', 'Crear Cotización con PDF')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                        Crear Cotización con PDF
                    </h3>
                    <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver
                    </a>
                </div>
                
                <form action="{{ route('quotes.store-and-generate-pdf') }}" method="POST" id="quoteForm">
                    @csrf
                    <div class="card-body">
                        <!-- Información General -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre de la Cotización <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zone">Zona <span class="text-danger">*</span></label>
                                    <select class="form-control @error('zone') is-invalid @enderror" 
                                            id="zone" name="zone" required>
                                        <option value="">Seleccionar zona</option>
                                        <option value="Norte" {{ old('zone') == 'Norte' ? 'selected' : '' }}>Norte</option>
                                        <option value="Sur" {{ old('zone') == 'Sur' ? 'selected' : '' }}>Sur</option>
                                        <option value="Este" {{ old('zone') == 'Este' ? 'selected' : '' }}>Este</option>
                                        <option value="Oeste" {{ old('zone') == 'Oeste' ? 'selected' : '' }}>Oeste</option>
                                        <option value="Centro" {{ old('zone') == 'Centro' ? 'selected' : '' }}>Centro</option>
                                    </select>
                                    @error('zone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clientId">Cliente <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('clientId') is-invalid @enderror" 
                                            id="clientId" name="clientId" required>
                                        <option value="">Seleccionar cliente</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->_id }}" 
                                                    {{ old('clientId') == $client->_id ? 'selected' : '' }}>
                                                {{ $client->name }} - {{ $client->rfc }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('clientId')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="responsibleId">Responsable <span class="text-danger">*</span></label>
                                    <select class="form-control @error('responsibleId') is-invalid @enderror" 
                                            id="responsibleId" name="responsibleId" required>
                                        <option value="">Seleccionar responsable</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->_id }}" 
                                                    {{ old('responsibleId') == $user->_id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('responsibleId')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción del Proyecto -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="project_description">Descripción del Proyecto</label>
                                    <textarea class="form-control" id="project_description" name="project_description" 
                                              rows="3" placeholder="Describe brevemente el proyecto...">{{ old('project_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Equipos/Grúas -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-truck-moving mr-2"></i>
                                    Equipos a Cotizar
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="cranes-container">
                                    <div class="crane-item border rounded p-3 mb-3" data-index="0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Equipo <span class="text-danger">*</span></label>
                                                    <select class="form-control crane-select" name="cranes[0][craneId]" required>
                                                        <option value="">Seleccionar equipo</option>
                                                        @foreach($cranes as $crane)
                                                            <option value="{{ $crane->_id }}" 
                                                                    data-prices="{{ json_encode($crane->precios ?? []) }}">
                                                                {{ $crane->marca }} {{ $crane->modelo }} - {{ $crane->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Días <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control days-input" 
                                                           name="cranes[0][days]" min="1" value="1" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Precio/Día</label>
                                                    <input type="number" class="form-control price-input" 
                                                           name="cranes[0][price]" step="0.01" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Subtotal</label>
                                                    <input type="number" class="form-control subtotal-input" 
                                                           name="cranes[0][subtotal]" step="0.01" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger btn-block remove-crane" 
                                                            style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-success" id="add-crane">
                                    <i class="fas fa-plus mr-1"></i>
                                    Agregar Equipo
                                </button>
                            </div>
                        </div>

                        <!-- Totales -->
                        <div class="row mt-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="iva">IVA (%) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('iva') is-invalid @enderror" 
                                                       id="iva" name="iva" value="{{ old('iva', 16) }}" 
                                                       step="0.01" min="0" max="100" required>
                                                @error('iva')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label>Total</label>
                                                <input type="number" class="form-control" id="total" name="total" 
                                                       step="0.01" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Opciones de PDF -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-cog mr-2"></i>
                                    Opciones de PDF
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="generate_pdf" 
                                                   name="generate_pdf" value="1" checked>
                                            <label class="form-check-label" for="generate_pdf">
                                                Generar PDF automáticamente
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="download_pdf" 
                                                   name="download_pdf" value="1" checked>
                                            <label class="form-check-label" for="download_pdf">
                                                Descargar PDF inmediatamente
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Crear Cotización
                                </button>
                                <button type="button" class="btn btn-info ml-2" id="preview-pdf">
                                    <i class="fas fa-eye mr-1"></i>
                                    Vista Previa PDF
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <span class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .crane-item {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .crane-item:hover {
        background-color: #e9ecef;
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    .card-header h5 {
        color: #495057;
    }
    
    .form-check-label {
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    let craneIndex = 1;
    
    // Inicializar Select2
    $('.select2').select2({
        placeholder: 'Seleccionar...',
        allowClear: true
    });
    
    // Agregar nuevo equipo
    $('#add-crane').click(function() {
        const newCrane = $('.crane-item:first').clone();
        newCrane.attr('data-index', craneIndex);
        
        // Actualizar nombres de los inputs
        newCrane.find('select, input').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('[0]', '[' + craneIndex + ']'));
            }
            $(this).val('');
        });
        
        // Mostrar botón de eliminar
        newCrane.find('.remove-crane').show();
        
        $('#cranes-container').append(newCrane);
        craneIndex++;
        
        updateRemoveButtons();
    });
    
    // Eliminar equipo
    $(document).on('click', '.remove-crane', function() {
        $(this).closest('.crane-item').remove();
        updateRemoveButtons();
        calculateTotal();
    });
    
    // Actualizar botones de eliminar
    function updateRemoveButtons() {
        const craneItems = $('.crane-item');
        if (craneItems.length > 1) {
            $('.remove-crane').show();
        } else {
            $('.remove-crane').hide();
        }
    }
    
    // Cambio de equipo
    $(document).on('change', '.crane-select', function() {
        const selectedOption = $(this).find('option:selected');
        const prices = selectedOption.data('prices') || {};
        const zone = $('#zone').val();
        const priceInput = $(this).closest('.crane-item').find('.price-input');
        
        if (zone && prices[zone]) {
            priceInput.val(prices[zone]);
        } else {
            priceInput.val('');
        }
        
        calculateSubtotal($(this).closest('.crane-item'));
    });
    
    // Cambio de zona
    $('#zone').change(function() {
        $('.crane-select').each(function() {
            $(this).trigger('change');
        });
    });
    
    // Cambio de días
    $(document).on('input', '.days-input', function() {
        calculateSubtotal($(this).closest('.crane-item'));
    });
    
    // Cambio de precio manual
    $(document).on('input', '.price-input', function() {
        calculateSubtotal($(this).closest('.crane-item'));
    });
    
    // Cambio de IVA
    $('#iva').on('input', function() {
        calculateTotal();
    });
    
    // Calcular subtotal de un equipo
    function calculateSubtotal(craneItem) {
        const days = parseFloat(craneItem.find('.days-input').val()) || 0;
        const price = parseFloat(craneItem.find('.price-input').val()) || 0;
        const subtotal = days * price;
        
        craneItem.find('.subtotal-input').val(subtotal.toFixed(2));
        calculateTotal();
    }
    
    // Calcular total general
    function calculateTotal() {
        let subtotalSum = 0;
        
        $('.subtotal-input').each(function() {
            subtotalSum += parseFloat($(this).val()) || 0;
        });
        
        const iva = parseFloat($('#iva').val()) || 0;
        const ivaAmount = subtotalSum * (iva / 100);
        const total = subtotalSum + ivaAmount;
        
        $('#total').val(total.toFixed(2));
    }
    
    // Vista previa PDF
    $('#preview-pdf').click(function() {
        // Aquí podrías implementar una vista previa del PDF
        alert('Funcionalidad de vista previa en desarrollo');
    });
    
    // Validación del formulario
    $('#quoteForm').submit(function(e) {
        let isValid = true;
        
        // Validar que haya al menos un equipo
        if ($('.crane-select').length === 0) {
            alert('Debe agregar al menos un equipo');
            isValid = false;
        }
        
        // Validar que todos los equipos tengan datos completos
        $('.crane-item').each(function() {
            const craneId = $(this).find('.crane-select').val();
            const days = $(this).find('.days-input').val();
            const price = $(this).find('.price-input').val();
            
            if (!craneId || !days || !price) {
                alert('Todos los equipos deben tener datos completos');
                isValid = false;
                return false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    // Inicializar cálculos
    calculateTotal();
});
</script>
@endpush
@endsection