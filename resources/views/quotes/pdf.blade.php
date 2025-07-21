<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cotización</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: rgb(196, 88, 16);
            --secondary-color: rgb(221, 116, 29);
            --accent-color: rgb(216, 122, 45);
            --text-color: #333;
            --border-color: #e0e0e0;
            --background-color: #ffffff;
            --table-header-bg: #f5f5f5;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 10px;
            color: var(--text-color);
            line-height: 1.2;
            background-color: var(--background-color);
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid var(--primary-color);
        }

        .logo {
            max-width: 120px;
            max-height: 60px;
            width: auto;
            height: auto;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .logo-placeholder {
            width: 120px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FF6B35;
            border-radius: 5px;
        }

        .header h2 {
            color: var(--primary-color);
            font-weight: 500;
            margin: 0;
            font-size: 14px;
        }

        .content {
            background: var(--background-color);
            padding: 30px;
            padding-top: 0px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .quotation-info {
            margin-bottom: 20px;
            text-align: center;
        }

        .quotation-info h3 {
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
            margin-top: 5px;
            text-transform: uppercase;
        }

        .quotation-number, .quotation-date {
            text-align: right;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .quotation-number label, .quotation-date label {
            font-weight: 500;
            margin-right: 15px;
            color: var(--secondary-color);
        }

        .quotation-number span, .quotation-date span {
            color: var(--text-color);
        }

        .client-info, .project-info, .items-table, .terms-conditions {
            margin-bottom: 10px;
            padding: 8px;
            background: #fafafa;
            border-radius: 4px;
        }

        .client-info h4, .project-info h4, .items-table h4, .terms-conditions h4 {
            color: var(--primary-color);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--accent-color);
        }

        .client-details div {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .client-details label {
            font-weight: 500;
            min-width: 180px;
            color: var(--secondary-color);
        }

        .project-description p {
            margin: 0;
            padding: 15px;
            background: white;
            border-radius: 4px;
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            font-size: 11px;
            color: var(--text-color);
            border: 1px solid var(--border-color);
            min-height: 40px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
        }

        th, td {
            padding: 5px 8px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 9px;
        }

        th {
            background-color: var(--table-header-bg);
            color: var(--primary-color);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .total-label {
            text-align: right;
            font-weight: 500;
            color: var(--secondary-color);
        }

        .total-value {
            font-weight: 700;
            color: var(--primary-color);
        }

        .terms-conditions ol {
            padding-left: 12px;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .terms-conditions li {
            margin-bottom: 5px;
            font-size: 9px;
            color: var(--text-color);
        }

        .signature {
            margin-top: 5px;
            text-align: right;
        }

        .signature-line {
            width: 200px;
            border-top: 2px solid var(--primary-color);
            margin-left: auto;
            margin-bottom: 8px;
        }

        .signature p {
            margin: 5px 0;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 12px;
            color: var(--text-color);
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        @php
            $logoPath = public_path('assets/img/logo/Vilba-logo.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        @endphp
        @if($logoBase64)
            <img class="logo" src="{{ $logoBase64 }}" />
        @else
            <div class="logo-placeholder">
                <h2 style="color: #FF6B35; margin: 0;">VILBA</h2>
            </div>
        @endif
    </div>

    <div class="content">
        <div class="quotation-info">
            <h3>COTIZACIÓN</h3>
            <div class="quotation-number">
                <label>N°:</label>
                <span>{{ $quote->name ?? 'N/A' }}</span>
            </div>
            <div class="quotation-date">
                <label>Fecha:</label>
                <span>{{ $quote->created_at ? $quote->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
            </div>
        </div>

        <div class="client-info">
            <h4>DATOS DEL CLIENTE</h4>
            <div class="client-details">
                <div>
                    <label>Nombre/Razón Social:</label>
                    <span>{{ $quote->client->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <label>RFC:</label>
                    <span>{{ $quote->client->rfc ?? 'N/A' }}</span>
                </div>
                <div>
                    <label>Dirección:</label>
                    <span>{{ $quote->client->address ?? 'N/A' }}</span>
                </div>
                <div>
                    <label>Teléfono:</label>
                    <span>{{ $quote->client->phone ?? 'N/A' }}</span>
                </div>
                <div>
                    <label>Email:</label>
                    <span>{{ $quote->client->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="project-info">
            <h4>DESCRIPCIÓN DEL PROYECTO</h4>
            <div class="project-description">
                <p>{{ $quote->description ?? 'Sin descripción' }}</p>
            </div>
        </div>

        <div class="items-table">
            <h4>DETALLE DE ITEMS</h4>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>

                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>P. Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($quote->crane_details) && is_array($quote->crane_details))
                        @foreach($quote->crane_details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if(isset($detail['crane_info']) && $detail['crane_info'])
                                        {{ $detail['crane_info']['nombre'] ?? 'Grúa' }}
                                        <br><small>{{ $detail['crane_info']['marca'] ?? '' }} {{ $detail['crane_info']['modelo'] ?? '' }}</small>
                                    @else
                                        Grúa
                                    @endif
                                </td>

                                <td>{{ $detail['dias'] ?? 1 }}</td>
                                <td>Días</td>
                                <td>S/ {{ number_format($detail['precio'] ?? 0, 2) }}</td>
                                <td>S/ {{ number_format($detail['subtotal'] ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay items disponibles</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="total-label">SUBTOTAL</td>
                        <td class="total-value">S/ {{ number_format($quote->subtotal ?? 0, 2) }}</td>
                    </tr>
                    @if($quote->include_iva ?? true)
                    <tr>
                        <td colspan="5" class="total-label">IVA ({{ $quote->iva ?? 18 }}%)</td>
                        <td class="total-value">S/ {{ number_format($quote->iva_amount ?? 0, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="total-label">TOTAL</td>
                        <td class="total-value">S/ {{ number_format($quote->calculated_total ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="terms-conditions">
            <h4>TÉRMINOS Y CONDICIONES</h4>
            <ol>
                <li>Validez de la cotización: 15 días.</li>
                <li>Forma de pago: 50% adelanto, 50% contraentrega.</li>
                <li>Tiempo de entrega: 7 días hábiles.</li>
                <li>Garantía: 1 mes.</li>
                @if($quote->include_iva ?? true)
                    <li>El precio incluye IVA.</li>
                @else
                    <li>El precio NO incluye IVA.</li>
                @endif
            </ol>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <p>{{ $quote->responsible->name ?? 'Responsable' }}</p>
            <p>Representante de Ventas</p>
        </div>
    </div>

    <div class="footer">
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>
</body>
</html>
