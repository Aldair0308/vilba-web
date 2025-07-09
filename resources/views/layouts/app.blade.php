<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Internationalization CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/i18n.css') }}">
    
    <!-- Custom Brand Colors CSS -->
    <style>
        :root {
            --brand-navy: #1e3a8a;
            --brand-orange: #f97316;
            --brand-navy-dark: #1e40af;
            --brand-orange-light: #fb923c;
            --brand-orange-dark: #ea580c;
        }
        
        /* Navigation Styles */
        .navbar-brand-custom {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%);
            color: var(--brand-orange) !important;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
        }
        
        .navbar-brand-custom:hover {
            color: var(--brand-orange-light) !important;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover, .nav-link:focus {
            color: var(--brand-orange) !important;
        }
        
        .nav-link.active {
            color: var(--brand-orange) !important;
            font-weight: 500;
        }
        
        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-orange) 0%, var(--brand-orange-dark) 100%);
            border-color: var(--brand-orange);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--brand-orange-dark) 0%, var(--brand-orange) 100%);
            border-color: var(--brand-orange-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(249, 115, 22, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--brand-orange);
            border-color: var(--brand-orange);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--brand-orange);
            border-color: var(--brand-orange);
        }
        
        /* Card and Content Styles */
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%);
            color: white;
            border-bottom: 2px solid var(--brand-orange);
        }
        
        .bg-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        }
        
        /* Table Styles */
        .table thead th {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%);
            color: white;
            border: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(249, 115, 22, 0.05);
        }
        
        /* Alert Styles */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
            color: #065f46;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #ef4444;
            color: #991b1b;
        }
        
        /* Form Styles */
        .form-control:focus {
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25);
        }
        
        .form-select:focus {
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25);
        }
        
        /* Badge Styles */
        .badge {
            font-weight: 500;
        }
        
        .text-primary {
            color: var(--brand-orange) !important;
        }
        
        /* Background Styles */
        .bg-primary {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%) !important;
        }
        
        /* Link Styles */
        a {
            color: var(--brand-orange);
        }
        
        a:hover {
            color: var(--brand-orange-dark);
        }
        
        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item:hover {
            background-color: rgba(249, 115, 22, 0.1);
            color: var(--brand-navy);
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-navy-dark) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        /* Status Badges */
        .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }
        
        .badge.bg-warning {
            background: linear-gradient(135deg, var(--brand-orange) 0%, var(--brand-orange-dark) 100%) !important;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }
        
        .badge.bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        }
        
        .badge.bg-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand navbar-brand-custom" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clients.index') }}">Clientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cranes.index') }}">Equipos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('quotes.index') }}">Cotizaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logs.index') }}">Logs</a>
                            </li>
                        @endauth
                    </ul>
                    
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">Perfil</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="container py-3">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container mt-4">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Internationalization JS Module -->
    <script type="module" src="{{ asset('assets/js/i18n-module.js') }}"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>