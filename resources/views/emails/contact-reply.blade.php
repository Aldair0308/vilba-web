<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a tu consulta - Vilba Construcción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .tagline {
            color: #666;
            font-size: 14px;
        }
        .greeting {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 20px;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
            border-radius: 5px;
        }
        .original-message {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #6c757d;
        }
        .original-message h4 {
            margin-top: 0;
            color: #495057;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .contact-info h4 {
            margin-top: 0;
            color: #007bff;
        }
        .signature {
            margin-top: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">VILBA CONSTRUCCIÓN</div>
            <div class="tagline">Construyendo el futuro juntos</div>
        </div>

        <div class="greeting">
            Estimado/a {{ $contactMessage->name }},
        </div>

        <p>Gracias por contactarnos a través de nuestro sitio web. Hemos recibido tu mensaje y queremos responder a tu consulta.</p>

        <div class="original-message">
            <h4>Tu mensaje original:</h4>
            <p><strong>Asunto:</strong> {{ $contactMessage->subject }}</p>
            <p><strong>Fecha:</strong> {{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{{ $contactMessage->message }}</p>
        </div>

        <div class="message-content">
            <h4>Nuestra respuesta:</h4>
            {!! nl2br(e($replyMessage)) !!}
        </div>

        <div class="contact-info">
            <h4>Información de contacto</h4>
            <p>
                <strong>Teléfono:</strong> +52 55 5555 5555<br>
                <strong>Email:</strong> contacto@vilbaconstruccion.com<br>
                <strong>Sitio web:</strong> www.vilbaconstruccion.com
            </p>
        </div>

        <div class="signature">
            <p><strong>Equipo de Vilba Construcción</strong></p>
            <p>Construyendo el futuro juntos</p>
        </div>

        <div class="footer">
            <p>Este email fue enviado en respuesta a tu consulta del {{ $contactMessage->created_at->format('d/m/Y') }}.</p>
            <p>Si tienes más preguntas, no dudes en contactarnos.</p>
            <p>&copy; {{ date('Y') }} Vilba Construcción. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>