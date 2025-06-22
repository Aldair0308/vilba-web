<!doctype html>
<html class="no-js" lang="{{ session('language', 'es') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ session('language') === 'en' ? 'Equipment - Vilba Construction' : 'Equipos - Vilba Construcción' }}</title>
    <meta name="description" content="">
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
        <div class="single-slider hero-overly slider-height2 d-flex align-items-center" style="background-image: url('{{ asset('assets/img/hero/about.jpg') }}');">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap pt-100">
                            <h2>{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</h2>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ session('language') === 'en' ? route('home.EN') : route('home') }}">{{ session('language') === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    
    <!-- Equipment Section Start -->
    <section class="services-area1 section-padding30">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle mb-55">
                        <div class="front-text">
                            <h2 class="">{{ session('language') === 'en' ? 'Our Equipment Fleet' : 'Nuestra Flota de Equipos' }}</h2>
                        </div>
                        <span class="back-text">{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Equipment Grid -->
            <div class="row">
                <!-- Crane Equipment -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess1.png') }}" alt="Grúas">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Tower Cranes' : 'Grúas Torre' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'High-capacity tower cranes for construction projects of all sizes. Perfect for lifting heavy materials to great heights with precision and safety.' : 'Grúas torre de alta capacidad para proyectos de construcción de todos los tamaños. Perfectas para elevar materiales pesados a grandes alturas con precisión y seguridad.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 5-25 tons' : 'Capacidad: 5-25 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Height: Up to 80m' : 'Altura: Hasta 80m' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Professional operators included' : 'Operadores profesionales incluidos' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Cranes -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess2.png') }}" alt="Grúas Móviles">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Mobile Cranes' : 'Grúas Móviles' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Versatile mobile cranes for quick setup and flexible positioning. Ideal for projects requiring mobility and rapid deployment.' : 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible. Ideales para proyectos que requieren movilidad y despliegue rápido.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 10-100 tons' : 'Capacidad: 10-100 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'All-terrain capability' : 'Capacidad todo terreno' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Quick setup time' : 'Tiempo de montaje rápido' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Forklifts -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess3.png') }}" alt="Montacargas">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Forklifts' : 'Montacargas' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Electric and diesel forklifts for material handling and warehouse operations. Available in various capacities for indoor and outdoor use.' : 'Montacargas eléctricos y diésel para manejo de materiales y operaciones de almacén. Disponibles en varias capacidades para uso interior y exterior.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 1.5-10 tons' : 'Capacidad: 1.5-10 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Electric & diesel options' : 'Opciones eléctricas y diésel' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Indoor/outdoor models' : 'Modelos interior/exterior' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Aerial Platforms -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess4.png') }}" alt="Plataformas Elevadoras">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Aerial Platforms' : 'Plataformas Elevadoras' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Scissor lifts and boom lifts for elevated work access. Safe and efficient solutions for maintenance, installation, and construction tasks.' : 'Plataformas tijera y articuladas para acceso a trabajos en altura. Soluciones seguras y eficientes para tareas de mantenimiento, instalación y construcción.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Height: 6-30 meters' : 'Altura: 6-30 metros' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Electric & diesel models' : 'Modelos eléctricos y diésel' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Indoor/outdoor use' : 'Uso interior/exterior' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Excavators -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess5.png') }}" alt="Excavadoras">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Excavators' : 'Excavadoras' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Heavy-duty excavators for earthmoving, demolition, and construction projects. Available in various sizes for different project requirements.' : 'Excavadoras de trabajo pesado para movimiento de tierra, demolición y proyectos de construcción. Disponibles en varios tamaños para diferentes requisitos de proyecto.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Weight: 5-50 tons' : 'Peso: 5-50 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Multiple attachments' : 'Múltiples accesorios' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Experienced operators' : 'Operadores experimentados' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Specialized Equipment -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess6.png') }}" alt="Equipos Especializados">
                        </div>
                        <div class="service-cap">
                            <h4><a href="#">{{ session('language') === 'en' ? 'Specialized Equipment' : 'Equipos Especializados' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Custom and specialized machinery for unique project requirements. Including concrete pumps, pile drivers, and other specialized construction equipment.' : 'Maquinaria personalizada y especializada para requisitos únicos de proyecto. Incluyendo bombas de concreto, hincadoras de pilotes y otros equipos especializados de construcción.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Custom solutions' : 'Soluciones personalizadas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Latest technology' : 'Última tecnología' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Expert consultation' : 'Consultoría experta' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Equipment Section End -->
    
    <!-- Why Choose Our Equipment Section Start -->
    <section class="support-company-area fix pt-10">
        <div class="support-wrapper align-items-end">
            <div class="left-content">
                <!-- Section Title -->
                <div class="section-tittle section-tittle2 mb-55">
                    <div class="front-text">
                        <h2 class="">{{ session('language') === 'en' ? 'Why Choose Our Equipment?' : '¿Por qué elegir nuestros equipos?' }}</h2>
                    </div>
                    <span class="back-text">{{ session('language') === 'en' ? 'Quality' : 'Calidad' }}</span>
                </div>
                <div class="support-caption">
                    <p class="pera-top">
                        {{ session('language') === 'en' ? 'At VILBA, we maintain the highest standards for our equipment fleet. All our machinery undergoes regular maintenance and safety inspections to ensure optimal performance and reliability on your projects.' : 'En VILBA, mantenemos los más altos estándares para nuestra flota de equipos. Toda nuestra maquinaria se somete a mantenimiento regular e inspecciones de seguridad para garantizar un rendimiento óptimo y confiabilidad en sus proyectos.' }}
                    </p>
                    <p>
                        {{ session('language') === 'en' ? 'Our experienced team provides comprehensive support, from equipment selection to on-site operation. We ensure that you have the right equipment for your specific needs, backed by our commitment to safety and efficiency.' : 'Nuestro equipo experimentado brinda soporte integral, desde la selección de equipos hasta la operación en sitio. Nos aseguramos de que tenga el equipo adecuado para sus necesidades específicas, respaldado por nuestro compromiso con la seguridad y eficiencia.' }}
                    </p>
                    <a href="{{ session('language') === 'en' ? route('contact.EN') : route('contact.ES') }}" class="btn red-btn2">{{ session('language') === 'en' ? 'Request Quote' : 'Solicitar Cotización' }}</a>
                </div>
            </div>
            <div class="right-content">
                <!-- Image -->
                <div class="right-img">
                    <img src="{{ asset('assets/img/gallery/safe_in.png') }}" alt="">
                </div>
                <div class="support-img-cap text-center">
                    <span>30+</span>
                    <p>{{ session('language') === 'en' ? 'Years Experience' : 'Años de Experiencia' }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose Our Equipment Section End -->
    
    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
    <!-- WhatsApp Button Component -->
    <x-whatsapp-button 
        phone="+525512345678" 
        :language="session('language') ?? 'es'" 
        :message="session('language') === 'en' ? 'Hello! I would like more information about your equipment rental services.' : 'Hola! Me gustaría obtener más información sobre sus servicios de renta de equipos.'" 
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

    <!-- Custom CSS for Equipment Specs -->
    <style>
        .equipment-specs {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }
        
        .equipment-specs li {
            padding: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .equipment-specs li i {
            color: #ff6b35;
            margin-right: 8px;
        }
        
        .single-service-cap {
            transition: transform 0.3s ease;
        }
        
        .single-service-cap:hover {
            transform: translateY(-5px);
        }
        
        .service-cap h4 {
            margin-bottom: 15px;
        }
        
        .service-cap p {
            margin-bottom: 15px;
            line-height: 1.6;
        }
    </style>

</body>

</html>