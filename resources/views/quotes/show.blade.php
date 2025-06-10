@extends('layouts.app')

@section('title', 'Detalles de Cotización')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header rounded mb-4">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">Detalles de Cotización</h1>
                            <p class="mb-0 opacity-75">{{ $quote->name }}</p>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('quotes.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                            </a>
                            <a href="{{ route('quotes.edit', $quote->_id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Editar
                            </a>
                            <button type="button" class="btn btn-outline-danger" 
                                    onclick="confirmDelete('{{ $quote->_id }}', '{{ $quote->name }}')">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Información General -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información General</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre:</label>
                                        <p class="mb-0">{{ $quote->name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Zona:</label>
                                        <p class="mb-0">
                                            <span class="badge bg-secondary">{{ $quote->zone }}</span>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cliente:</label>
                                        <p class="mb-0">
                                            @if($quote->client)
                                                <strong>{{ $quote->client->name }}</strong><br>
                                                <small class="text-muted">{{ $quote->client->email }}</small><br>
                                                <small class="text-muted">{{ $quote->client->phone }}</small>
                                            @else
                                                <span class="text-muted">Cliente no encontrado</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Estado:</label>
                                        <p class="mb-0">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    'active' => 'primary',
                                                    'completed' => 'info'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Pendiente',
                                                    'approved' => 'Aprobada',
                                                    'rejected' => 'Rechazada',
                                                    'active' => 'Activa',
                                                    'completed' => 'Completada'
                                                ];
                                                $status = $quote->status ?? 'pending';
                                                $color = (is_string($status) && isset($statusColors[$status])) ? $statusColors[$status] : 'secondary';
                                                $label = (is_string($status) && isset($statusLabels[$status])) ? $statusLabels[$status] : $status;
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Responsable:</label>
                                        <p class="mb-0">
                                            @if($quote->responsible)
                                                {{ $quote->responsible->name }}
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Archivo PDF:</label>
                                        <p class="mb-0">
                                            @if($quote->file)
                                                <a href="{{ route('files.show', $quote->file->_id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf me-1"></i>{{ $quote->file->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Archivo no encontrado</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha de Creación:</label>
                                        <p class="mb-0">{{ $quote->createdAt->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Última Actualización:</label>
                                        <p class="mb-0">{{ $quote->updatedAt->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grúas y Detalles -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Grúas Cotizadas</h6>
                        </div>
                        <div class="card-body">
                            @if(is_array($quote->cranes) && count($quote->cranes) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Grúa</th>
                                                <th>Marca/Modelo</th>
                                                <th>Capacidad</th>
                                                <th>Días</th>
                                                <th>Precio/Día</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($craneDetails as $detail)
                                                <tr>
                                                    <td>
                                                        @if(isset($detail['crane_info']) && is_array($detail['crane_info']) && isset($detail['crane_info']['nombre']))
                                                            <strong>{{ $detail['crane_info']['nombre'] }}</strong>
                                                        @else
                                                            <span class="text-muted">Grúa no encontrada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($detail['crane_info']) && is_array($detail['crane_info']) && isset($detail['crane_info']['marca']) && isset($detail['crane_info']['modelo']))
                                                            {{ $detail['crane_info']['marca'] }} {{ $detail['crane_info']['modelo'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($detail['crane_info']) && is_array($detail['crane_info']) && isset($detail['crane_info']['capacidad']))
                                                            <span class="badge bg-info">{{ $detail['crane_info']['capacidad'] }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ isset($detail['dias']) ? $detail['dias'] : 0 }} día(s)</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success fw-bold">${{ isset($detail['precio']) ? number_format($detail['precio'], 2) : '0.00' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success fw-bold">${{ isset($detail['subtotal']) ? number_format($detail['subtotal'], 2) : '0.00' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                                    <p class="text-muted">No hay grúas asignadas a esta cotización.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vista Previa del PDF -->
                    @if($quote->file)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-file-pdf me-2"></i>Vista Previa del PDF
                                </h6>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePdfFullscreen()">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <a href="{{ route('files.preview', $quote->file->_id) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('files.download', $quote->file->_id) }}" class="btn btn-outline-success">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="pdf-preview-container" style="height: 500px; position: relative;">
                                    <iframe 
                                        id="pdf-preview-iframe"
                                        src="{{ route('files.preview', $quote->file->_id) }}" 
                                        width="100%" 
                                        height="100%" 
                                        style="border: none;"
                                        title="Vista previa de {{ $quote->file->name }}">
                                        <div class="text-center p-4">
                                            <p class="text-muted">Su navegador no soporta la visualización de PDFs.</p>
                                            <a href="{{ route('files.download', $quote->file->_id) }}" class="btn btn-primary">
                                                <i class="fas fa-download me-2"></i>Descargar PDF
                                            </a>
                                        </div>
                                    </iframe>
                                    <div class="position-absolute bottom-0 end-0 m-2">
                                        <small class="badge bg-dark bg-opacity-75">{{ $quote->file->name }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Panel Lateral -->
                <div class="col-md-4">
                    <!-- Resumen Financiero -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Resumen Financiero</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold">${{ number_format($quote->subtotal, 2) }}</span>
                            </div>
                            @if($quote->iva > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>IVA ({{ $quote->iva }}%):</span>
                                    <span class="fw-bold">${{ number_format($quote->iva_amount, 2) }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h5 mb-0 text-success">${{ number_format($quote->total, 2) }}</span>
                            </div>
                            
                            @if($quote->calculated_total != $quote->total)
                                <div class="alert alert-warning mt-3">
                                    <small>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Total calculado: ${{ number_format($quote->calculated_total, 2) }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <!-- Cambiar Estado -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cambiar Estado:</label>
                                <form action="{{ route('quotes.change-status', $quote->_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Aprobada</option>
                                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                            <option value="active" {{ $quote->status === 'active' ? 'selected' : '' }}>Activa</option>
                                            <option value="completed" {{ $quote->status === 'completed' ? 'selected' : '' }}>Completada</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('quotes.edit', $quote->_id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-2"></i>Editar Cotización
                                </a>
                                
                                @if($quote->file)
                                    <a href="{{ route('files.show', $quote->file->_id) }}" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-file-pdf me-2"></i>Ver PDF
                                    </a>
                                @endif
                                
                                @if($quote->client)
                                    <a href="{{ route('clients.show', $quote->client->_id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-user me-2"></i>Ver Cliente
                                    </a>
                                @endif
                                
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="duplicateQuote()">
                                    <i class="fas fa-copy me-2"></i>Duplicar
                                </button>
                                
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete('{{ $quote->_id }}', '{{ $quote->name }}')">
                                    <i class="fas fa-trash me-2"></i>Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información Adicional</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">ID de Cotización:</small><br>
                                <code>{{ $quote->_id }}</code>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Número de Grúas:</small><br>
                                <span class="badge bg-info">{{ is_array($quote->cranes) ? count($quote->cranes) : 0 }}</span>
                            </div>
                            @if($quote->client)
                                <div class="mb-2">
                                    <small class="text-muted">RFC del Cliente:</small><br>
                                    <span class="fw-bold">{{ $quote->client->rfc ?? 'No disponible' }}</span>
                                </div>
                            @endif
                            <div class="mb-2">
                                <small class="text-muted">Validación de Grúas:</small><br>
                                @if($quote->validateCranes())
                                    <span class="badge bg-success">Válida</span>
                                @else
                                    <span class="badge bg-danger">Inválida</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la cotización <strong id="quoteName"></strong>?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(quoteId, quoteName) {
    document.getElementById('quoteName').textContent = quoteName;
    document.getElementById('deleteForm').action = `/quotes/${quoteId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function duplicateQuote() {
    if (confirm('¿Deseas crear una nueva cotización basada en esta?')) {
        // Redirigir al formulario de creación con parámetros de la cotización actual
        const url = new URL('{{ route("quotes.create") }}');
        url.searchParams.set('duplicate', '{{ $quote->_id }}');
        window.location.href = url.toString();
    }
}

function togglePdfFullscreen() {
    const container = document.getElementById('pdf-preview-container');
    const iframe = document.getElementById('pdf-preview-iframe');
    const button = event.target.closest('button');
    const icon = button.querySelector('i');
    
    if (container.classList.contains('pdf-fullscreen')) {
        // Salir de pantalla completa
        container.classList.remove('pdf-fullscreen');
        container.style.position = 'relative';
        container.style.top = 'auto';
        container.style.left = 'auto';
        container.style.width = 'auto';
        container.style.height = '500px';
        container.style.zIndex = 'auto';
        container.style.backgroundColor = 'transparent';
        icon.className = 'fas fa-expand';
        document.body.style.overflow = 'auto';
    } else {
        // Entrar en pantalla completa
        container.classList.add('pdf-fullscreen');
        container.style.position = 'fixed';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100vw';
        container.style.height = '100vh';
        container.style.zIndex = '9999';
        container.style.backgroundColor = '#fff';
        icon.className = 'fas fa-compress';
        document.body.style.overflow = 'hidden';
    }
}

// Cerrar pantalla completa con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const container = document.getElementById('pdf-preview-container');
        if (container && container.classList.contains('pdf-fullscreen')) {
            togglePdfFullscreen();
        }
    }
});
</script>
@endpush