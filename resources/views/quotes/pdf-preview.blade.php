<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cotización - Vista Previa</title>
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
            max-width: 150px;
            margin-bottom: 15px;
            width: 100%;
            height: auto;
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
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .quotation-number label, .quotation-date label {
            font-weight: 500;
            margin-right: 15px;
            color: var(--secondary-color);
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
            padding: 10px;
            background: white;
            border-radius: 4px;
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
        <img class="logo" src="{{ asset('assets/img/logo/Vilba-logo.png') }}" />
    </div>

    <div class="content">
        <div class="quotation-info">
            <h3>COTIZACIÓN</h3>
            <div class="quotation-number">
                <label>N°:</label>
                <span id="preview-quote-number">001</span>
            </div>
            <div class="quotation-date">
                <label>Fecha:</label>
                <span id="preview-quote-date"></span>
            </div>
        </div>

        <div class="client-info">
            <h4>DATOS DEL CLIENTE</h4>
            <div class="client-details">
                <div>
                    <label>Nombre/Razón Social:</label>
                    <span id="preview-client-name">Seleccionar cliente</span>
                </div>
                <div>
                    <label>RFC:</label>
                    <span id="previewClientRfc">N/A</span>
                </div>
                <div>
                    <label>Dirección:</label>
                    <span id="preview-client-address">-</span>
                </div>
                <div>
                    <label>Teléfono:</label>
                    <span id="preview-client-phone">-</span>
                </div>
                <div>
                    <label>Email:</label>
                    <span id="preview-client-email">-</span>
                </div>
            </div>
        </div>

        <div class="project-info">
            <h4>DESCRIPCIÓN DEL PROYECTO</h4>
            <div class="project-description">
                <p id="preview-description">Descripción del proyecto...</p>
            </div>
        </div>

        <div class="items-table">
            <h4>DETALLE DE ITEMS</h4>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>Zona</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>P. Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="preview-items">
                    <tr>
                        <td colspan="7" style="text-align: center;">No hay items agregados</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="total-label">SUBTOTAL</td>
                        <td class="total-value" id="preview-subtotal">MXN 0.00</td>
                    </tr>
                    <tr id="preview-iva-row">
                        <td colspan="6" class="total-label">IVA (<span id="preview-iva-rate">18</span>%)</td>
                        <td class="total-value" id="preview-iva">MXN 0.00</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="total-label">TOTAL</td>
                        <td class="total-value" id="preview-total">MXN 0.00</td>
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
                <li id="preview-iva-terms">El precio incluye IVA.</li>
            </ol>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <p id="preview-responsible">Responsable</p>
            <p>Representante de Ventas</p>
        </div>
    </div>

    <div class="footer">
        <p>Generado el <span id="preview-generated-date"></span></p>
    </div>

    <script>
        // Set current date
        document.getElementById('preview-quote-date').textContent = new Date().toLocaleDateString('es-PE');
        document.getElementById('preview-generated-date').textContent = new Date().toLocaleDateString('es-PE') + ' ' + new Date().toLocaleTimeString('es-PE');
    </script>
</body>
</html>
