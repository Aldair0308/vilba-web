@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-reply me-2"></i>
                        Responder Mensaje
                    </h3>
                    <a href="{{ route('contact-messages.show', $contactMessage) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Información del mensaje original -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Mensaje Original</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>De:</strong><br>
                                        {{ $contactMessage->name }}<br>
                                        <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Asunto:</strong><br>
                                        {{ $contactMessage->subject }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Fecha:</strong><br>
                                        {{ $contactMessage->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Mensaje:</strong>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            {{ Str::limit($contactMessage->message, 200) }}
                                            @if(strlen($contactMessage->message) > 200)
                                                <br><small class="text-muted">...</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de respuesta -->
                        <div class="col-md-8">
                            <form action="{{ route('contact-messages.send-reply', $contactMessage) }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">
                                        <i class="fas fa-tag me-1"></i>
                                        Asunto de la respuesta
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" 
                                           name="subject" 
                                           value="{{ old('subject', 'Re: ' . $contactMessage->subject) }}" 
                                           required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reply_message" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Mensaje de respuesta
                                    </label>
                                    <textarea class="form-control @error('reply_message') is-invalid @enderror" 
                                              id="reply_message" 
                                              name="reply_message" 
                                              rows="12" 
                                              required 
                                              placeholder="Escribe tu respuesta aquí...">{{ old('reply_message', "Estimado/a {$contactMessage->name},\n\nGracias por contactarnos. \n\n\n\nSaludos cordiales,\nEquipo de Vilba Construcción") }}</textarea>
                                    @error('reply_message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Vista previa del email -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-eye me-1"></i>
                                            Vista Previa del Email
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="email-preview">
                                            <div class="mb-2">
                                                <strong>Para:</strong> {{ $contactMessage->email }} ({{ $contactMessage->name }})
                                            </div>
                                            <div class="mb-2">
                                                <strong>De:</strong> {{ config('mail.from.address') }} ({{ config('mail.from.name') }})
                                            </div>
                                            <div class="mb-3">
                                                <strong>Asunto:</strong> <span id="preview-subject">Re: {{ $contactMessage->subject }}</span>
                                            </div>
                                            <div class="border p-3 bg-light">
                                                <div id="preview-message">
                                                    Estimado/a {{ $contactMessage->name }},<br><br>
                                                    Gracias por contactarnos.<br><br><br><br>
                                                    Saludos cordiales,<br>
                                                    Equipo de Vilba Construcción
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('contact-messages.show', $contactMessage) }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Enviar Respuesta
                                    </button>
                                </div>
                            </form>
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
    const subjectInput = document.getElementById('subject');
    const messageTextarea = document.getElementById('reply_message');
    const previewSubject = document.getElementById('preview-subject');
    const previewMessage = document.getElementById('preview-message');

    // Actualizar vista previa del asunto
    subjectInput.addEventListener('input', function() {
        previewSubject.textContent = this.value || 'Re: {{ $contactMessage->subject }}';
    });

    // Actualizar vista previa del mensaje
    messageTextarea.addEventListener('input', function() {
        const message = this.value || 'Estimado/a {{ $contactMessage->name }},\n\nGracias por contactarnos.\n\n\n\nSaludos cordiales,\nEquipo de Vilba Construcción';
        previewMessage.innerHTML = message.replace(/\n/g, '<br>');
    });

    // Confirmar antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('¿Estás seguro de enviar esta respuesta? Se enviará inmediatamente al cliente.')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.email-preview {
    font-family: Arial, sans-serif;
}

.email-preview .border {
    min-height: 200px;
}

#preview-message {
    white-space: pre-line;
}
</style>
@endpush