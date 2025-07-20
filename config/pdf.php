<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PDF Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for PDF generation in the
    | application, including company information and PDF settings.
    |
    */

    'company' => [
        'name' => env('COMPANY_NAME', 'VILBA'),
        'logo' => env('COMPANY_LOGO', '/images/logo.png'),
        'address' => env('COMPANY_ADDRESS', 'Dirección de la empresa'),
        'phone' => env('COMPANY_PHONE', '+52 (xxx) xxx-xxxx'),
        'email' => env('COMPANY_EMAIL', 'contacto@vilba.com'),
        'website' => env('COMPANY_WEBSITE', 'www.vilba.com'),
        'rfc' => env('COMPANY_RFC', 'RFC123456789'),
    ],

    'quote' => [
        'prefix' => env('QUOTE_PREFIX', 'COT'),
        'terms_and_conditions' => [
            'Vigencia de la cotización: 30 días.',
            'Los precios están sujetos a cambios sin previo aviso.',
            'Tiempo de entrega: 15 días hábiles.',
            'Garantía: 1 mes.',
            'El precio incluye IVA.',
        ],
        'footer_text' => env('QUOTE_FOOTER_TEXT', 'Gracias por su preferencia'),
    ],

    'pdf' => [
        'format' => 'A4',
        'orientation' => 'portrait',
        'margin' => [
            'top' => 15,
            'right' => 15,
            'bottom' => 15,
            'left' => 15,
        ],
        'font_size' => 12,
        'font_family' => 'Arial, sans-serif',
    ],

    'colors' => [
        'primary' => '#FF6B35', // Color naranja de VILBA
        'secondary' => '#333333',
        'accent' => '#F8F9FA',
        'text' => '#212529',
        'muted' => '#6C757D',
    ],
];