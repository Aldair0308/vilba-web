<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $quoteNumber }}</title>
    <style>
        :root {
            --primary-color: {{ config('pdf.colors.primary', '#FF6B35') }};
            --secondary-color: {{ config('pdf.colors.secondary', '#333333') }};
            --accent-color: {{ config('pdf.colors.accent', '#F8F9FA') }};
            --text-color: {{ config('pdf.colors.text', '#212529') }};
            --muted-color: {{ config('pdf.colors.muted', '#6C757D') }};
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ff6b35;
            padding-bottom: 20px;
        }
        
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #ff6b35;
            font-style: italic;
            margin-bottom: 10px;
        }
        
        .quote-title {
            font-size: 18px;
            font-weight: bold;
            color: #ff6b35;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .quote-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .quote-number {
            text-align: right;
        }
        
        .quote-number strong {
            color: #333;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background-color: #ff6b35;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            margin-bottom: 15px;
        }
        
        .client-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #ff6b35;
        }
        
        .client-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .client-label {
            font-weight: bold;
            color: #ff6b35;
            width: 120px;
            flex-shrink: 0;
        }
        
        .client-value {
            flex: 1;
        }
        
        .project-description {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #ff6b35;
            min-height: 60px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th {
            background-color: #ff6b35;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        .items-table td {
            padding: 10px 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .description-cell {
            text-align: left !important;
            max-width: 200px;
        }
        
        .totals-section {
            margin-top: 20px;
        }
        
        .totals-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .totals-table .label {
            font-weight: bold;
            text-align: right;
            background-color: #f8f9fa;
        }
        
        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #ff6b35 !important;
            color: white !important;
        }
        
        .total-row td {
            font-size: 14px;
            font-weight: bold;
        }
        
        .terms-section {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #ff6b35;
        }
        
        .terms-list {
            list-style: none;
            counter-reset: term-counter;
        }
        
        .terms-list li {
            counter-increment: term-counter;
            margin-bottom: 8px;
            position: relative;
            padding-left: 25px;
        }
        
        .terms-list li::before {
            content: counter(term-counter) ".";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #ff6b35;
        }
        
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-label {
            border-top: 1px solid var(--secondary-color);
            padding-top: 5px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .signature-sublabel {
            font-size: 12px;
            color: var(--muted-color);
        }

        .footer-text {
            text-align: center;
            font-style: italic;
            color: var(--muted-color);
            margin-top: 20px;
        }
        
        .currency {
            font-weight: bold;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        @media print {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Vilba</div>
            <div class="quote-title">Cotización</div>
        </div>
        
        <!-- Quote Info -->
        <div class="quote-info">
            <div>
                <strong>Fecha:</strong> {{ $date }}
            </div>
            <div class="quote-number">
                <strong>N°:</strong> {{ $quoteNumber }}
            </div>
        </div>
        
        <!-- Client Data -->
        <div class="section">
            <div class="section-title">Datos del Cliente</div>
            <div class="client-info">
                <div class="client-row">
                    <div class="client-label">Nombre/Razón Social:</div>
                    <div class="client-value">{{ $client->name ?? 'N/A' }}</div>
                </div>
                <div class="client-row">
                    <div class="client-label">RFC/CURP:</div>
                    <div class="client-value">{{ $client->rfc ?? 'N/A' }}</div>
                </div>
                <div class="client-row">
                    <div class="client-label">Dirección:</div>
                    <div class="client-value">{{ $client->address ?? 'N/A' }}</div>
                </div>
                <div class="client-row">
                    <div class="client-label">Teléfono:</div>
                    <div class="client-value">{{ $client->phone ?? 'N/A' }}</div>
                </div>
                <div class="client-row">
                    <div class="client-label">Email:</div>
                    <div class="client-value">{{ $client->email ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Project Description -->
        <div class="section">
            <div class="section-title">Descripción del Proyecto</div>
            <div class="project-description">
                <strong>Proyecto:</strong> {{ $quote->name }}<br>
                <strong>Zona:</strong> {{ $quote->zone }}<br>
                @if($quote->responsible)
                <strong>Responsable:</strong> {{ $quote->responsible->name }}
                @endif
            </div>
        </div>
        
        <!-- Items Detail -->
        <div class="section">
            <div class="section-title">Detalle de Items</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">Item</th>
                        <th style="width: 40%;">Descripción</th>
                        <th style="width: 12%;">Cantidad</th>
                        <th style="width: 12%;">Unidad</th>
                        <th style="width: 14%;">P. Unitario</th>
                        <th style="width: 14%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($craneDetails as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="description-cell">
                            <strong>{{ $detail['crane']->nombre }}</strong><br>
                            {{ $detail['crane']->marca }} {{ $detail['crane']->modelo }}<br>
                            Capacidad: {{ $detail['crane']->capacidad }} Ton<br>
                            Tipo: {{ ucfirst($detail['crane']->tipo) }}
                        </td>
                        <td>{{ $detail['dias'] }}</td>
                        <td>Días</td>
                        <td class="currency">${{ number_format($detail['precio'], 2) }}</td>
                        <td class="currency">${{ number_format($detail['subtotal'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value currency">${{ number_format($calculations['subtotal'], 2) }}</td>
                </tr>
                <tr>
                    <td class="label">IVA ({{ $calculations['iva_percentage'] }}%):</td>
                    <td class="value currency">${{ number_format($calculations['iva_amount'], 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">TOTAL:</td>
                    <td class="value currency">${{ number_format($calculations['total'], 2) }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Terms and Conditions -->
        <div class="section">
            <div class="section-title">Términos y Condiciones</div>
            <div class="terms-section">
                <ol class="terms-list">
                    @foreach(config('pdf.quote.terms_and_conditions', [
                        'Vigencia de la cotización: 30 días.',
                        'Los precios están sujetos a cambios sin previo aviso.',
                        'Tiempo de entrega: 15 días hábiles.',
                        'Garantía: 1 mes.',
                        'El precio incluye IVA.'
                    ]) as $term)
                        <li>{{ $term }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
        
        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-line">
                <div class="signature-box">
                    <div class="signature-label">Firma del Cliente</div>
                </div>
                <div class="signature-box">
                    <div class="signature-label">{{ config('pdf.company.name', 'VILBA') }}</div>
                    <div class="signature-sublabel">Administración</div>
                </div>
            </div>
            <div class="footer-text">
                {{ config('pdf.quote.footer_text', 'Gracias por su preferencia') }}
            </div>
        </div>
    </div>
</body>
</html>