@extends('layouts.app')

@section('title', 'Nuevo Archivo')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('files.index') }}">Archivos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo Archivo</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800">Subir Nuevo Archivo</h1>
                <p class="mb-0 text-muted">Suba un nuevo archivo al sistema</p>
            </div>

            <!-- Formulario -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-upload me-2"></i>Información del Archivo
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('files.store') }}" id="fileForm" enctype="multipart/form-data">
                        @csrf
                        
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
                                       value="{{ old('name') }}" 
                                       required 
                                       maxlength="255"
                                       placeholder="Ej: Reporte Mensual Enero">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                    <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="excel" {{ old('type') === 'excel' ? 'selected' : '' }}>Excel</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('department') }}" 
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
                                       value="{{ old('responsible_id') }}" 
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

                            <!-- Archivo -->
                            <div class="col-12 mb-3">
                                <label for="file" class="form-label">
                                    Seleccionar Archivo <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       id="file" 
                                       name="file" 
                                       required 
                                       accept=".pdf,.xlsx,.xls">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('base64')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Formatos permitidos: PDF, Excel (.xlsx, .xls). Tamaño máximo: 10MB
                                </div>
                            </div>

                            <!-- Preview del archivo -->
                            <div class="col-12 mb-3" id="filePreview" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Vista Previa del Archivo</h6>
                                        <div id="fileInfo" class="d-flex align-items-center">
                                            <div class="file-icon me-3">
                                                <i id="fileIcon" class="fas fa-file fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <div id="fileName" class="fw-bold"></div>
                                                <div id="fileSize" class="text-muted small"></div>
                                                <div id="fileType" class="text-muted small"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campo oculto para base64 -->
                        <input type="hidden" id="base64" name="base64" value="{{ old('base64') }}">

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('files.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Guardar Archivo
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
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const base64Input = document.getElementById('base64');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileType = document.getElementById('fileType');
    const fileIcon = document.getElementById('fileIcon');
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
                hidePreview();
                return;
            }

            // Mostrar información del archivo
            showFilePreview(file);
            
            // Auto-completar campos
            autoFillFields(file);
            
            // Convertir a base64
            convertToBase64(file);
        } else {
            hidePreview();
            base64Input.value = '';
        }
    });

    function showFilePreview(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileType.textContent = file.type || 'Tipo desconocido';
        
        // Cambiar icono según el tipo
        if (file.type === 'application/pdf') {
            fileIcon.className = 'fas fa-file-pdf fa-2x text-danger';
        } else if (file.type.includes('sheet') || file.type.includes('excel')) {
            fileIcon.className = 'fas fa-file-excel fa-2x text-success';
        } else {
            fileIcon.className = 'fas fa-file fa-2x text-secondary';
        }
        
        filePreview.style.display = 'block';
    }

    function hidePreview() {
        filePreview.style.display = 'none';
    }

    function autoFillFields(file) {
        // Auto-completar nombre si está vacío
        if (!nameInput.value) {
            const nameWithoutExtension = file.name.replace(/\.[^/.]+$/, "");
            nameInput.value = nameWithoutExtension;
        }
        
        // Auto-seleccionar tipo
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
        if (!base64Input.value) {
            e.preventDefault();
            alert('Por favor seleccione un archivo.');
            return;
        }
        
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
        }) && fileInput.files.length > 0;
        
        submitBtn.disabled = !isValid;
    }

    // Validación inicial
    validateForm();
});
</script>
@endpush