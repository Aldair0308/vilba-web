<!doctype html>
<html class="no-js" lang="{{ session('language', 'es') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $equipment['name'][session('language', 'es')] }} - {{ session('language') === 'en' ? 'Vilba Construction' : 'Vilba Construcción' }}</title>
    <meta name="description" content="{{ $equipment['description'][session('language', 'es')] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

   <!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/gijgo.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/img/logo/loder-logo.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->        
        <x-navar :language="$language ?? 'es'" />
        <!-- Header End -->
    </header>
    <!-- slider Area Start-->
    <div class="slider-area ">
        <div class="single-slider hero-overly slider-height2 d-flex align-items-center" style="background-image: url('{{ asset($equipment['hero_image']) }}');">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap pt-100">
                            <h2>{{ $equipment['name'][session('language', 'es')] }}</h2>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ session('language') === 'en' ? route('home.EN') : route('home') }}">{{ session('language') === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ session('language') === 'en' ? route('equipos.EN') : route('equipos') }}">{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ $equipment['name'][session('language', 'es')] }}</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    
    <!-- Equipment Detail Section Start -->
    <section class="services-details-area section-padding30">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="single-service-details mb-40">
                        <div class="service-details-cap">
                            <h3>{{ $equipment['name'][session('language', 'es')] }}</h3>
                            <p>{{ $equipment['detailed_info'][session('language', 'es')]['description'] }}</p>
                        </div>
                    </div>
                    
                    <!-- Features Section -->
                    <div class="single-service-details mb-40">
                        <div class="service-details-cap">
                            <h4>{{ session('language') === 'en' ? 'Key Features' : 'Características Principales' }}</h4>
                            <ul class="unordered-list">
                                @foreach($equipment['detailed_info'][session('language', 'es')]['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Applications Section -->
                    <div class="single-service-details mb-40">
                        <div class="service-details-cap">
                            <h4>{{ session('language') === 'en' ? 'Applications' : 'Aplicaciones' }}</h4>
                            <ul class="unordered-list">
                                @foreach($equipment['detailed_info'][session('language', 'es')]['applications'] as $application)
                                    <li>{{ $application }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Technical Specifications -->
                    <div class="single-service-details mb-40">
                        <div class="service-details-cap">
                            <h4>{{ session('language') === 'en' ? 'Technical Specifications' : 'Especificaciones Técnicas' }}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($equipment['detailed_info'][session('language', 'es')]['technical_specs'] as $spec)
                                            @php
                                                $parts = explode(':', $spec, 2);
                                            @endphp
                                            <tr>
                                                <td><strong>{{ trim($parts[0]) }}</strong></td>
                                                <td>{{ isset($parts[1]) ? trim($parts[1]) : '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Gallery -->
                    <div class="single-service-details mb-40">
                        <div class="service-details-cap">
                            <h4>{{ session('language') === 'en' ? 'Gallery' : 'Galería' }}</h4>
                            <div class="row">
                                @foreach($equipment['gallery'] as $image)
                                    <div class="col-md-4 mb-3">
                                        <div class="gallery-img">
                                            <img src="{{ asset($image) }}" alt="{{ $equipment['name'][session('language', 'es')] }}" class="img-fluid">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="service-details-sidebar">
                        <!-- Contact Info -->
                        <div class="single-sidebar mb-40">
                            <div class="sidebar-cap">
                                <h4>{{ session('language') === 'en' ? 'Request Quote' : 'Solicitar Cotización' }}</h4>
                                <p>{{ session('language') === 'en' ? 'Get a personalized quote for this equipment. Our team will contact you within 24 hours.' : 'Obtenga una cotización personalizada para este equipo. Nuestro equipo se pondrá en contacto con usted en 24 horas.' }}</p>
                                <a href="{{ session('language') === 'en' ? route('contact.EN') : route('contact.ES') }}" class="btn red-btn2">{{ session('language') === 'en' ? 'Get Quote' : 'Obtener Cotización' }}</a>
                            </div>
                        </div>
                        
                        <!-- Equipment Summary -->
                        <div class="single-sidebar mb-40">
                            <div class="sidebar-cap">
                                <h4>{{ session('language') === 'en' ? 'Equipment Summary' : 'Resumen del Equipo' }}</h4>
                                <div class="equipment-summary">
                                    <div class="summary-item">
                                        <img src="{{ asset($equipment['hero_image']) }}" alt="{{ $equipment['name'][session('language', 'es')] }}" class="img-fluid mb-3">
                                    </div>
                                    <h5>{{ $equipment['name'][session('language', 'es')] }}</h5>
                                    <p>{{ $equipment['description'][session('language', 'es')] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Related Equipment -->
                        <div class="single-sidebar mb-40">
                            <div class="sidebar-cap">
                                <h4>{{ session('language') === 'en' ? 'Other Equipment' : 'Otros Equipos' }}</h4>
                                <div class="related-equipment">
                                    <a href="{{ session('language') === 'en' ? route('equipos.EN') : route('equipos') }}" class="btn btn-outline-primary btn-block">{{ session('language') === 'en' ? 'View All Equipment' : 'Ver Todos los Equipos' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Equipment Detail Section End -->
    
    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
    <!-- WhatsApp Button Component -->
    <x-whatsapp-button 
        phone="+525512345678" 
        :language="session('language') ?? 'es'" 
        :message="session('language') === 'en' ? 'Hello! I would like more information about ' . $equipment['name']['en'] . '.' : 'Hola! Me gustaría obtener más información sobre ' . $equipment['name']['es'] . '.'" 
    />

    <!-- JS here -->
    <x-assets-links/>
    
    <!-- Language Switcher Script -->
    <script>
        function switchLanguage(lang) {
            fetch('/switch-language', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ language: lang })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

    <!-- Custom CSS for Equipment Details -->
    <style>
        .equipment-summary img {
            border-radius: 8px;
        }
        
        .gallery-img img {
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        
        .gallery-img img:hover {
            transform: scale(1.05);
        }
        
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 12px;
        }
        
        .unordered-list {
            list-style: none;
            padding: 0;
        }
        
        .unordered-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            padding-left: 25px;
        }
        
        .unordered-list li:before {
            content: "✓";
            color: #ff6b35;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .service-details-sidebar {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
        }
        
        .single-sidebar {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>

</body>

</html>