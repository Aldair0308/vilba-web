@extends('layouts.app')

@section('title', 'Archivo: ' . $file->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('files.index') }}">Archivos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $file->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 text-gray-800">{{ $file->name }}</h1>
                    <p class="mb-0 text-muted">Información detallada del archivo</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Descargar
                    </a>
                    <a href="{{ route('files.edit', $file->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <form method="POST" action="{{ route('files.destroy', $file->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Está seguro de eliminar este archivo? Esta acción no se puede deshacer.')">
                            <i class="fas fa-trash me-2"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <div class="row">
                <!-- Información del Archivo -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-file me-2"></i>Información del Archivo
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre del Archivo</label>
                                    <p class="h5 mb-0">{{ $file->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Tipo de Archivo</label>
                                    <div>
                                        @if($file->type === 'pdf')
                                            <span class="badge bg-danger fs-6">
                                                <i class="fas fa-file-pdf me-1"></i>PDF
                                            </span>
                                        @elseif($file->type === 'excel')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-file-excel me-1"></i>Excel
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">
                                                <i class="fas fa-file me-1"></i>{{ strtoupper($file->type) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Departamento</label>
                                    <p class="mb-0">
                                        <i class="fas fa-building me-2"></i>{{ $file->department }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Responsable</label>
                                    <p class="mb-0">
                                        <i class="fas fa-user me-2"></i>{{ $file->responsible_id }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Tamaño del Archivo</label>
                                    <p class="mb-0">
                                        <i class="fas fa-hdd me-2"></i>{{ $file->formatted_file_size }}
                                        <small class="text-muted">({{ number_format($file->file_size) }} bytes)</small>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Extensión</label>
                                    <p class="mb-0">
                                        <code class="fs-6">.{{ $file->file_extension }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Tipo MIME</label>
                                    <p class="mb-0">
                                        <code class="fs-6">{{ $file->mime_type }}</code>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha de Subida</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $file->createdAt->format('d/m/Y H:i:s') }}
                                        <small class="text-muted">({{ $file->createdAt->diffForHumans() }})</small>
                                    </p>
                                </div>
                                @if($file->updatedAt && $file->updatedAt != $file->createdAt)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Última Modificación</label>
                                        <p class="mb-0">
                                            <i class="fas fa-edit me-2"></i>
                                            {{ $file->updatedAt->format('d/m/Y H:i:s') }}
                                            <small class="text-muted">({{ $file->updatedAt->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vista Previa del Archivo -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-eye me-2"></i>Vista Previa
                            </h6>
                            @if($file->type === 'pdf')
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="zoomOut()">
                                        <i class="fas fa-search-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="zoomIn()">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="toggleFullscreen()">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            @if($file->type === 'pdf')
                                <div id="pdf-viewer-container" style="height: 600px; position: relative;">
                                    <iframe 
                                        id="pdf-viewer"
                                        src="{{ route('files.preview', $file->id) }}" 
                                        width="100%" 
                                        height="100%" 
                                        style="border: none;"
                                        title="Vista previa de {{ $file->name }}">
                                        <p>Su navegador no soporta la visualización de PDFs. 
                                           <a href="{{ route('files.download', $file->id) }}">Descargar el archivo</a>.
                                        </p>
                                    </iframe>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <a href="{{ route('files.preview', $file->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Abrir en nueva pestaña
                                        </a>
                                    </div>
                                </div>
                            @elseif($file->type === 'excel')
                                <div class="text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-file-excel fa-5x text-success"></i>
                                    </div>
                                    <h5>Hoja de Cálculo Excel</h5>
                                    <p class="text-muted">{{ $file->name }}.{{ $file->file_extension }}</p>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary">
                                            <i class="fas fa-download me-2"></i>Descargar
                                        </a>
                                        <a href="{{ route('files.preview', $file->id) }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>Abrir en nueva pestaña
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-file fa-5x text-secondary"></i>
                                    </div>
                                    <h5>Archivo {{ strtoupper($file->type) }}</h5>
                                    <p class="text-muted">{{ $file->name }}.{{ $file->file_extension }}</p>
                                    <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>Descargar
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel Lateral -->
                <div class="col-lg-4">
                    <!-- Acciones Rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary">
                                    <i class="fas fa-download me-2"></i>Descargar Archivo
                                </a>
                                <a href="{{ route('files.edit', $file->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Editar Información
                                </a>
                                <button type="button" class="btn btn-info" onclick="copyFileInfo()">
                                    <i class="fas fa-copy me-2"></i>Copiar Información
                                </button>
                                <hr>
                                <form method="POST" action="{{ route('files.destroy', $file->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" 
                                            onclick="return confirm('¿Está seguro de eliminar este archivo? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash me-2"></i>Eliminar Archivo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Información Técnica -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Información Técnica
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-6">
                                    <div class="text-center p-2">
                                        <div class="text-muted small">Tamaño</div>
                                        <div class="fw-bold">{{ $file->formatted_file_size }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2">
                                        <div class="text-muted small">Tipo</div>
                                        <div class="fw-bold">{{ strtoupper($file->type) }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2">
                                        <div class="text-muted small">Extensión</div>
                                        <div class="fw-bold">.{{ $file->file_extension }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2">
                                        <div class="text-muted small">Válido</div>
                                        <div class="fw-bold">
                                            @if($file->isValidBase64())
                                                <span class="text-success">✓ Sí</span>
                                            @else
                                                <span class="text-danger">✗ No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navegación -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-compass me-2"></i>Navegación
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('files.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-list me-2"></i>Todos los Archivos
                                </a>
                                <a href="{{ route('files.index', ['type' => $file->type]) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-filter me-2"></i>Archivos {{ strtoupper($file->type) }}
                                </a>
                                <a href="{{ route('files.index', ['department' => $file->department]) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-building me-2"></i>Archivos de {{ $file->department }}
                                </a>
                                <a href="{{ route('files.create') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>Subir Nuevo Archivo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.875rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.btn-group .btn {
    margin-left: 0.25rem;
}

.btn-group .btn:first-child {
    margin-left: 0;
}

code {
    color: #e83e8c;
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}

.text-center .fa-5x {
    margin-bottom: 1rem;
}

.row.g-0 > .col-6 {
    border-right: 1px solid #e3e6f0;
    border-bottom: 1px solid #e3e6f0;
}

.row.g-0 > .col-6:nth-child(even) {
    border-right: none;
}

.row.g-0 > .col-6:nth-last-child(-n+2) {
    border-bottom: none;
}
</style>
@endsection

@push('scripts')
<script>
function copyFileInfo() {
    const fileInfo = `Archivo: {{ $file->name }}
Tipo: {{ strtoupper($file->type) }}
Departamento: {{ $file->department }}
Responsable: {{ $file->responsible_id }}
Tamaño: {{ $file->formatted_file_size }}
Fecha: {{ $file->createdAt->format('d/m/Y H:i:s') }}`;
    
    navigator.clipboard.writeText(fileInfo).then(function() {
        // Mostrar notificación de éxito
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>¡Copiado!';
        btn.classList.remove('btn-info');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-info');
        }, 2000);
    }).catch(function(err) {
        console.error('Error al copiar: ', err);
        alert('Error al copiar la información');
    });
}

// Funciones para el visor de PDF
let currentZoom = 1;

function zoomIn() {
    currentZoom += 0.1;
    applyZoom();
}

function zoomOut() {
    if (currentZoom > 0.3) {
        currentZoom -= 0.1;
        applyZoom();
    }
}

function applyZoom() {
    const iframe = document.getElementById('pdf-viewer');
    if (iframe) {
        iframe.style.transform = `scale(${currentZoom})`;
        iframe.style.transformOrigin = 'top left';
        
        // Ajustar el contenedor para el zoom
        const container = document.getElementById('pdf-viewer-container');
        if (container) {
            const newHeight = 600 * currentZoom;
            container.style.height = newHeight + 'px';
        }
    }
}

function toggleFullscreen() {
    const container = document.getElementById('pdf-viewer-container');
    if (container) {
        if (!document.fullscreenElement) {
            container.requestFullscreen().then(() => {
                container.style.height = '100vh';
                const iframe = document.getElementById('pdf-viewer');
                if (iframe) {
                    iframe.style.transform = 'scale(1)';
                    currentZoom = 1;
                }
            }).catch(err => {
                console.error('Error al entrar en pantalla completa:', err);
            });
        } else {
            document.exitFullscreen().then(() => {
                container.style.height = '600px';
                applyZoom();
            });
        }
    }
}

// Escuchar cambios en pantalla completa
document.addEventListener('fullscreenchange', function() {
    const container = document.getElementById('pdf-viewer-container');
    if (container && !document.fullscreenElement) {
        container.style.height = '600px';
        applyZoom();
    }
});

// Confirmar eliminación con información adicional
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.querySelector('form[action*="destroy"]');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fileName = '{{ $file->name }}';
            const fileSize = '{{ $file->formatted_file_size }}';
            
            if (confirm(`¿Está seguro de eliminar el archivo "${fileName}" (${fileSize})?\n\nEsta acción no se puede deshacer.`)) {
                this.submit();
            }
        });
    }
});
</script>
@endpush