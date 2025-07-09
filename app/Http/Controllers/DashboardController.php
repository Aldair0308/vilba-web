<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Crane;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener estadísticas básicas
        $totalClients = Client::count();
        $availableEquipment = Crane::where('status', 'available')->count();
        $activeQuotes = Quote::where('status', 'pending')->count();
        $rentedEquipment = Crane::where('status', 'rented')->count();
        
        // Estadísticas adicionales
        $totalEquipment = Crane::count();
        $totalQuotes = Quote::count();
        $totalUsers = User::count();
        
        // Equipos por estado
        $equipmentByStatus = [
            'available' => Crane::where('status', 'available')->count(),
            'rented' => Crane::where('status', 'rented')->count(),
            'maintenance' => Crane::where('status', 'maintenance')->count(),
            'inactive' => Crane::where('status', 'inactive')->count(),
        ];
        
        // Cotizaciones por estado
        $quotesByStatus = [
            'pending' => Quote::where('status', 'pending')->count(),
            'approved' => Quote::where('status', 'approved')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
            'expired' => Quote::where('status', 'expired')->count(),
        ];
        
        // Clientes activos vs inactivos
        $clientsByStatus = [
            'active' => Client::where('status', 'active')->count(),
            'inactive' => Client::where('status', 'inactive')->count(),
        ];
        
        return view('dashboard', compact(
            'totalClients',
            'availableEquipment', 
            'activeQuotes',
            'rentedEquipment',
            'totalEquipment',
            'totalQuotes',
            'totalUsers',
            'equipmentByStatus',
            'quotesByStatus',
            'clientsByStatus'
        ));
    }
    
    /**
     * Get dashboard statistics via API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        $stats = [
            'clients' => [
                'total' => Client::count(),
                'active' => Client::where('status', 'active')->count(),
                'inactive' => Client::where('status', 'inactive')->count(),
            ],
            'equipment' => [
                'total' => Crane::count(),
                'available' => Crane::where('status', 'available')->count(),
                'rented' => Crane::where('status', 'rented')->count(),
                'maintenance' => Crane::where('status', 'maintenance')->count(),
                'inactive' => Crane::where('status', 'inactive')->count(),
            ],
            'quotes' => [
                'total' => Quote::count(),
                'pending' => Quote::where('status', 'pending')->count(),
                'approved' => Quote::where('status', 'approved')->count(),
                'rejected' => Quote::where('status', 'rejected')->count(),
                'expired' => Quote::where('status', 'expired')->count(),
            ],
            'users' => [
                'total' => User::count(),
            ]
        ];
        
        return response()->json($stats);
    }
}