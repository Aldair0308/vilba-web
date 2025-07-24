@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-envelope-open me-2"></i>
                        Mensaje de Contacto
                    </h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('contact-messages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                        @if($contactMessage->status !== 'replied')
                            <a href="{{ route('contact-messages.reply', $contactMessage) }}" class="btn btn-success">
                                <i class="fas fa-reply me-1"></i>
                                Responder
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Información del remitente -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user me-2"></i>
                                        Información del Remitente
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Nombre:</strong><br>
                                        {{ $contactMessage->name }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email:</strong><br>
                                        <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                                    </div>
                                    @if($contactMessage->phone)
                                        <div class="mb-3">
                                            <strong>Teléfono:</strong><br>
                                            <a href="tel:{{ $contactMessage->phone }}">{{ $contactMessage->phone }}</a>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <strong>Estado:</strong><br>
                                        <span class="badge bg-{{ 
                                            $contactMessage->status === 'pending' ? 'warning' : 
                                            ($contactMessage->status === 'read' ? 'info' : 
                                            ($contactMessage->status === 'replied' ? 'success' : 'secondary')) 
                                        }}">
                                            {{ $contactMessage->getStatusInSpanish() }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Fecha de envío:</strong><br>
                                        {{ $contactMessage->created_at->format('d/m/Y H:i:s') }}<br>
                                        <small class="text-muted">{{ $contactMessage->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($contactMessage->replied_at)
                                        <div class="mb-3">
                                            <strong>Respondido el:</strong><br>
                                            {{ $contactMessage->replied_at->format('d/m/Y H:i:s') }}<br>
                                            <small class="text-muted">por {{ $contactMessage->replied_by }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Acciones rápidas -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Acciones Rápidas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($contactMessage->status === 'pending')
                                            <button class="btn btn-info btn-sm" onclick="updateStatus('read')">
                                                <i class="fas fa-eye me-1"></i>
                                                Marcar como leído
                                            </button>
                                        @endif
                                        @if($contactMessage->status !== 'archived')
                                            <button class="btn btn-secondary btn-sm" onclick="updateStatus('archived')">
                                                <i class="fas fa-archive me-1"></i>
                                                Archivar
                                            </button>
                                        @endif
                                        <button class="btn btn-danger btn-sm" onclick="deleteMessage()">
                                            <i class="fas fa-trash me-1"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido del mensaje -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-envelope me-2"></i>
                                        {{ $contactMessage->subject }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="message-content">
                                        {!! nl2br(e($contactMessage->message)) !!}
                                    </div>
                                </div>
                            </div>

                            @if($contactMessage->reply_message)
                                <div class="card mt-3 border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-reply me-2"></i>
                                            Respuesta Enviada
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                Respondido el {{ $contactMessage->replied_at->format('d/m/Y H:i:s') }} 
                                                por {{ $contactMessage->replied_by }}
                                            </small>
                                        </div>
                                        <div class="reply-content">
                                            {!! nl2br(e($contactMessage->reply_message)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.message-content {
    font-size: 1.1rem;
    line-height: 1.6;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    border-left: 4px solid #007bff;
}

.reply-content {
    font-size: 1rem;
    line-height: 1.5;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    border-left: 4px solid #28a745;
}
</style>
@endpush

@push('scripts')
<script>
function updateStatus(status) {
    if (confirm('¿Estás seguro de cambiar el estado de este mensaje?')) {
        fetch(`/contact-messages/{{ $contactMessage->id }}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el estado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar el estado');
        });
    }
}

function deleteMessage() {
    if (confirm('¿Estás seguro de eliminar este mensaje? Esta acción no se puede deshacer.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/contact-messages/{{ $contactMessage->id }}`;
        form.innerHTML = `
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush