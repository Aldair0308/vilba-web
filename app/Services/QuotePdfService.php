<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Crane;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QuotePdfService
{
    /**
     * Generar PDF de cotización
     */
    public function generateQuotePdf(Quote $quote)
    {
        try {
            // Cargar relaciones necesarias
            $quote->load(['client', 'responsible']);
            
            // Obtener detalles de las grúas
            $craneDetails = $this->getCraneDetails($quote->cranes);
            
            // Calcular totales
            $calculations = $this->calculateTotals($quote->cranes, $quote->iva ?? 16);
            
            // Generar número de cotización único
            $quoteNumber = $this->generateQuoteNumber($quote);
            
            // Preparar datos para la vista
            $data = [
                'quote' => $quote,
                'client' => $quote->client,
                'responsible' => $quote->responsible,
                'craneDetails' => $craneDetails,
                'calculations' => $calculations,
                'quoteNumber' => $quoteNumber,
                'date' => Carbon::now()->format('d/m/Y'),
                'companyInfo' => $this->getCompanyInfo()
            ];
            
            // Generar PDF
            $pdf = Pdf::loadView('quotes.pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf;
            
        } catch (\Exception $e) {
            Log::error('Error generando PDF de cotización: ' . $e->getMessage());
            throw new \Exception('Error al generar el PDF de la cotización');
        }
    }
    
    /**
     * Obtener detalles de las grúas
     */
    private function getCraneDetails($cranes)
    {
        $details = [];
        
        foreach ($cranes as $craneData) {
            $crane = Crane::find($craneData['crane']);
            if ($crane) {
                $details[] = [
                    'crane' => $crane,
                    'dias' => $craneData['dias'],
                    'precio' => $craneData['precio'],
                    'subtotal' => $craneData['dias'] * $craneData['precio']
                ];
            }
        }
        
        return $details;
    }
    
    /**
     * Calcular totales de la cotización
     */
    private function calculateTotals($cranes, $ivaPercentage = 16)
    {
        $subtotal = 0;
        
        foreach ($cranes as $craneData) {
            $subtotal += $craneData['dias'] * $craneData['precio'];
        }
        
        $iva = $subtotal * ($ivaPercentage / 100);
        $total = $subtotal + $iva;
        
        return [
            'subtotal' => $subtotal,
            'iva_percentage' => $ivaPercentage,
            'iva_amount' => $iva,
            'total' => $total
        ];
    }
    
    /**
     * Generar número de cotización único
     */
    private function generateQuoteNumber(Quote $quote)
    {
        $date = Carbon::parse($quote->createdAt);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        
        // Formato: COT-YYYYMMDD-XXX (donde XXX es un número secuencial)
        $prefix = config('pdf.quote.prefix', 'COT');
        $baseNumber = "{$prefix}-{$year}{$month}{$day}";
        
        // Obtener el último número del día
        $lastQuote = Quote::where('createdAt', '>=', $date->startOfDay())
                         ->where('createdAt', '<=', $date->endOfDay())
                         ->where('_id', '!=', $quote->_id)
                         ->count();
        
        $sequence = str_pad($lastQuote + 1, 3, '0', STR_PAD_LEFT);
        
        return "{$baseNumber}-{$sequence}";
    }
    
    /**
     * Obtener información de la empresa
     */
    private function getCompanyInfo()
    {
        return config('pdf.company', [
            'name' => 'VILBA',
            'logo' => public_path('images/logo-vilba.png'), // Asegúrate de tener el logo
            'address' => 'Dirección de la empresa',
            'phone' => 'Teléfono de contacto',
            'email' => 'contacto@vilba.com',
            'website' => 'www.vilba.com'
        ]);
    }
    
    /**
     * Generar PDF para múltiples cotizaciones
     */
    public function generateBulkQuotePdf($quoteIds)
    {
        try {
            $quotes = Quote::whereIn('_id', $quoteIds)
                          ->with(['client', 'responsible'])
                          ->get();
            
            $quotesData = [];
            
            foreach ($quotes as $quote) {
                $craneDetails = $this->getCraneDetails($quote->cranes);
                $calculations = $this->calculateTotals($quote->cranes, $quote->iva ?? 16);
                $quoteNumber = $this->generateQuoteNumber($quote);
                
                $quotesData[] = [
                    'quote' => $quote,
                    'client' => $quote->client,
                    'responsible' => $quote->responsible,
                    'craneDetails' => $craneDetails,
                    'calculations' => $calculations,
                    'quoteNumber' => $quoteNumber
                ];
            }
            
            $data = [
                'quotes' => $quotesData,
                'date' => Carbon::now()->format('d/m/Y'),
                'companyInfo' => $this->getCompanyInfo()
            ];
            
            $pdf = Pdf::loadView('quotes.bulk-pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf;
            
        } catch (\Exception $e) {
            Log::error('Error generando PDF masivo de cotizaciones: ' . $e->getMessage());
            throw new \Exception('Error al generar el PDF de las cotizaciones');
        }
    }
}