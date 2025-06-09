@extends('layouts.app')

@section('title', 'Editar Archivo: ' . $file->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('files.index') }}">Archivos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Editar Archivo</h1>
                <p class="mb-0 text-muted">Modifique la información del archivo</p>
            </div>

            <!-- Información Actual del Archivo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Archivo Actual
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            @if($file->type === 'pdf')
                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                            @elseif($file->type === 'excel')
                                <i class="fas fa-file-excel fa-3x text-success"></i>
                            @else
                                <i class="fas fa-file fa-3x text-secondary"></i>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h5 class="mb-1">{{ $file->name }}</h5>
                            <p class="text-muted mb-1">
                                <span class="badge bg-{{ $file->type === 'pdf' ? 'danger' : ($file->type === 'excel' ? 'success' : 'secondary') }} me-2">
                                    {{ strtoupper($file->type) }}
                                </span>
                                {{ $file->formatted_file_size }} • {{ $file->department }} • {{ $file->responsible_id }}
                            </p>
                            <small class="text-muted">
                                Subido el {{ $file->createdAt->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Edición -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Editar Información
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('files.update', $file->id) }}" id="fileForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Nombre del archivo -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nombre del Archivo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $file->name) }}" 
                                       required 
                                       maxlength="255"
                                       placeholder="Ej: Reporte Mensual Enero">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($file->name !== old('name', $file->name))
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Cambiar el nombre puede afectar las referencias al archivo
                                    </div>
                                @endif
                            </div>

                            <!-- Tipo de archivo -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">
                                    Tipo de Archivo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" 
                                        name="type" 
                                        required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="pdf" {{ old('type', $file->type) === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="excel" {{ old('type', $file->type) === 'excel' ? 'selected' : '' }}>Excel</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($file->type !== old('type', $file->type))
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Cambiar el tipo debe coincidir con el contenido real del archivo
                                    </div>
                                @endif
                            </div>

                            <!-- Departamento -->
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">
                                    Departamento <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('department') is-invalid @enderror" 
                                       id="department" 
                                       name="department" 
                                       value="{{ old('department', $file->department) }}" 
                                       required 
                                       maxlength="100"
                                       placeholder="Ej: Recursos Humanos">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Departamento responsable del archivo
                                </div>
                            </div>

                            <!-- Responsable -->
                            <div class="col-md-6 mb-3">
                                <label for="responsible_id" class="form-label">
                                    ID del Responsable <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('responsible_id') is-invalid @enderror" 
                                       id="responsible_id" 
                                       name="responsible_id" 
                                       value="{{ old('responsible_id', $file->responsible_id) }}" 
                                       required 
                                       maxlength="50"
                                       placeholder="Ej: user123">
                                @error('responsible_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Identificador del usuario responsable
                                </div>
                            </div>

                            <!-- Reemplazar archivo (opcional) -->
                            <div class="col-12 mb-3">
                                <label for="file" class="form-label">
                                    Reemplazar Archivo <span class="text-muted">(Opcional)</span>
                                </label>
                                <input type="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       id="file" 
                                       name="file" 
                                       accept=".pdf,.xlsx,.xls">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('base64')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <strong>Opcional:</strong> Seleccione un nuevo archivo para reemplazar el actual. 
                                    Formatos permitidos: PDF, Excel (.xlsx, .xls). Tamaño máximo: 10MB
                                </div>
                            </div>

                            <!-- Preview del nuevo archivo -->
                            <div class="col-12 mb-3" id="newFilePreview" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Nuevo Archivo Seleccionado
                                        </h6>
                                        <div id="newFileInfo" class="d-flex align-items-center">
                                            <div class="file-icon me-3">
                                                <i id="newFileIcon" class="fas fa-file fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <div id="newFileName" class="fw-bold"></div>
                                                <div id="newFileSize" class="text-muted small"></div>
                                                <div id="newFileType" class="text-muted small"></div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-warning">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Este archivo reemplazará al actual cuando guarde los cambios.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campo oculto para base64 -->
                        <input type="hidden" id="base64" name="base64" value="{{ old('base64') }}">

                        <!-- Información de cambios -->
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Información sobre la edición
                            </h6>
                            <ul class="mb-0">
                                <li>Puede modificar el nombre, tipo, departamento y responsable sin cambiar el archivo.</li>
                                <li>Si selecciona un nuevo archivo, reemplazará completamente al actual.</li>
                                <li>Los cambios se guardarán con la fecha y hora actual.</li>
                                <li>El tamaño actual del archivo es: <strong>{{ $file->formatted_file_size }}</strong></li>
                            </ul>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('files.show', $file->id) }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                                        </a>
                                        <a href="{{ route('files.download', $file->id) }}" class="btn btn-outline-primary ms-2">
                                            <i class="fas fa-download me-2"></i>Descargar Actual
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Guardar Cambios
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

<style>
.file-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.text-danger {
    color: #e74a3b !important;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.btn {
    border-radius: 0.35rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const base64Input = document.getElementById('base64');
    const newFilePreview = document.getElementById('newFilePreview');
    const newFileName = document.getElementById('newFileName');
    const newFileSize = document.getElementById('newFileSize');
    const newFileType = document.getElementById('newFileType');
    const newFileIcon = document.getElementById('newFileIcon');
    const typeSelect = document.getElementById('type');
    const nameInput = document.getElementById('name');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('fileForm');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validar tamaño del archivo (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                fileInput.value = '';
                hideNewFilePreview();
                return;
            }

            // Mostrar información del nuevo archivo
            showNewFilePreview(file);
            
            // Auto-actualizar tipo si es necesario
            autoUpdateType(file);
            
            // Convertir a base64
            convertToBase64(file);
        } else {
            hideNewFilePreview();
            base64Input.value = '';
        }
    });

    function showNewFilePreview(file) {
        newFileName.textContent = file.name;
        newFileSize.textContent = formatFileSize(file.size);
        newFileType.textContent = file.type || 'Tipo desconocido';
        
        // Cambiar icono según el tipo
        if (file.type === 'application/pdf') {
            newFileIcon.className = 'fas fa-file-pdf fa-2x text-danger';
        } else if (file.type.includes('sheet') || file.type.includes('excel')) {
            newFileIcon.className = 'fas fa-file-excel fa-2x text-success';
        } else {
            newFileIcon.className = 'fas fa-file fa-2x text-secondary';
        }
        
        newFilePreview.style.display = 'block';
    }

    function hideNewFilePreview() {
        newFilePreview.style.display = 'none';
    }

    function autoUpdateType(file) {
        // Auto-seleccionar tipo basado en el archivo
        if (file.type === 'application/pdf') {
            typeSelect.value = 'pdf';
        } else if (file.type.includes('sheet') || file.type.includes('excel')) {
            typeSelect.value = 'excel';
        }
    }

    function convertToBase64(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            base64Input.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        // Mostrar estado de carga
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        submitBtn.disabled = true;
        form.classList.add('loading');
    });

    // Validación en tiempo real
    const requiredFields = ['name', 'type', 'department', 'responsible_id'];
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        field.addEventListener('input', validateForm);
        field.addEventListener('change', validateForm);
    });

    function validateForm() {
        const isValid = requiredFields.every(fieldName => {
            const field = document.getElementById(fieldName);
            return field.value.trim() !== '';
        });
        
        submitBtn.disabled = !isValid;
    }

    // Validación inicial
    validateForm();

    // Confirmación si hay cambios sin guardar
    let formChanged = false;
    const formElements = form.querySelectorAll('input, select, textarea');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !form.classList.contains('loading')) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Marcar como guardado al enviar
    form.addEventListener('submit', function() {
        formChanged = false;
    });
});
</script>
@endpush