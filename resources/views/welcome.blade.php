@php
    $currentLanguage = $language ?? 'es';
@endphp

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $currentLanguage === 'en' ? 'VILBA SERVICES' : 'SERVICIOS VILBA' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="site.webmanifest">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		<!-- CSS here -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
            <link rel="stylesheet" href="assets/css/slicknav.css">
            <link rel="stylesheet" href="assets/css/animate.min.css">
            <link rel="stylesheet" href="assets/css/magnific-popup.css">
            <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="assets/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/slick.css">
            <link rel="stylesheet" href="assets/css/nice-select.css">
            <link rel="stylesheet" href="assets/css/style.css">
            <!-- Language switcher script -->
            <script src="assets/js/language-switcher.js"></script>
            
            <!-- Configuración inicial del idioma -->
            <script>
                // Pasar idioma desde Laravel al JavaScript
                window.initialLanguage = '{{ $language ?? "es" }}';
                console.log('🌐 Idioma inicial desde Laravel:', window.initialLanguage);
            </script>
            <style>
                /* Estilo solo para PC (pantallas mayores a 768px) */
                @media (min-width: 769px) {
                    #logo {
                        margin-top: -190px;
                    }
                }
            </style>
            
            <style>
            /* Ajuste de posición para el div de servicios en dispositivos móviles */
            @media (max-width: 767px) {
                .hero-text2.mt-110 {
                    position: relative;
                    top: 20px;
                }
            }
            </style>
   </head>

   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder-logo.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <x-navar :language="$language ?? 'es'" />
    
    <main>

        <!-- slider Area Start-->
        <div class="slider-area ">
            <div class="slider-active">
                <div class="single-slider  hero-overly slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg">
                    <div class="container" id="logo">
                        <div class="row">
                            <div class="col-lg-11">
                                <div class="hero__caption">
                                    <div class="hero-text1">
                                        <span data-animation="fadeInUp" data-delay=".3s" data-translate="hero_subtitle">{{ $currentLanguage === 'en' ? 'industrial machinery and construction services' : 'maquinaria industrial y servicios de construcción' }}</span>
                                    </div>
                                    <h1 data-animation="fadeInUp" data-delay=".5s" data-translate="welcome">{{ $currentLanguage === 'en' ? 'Welcome' : 'Bienvenido' }}</h1>
                                    <div class="stock-text" data-animation="fadeInUp" data-delay=".8s" style="margin-top: 20px;">
                                        <h2>{{ $currentLanguage === 'en' ? 'VILBA SERVICES' : 'SERVICIOS VILBA' }}</h2>
                                        <h2>{{ $currentLanguage === 'en' ? 'VILBA SERVICES' : 'SERVICIOS VILBA' }}</h2>
                                    </div>
                                    <div class="hero-text2 mt-110" data-animation="fadeInUp" data-delay=".9s">
                                       <span><a href="{{ route('services') }}" data-translate="our_services" class="services-hero-link">{{ $currentLanguage === 'en' ? 'Our Services' : 'Nuestros Servicios' }}</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- slider Area End-->
        
        <!-- Equipment Showcase Component -->
        <div class="d-none d-lg-block" style="margin-top: -30px; margin-bottom: -20px;">
            <x-equipment-showcase />
        </div>
        {{-- Show on mobile and tablet --}}
        <div class="d-block d-lg-none">
            {{-- You can add different styles or content for mobile/tablet here if needed --}}
            {{-- For now, it will just render the component without the large negative margins --}}
            <x-equipment-showcase />
        </div>
        
        <!-- Services Area Start -->
        <div class="services-area1 section-padding30">
            <div class="container">
                <!-- Título de la sección -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-55">
                            <div class="front-text">
                                    <h2 class="" data-translate="our_services_title">Nuestros Servicios</h2>
                                </div>
                                <span class="back-text" data-translate="services_back">Servicios</span>
                        </div>
                    </div>
                </div>
                <div class="row d-flex align-items-stretch">
                    <!-- Servicio 1: Venta de Concreto y Materiales de Construcción -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess3.png" alt="Venta de Concreto y Materiales">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail') }}" data-translate="concrete_service">{{ $currentLanguage === 'en' ? 'Concrete and Construction Materials Sales' : 'Venta de Concreto y Materiales de Construcción' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="concrete_description">{{ $currentLanguage === 'en' ? 'We sell high-quality concrete and construction materials at our location: Av. Insurgentes Sur 1234, Col. Del Valle, Benito Juárez, CDMX, México.' : 'Vendemos concreto de alta calidad y materiales de construcción en nuestra ubicación: Av. Insurgentes Sur 1234, Col. Del Valle, Benito Juárez, CDMX, México.' }}</p>
                                <a href="{{ route('services-detail', 'concrete') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Servicio 2: Renta de Camión Volvo -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess1.png" alt="Camión Volvo">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail', 'volvo-truck') }}" data-translate="volvo_service">{{ $currentLanguage === 'en' ? 'Volvo Truck Rental' : 'Renta de Camión Volvo' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="volvo_description">{{ $currentLanguage === 'en' ? 'Volvo FH truck for long-distance transport and construction. Power 420-540 HP, ideal for regional transport and building-related tasks.' : 'Camión Volvo FH para transporte de larga distancia y construcción. Potencia de 420-540 CV, ideal para tareas de transporte regional y relacionado con edificación.' }}</p>
                                <a href="{{ route('services-detail', 'volvo-truck') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Servicio 3: Servicios de Edificación -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess2.png" alt="Servicios de Edificación">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail', 'building') }}" data-translate="building_service">{{ $currentLanguage === 'en' ? 'Construction Services' : 'Servicios de Edificación' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="building_description">{{ $currentLanguage === 'en' ? 'Heavy machinery for excavation, earthworks, compaction and construction projects.' : 'Maquinaria pesada para excavación, movimiento de tierras, compactación y proyectos de construcción.' }}</p>
                                <a href="{{ route('services-detail', 'building') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Segunda fila de servicios -->
                <div class="row mt-4 d-flex align-items-stretch">
                    <!-- Servicio 4: Servicios de Electrificación -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess3.png" alt="Servicios de Electrificación">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail', 'electrification') }}" data-translate="electrification_service">{{ $currentLanguage === 'en' ? 'Electrification Services' : 'Servicios de Electrificación' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="electrification_description">{{ $currentLanguage === 'en' ? 'Specialized equipment for electrical installations, power lines and industrial electrification projects.' : 'Equipos especializados para instalaciones eléctricas, líneas de energía y proyectos de electrificación industrial.' }}</p>
                                <a href="{{ route('services-detail', 'electrification') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Servicio 5: Sistemas de Drenaje -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess1.png" alt="Sistemas de Drenaje">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail', 'drainage') }}" data-translate="drainage_service">{{ $currentLanguage === 'en' ? 'Drainage Systems' : 'Sistemas de Drenaje' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="drainage_description">{{ $currentLanguage === 'en' ? 'Installation and maintenance of stormwater, sanitary and civil works drainage systems.' : 'Instalación y mantenimiento de sistemas de drenaje pluvial, sanitario y obras civiles.' }}</p>
                                <a href="{{ route('services-detail', 'drainage') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Servicio 6: Levantamientos Topográficos -->
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="single-service-cap mb-30 d-flex flex-column w-100">
                            <div class="service-img">
                                <img src="assets/img/service/servicess2.png" alt="Levantamientos Topográficos">
                            </div>
                            <div class="service-cap flex-grow-1 d-flex flex-column">
                                <h4><a href="{{ route('services-detail', 'topographic') }}" data-translate="topographic_service">{{ $currentLanguage === 'en' ? 'Topographic Surveys' : 'Levantamientos Topográficos' }}</a></h4>
                                <p class="service-description flex-grow-1" data-translate="topographic_description">{{ $currentLanguage === 'en' ? 'Precision terrain measurement and mapping for construction, infrastructure and civil engineering projects.' : 'Medición y mapeo de precisión del terreno para proyectos de construcción, infraestructura e ingeniería civil.' }}</p>
                                <a href="{{ route('services-detail', 'topographic') }}" class="more-btn mt-auto" data-translate="read_more">{{ $currentLanguage === 'en' ? 'Read More' : 'Leer más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Services Area End -->
        <!-- About Area Start -->
        <section class="support-company-area fix pt-10" style="margin-bottom: 3%">
            <div class="support-wrapper align-items-end">
                <div class="left-content">
                    <!-- Título de la sección -->
                    <div class="section-tittle section-tittle2 mb-55" style="margin-top: 40px;">
                        <div class="front-text">
                            <h2 class="" data-translate="who_we_are">Quiénes somos</h2>
                        </div>
                        <span class="back-text" data-translate="about_us_back">Sobre nosotros</span>
                    </div>
                    <div class="support-caption">
                        <p class="pera-top" data-translate="company_description_1">
                            En <strong>Vilba</strong>, ofrecemos soluciones confiables en renta de equipo pesado para tus proyectos industriales, de construcción o logísticos.
                        </p>
                        <p data-translate="company_description_2">
                            Contamos con una amplia variedad de maquinaria como montacargas, grúas, plataformas y más. Nos enfocamos en brindar equipos en excelente estado, acompañados de un servicio al cliente profesional y puntual. Ya sea para uso diario o por proyecto, en Vilba te apoyamos con la maquinaria que necesitas, cuando la necesitas.
                        </p>
                        <a href="about.html" class="btn red-btn2" data-translate="read_more_about_us">Leer más sobre nosotros</a>
                    </div>
                    
                </div>
                <div class="right-content">
                    <!-- Imagen -->
                    <div class="right-img">
                        <img src="assets/img/gallery/safe_in.png" alt="">
                    </div>
                    <div class="support-img-cap text-center">
                        <span>1994</span>
                        <p>Desde</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- About Area End -->
        <!-- contact with us Start -->
        <section class="contact-with-area" data-background="assets/img/gallery/section-bg2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-9 offset-xl-1 offset-lg-1">
                        <div class="contact-us-caption">
                            <div class="team-info mb-30 pt-45">
                                <!-- Título de la sección -->
                                <div class="section-tittle section-tittle4">
                                    <div class="front-text">
                                        <h2 class="">Hablemos de Vilba</h2>
                                    </div>
                                    <span class="back-text">Charlemos</span>
                                </div>
                                <p>
                                    En Vilba estamos para ayudarte con la renta de montacargas, grúas y todo el equipo pesado que necesites. 
                                    Nuestro equipo está listo para asesorarte y ofrecerte la mejor solución para tu proyecto. 
                                    No dudes en contactarnos para recibir atención personalizada y equipos en óptimas condiciones.
                                </p>
                                <a href="#" class="white-btn">Contáctanos</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        
        <!-- contact with us End-->
<!-- Área de Contador Inicio -->
<div class="count-area" style="margin-bottom: 5%">
    <div class="container">
        <div class="count-wrapper count-bg" data-background="assets/img/gallery/section-bg3.jpg">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="count-clients">
                        <div class="single-counter">
                            <div class="count-number">
                                <span class="counter">34</span>
                            </div>
                            <div class="count-text">
                                <h5 id="indicadores">Clientes</h5>
                                <p id="indicadores">Satisfechos</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="count-clients">
                        <div class="single-counter">
                            <div class="count-number">
                                <span class="counter">12</span>
                            </div>
                            <div class="count-text">
                                <h5 id="indicadores">Equipos</h5>
                                <p id="indicadores">Disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="count-clients">
                        <div class="single-counter">
                            <div class="count-number">
                                <span class="counter">09</span>
                            </div>
                            <div class="count-text">
                                <h5 id="indicadores">Servicios</h5>
                                <p id="indicadores">Disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Área de Contador Fin -->

    </main>
    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
    <!-- WhatsApp Button Component -->
    <x-whatsapp-button 
        phone="+525512345678" 
        :language="session('language') ?? 'es'" 
        :message="session('language') === 'en' ? 'Hello! I would like more information about your services.' : 'Hola! Me gustaría obtener más información sobre sus servicios.'" 
    />
    
   
	<!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
        <script src="./assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="./assets/js/owl.carousel.min.js"></script>
        <script src="./assets/js/slick.min.js"></script>
        <!-- Date Picker -->
        <script src="./assets/js/gijgo.min.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./assets/js/wow.min.js"></script>
		<!-- Script de cambio de contenido dinámico deshabilitado -->
<!-- <script src="./assets/js/animated.headline.js"></script> -->
        <script src="./assets/js/jquery.magnific-popup.js"></script>
        <script src="./assets/js/main.js"></script>
        
        <!-- Script personalizado para inicialización de contadores -->
        <script>
        $(document).ready(function() {
            // Esperar a que todos los scripts se carguen
            setTimeout(function() {
                // Verificar si waypoints y counterUp están disponibles
                if (typeof $.fn.waypoint !== 'undefined' && typeof $.fn.counterUp !== 'undefined') {
                    console.log('✅ Waypoints y CounterUp cargados correctamente');
                    
                    // Inicializar contadores con waypoints
                    $('.counter').each(function() {
                        var $this = $(this);
                        $this.waypoint(function() {
                            $this.counterUp({
                                delay: 10,
                                time: 3000
                            });
                        }, {
                            offset: '75%',
                            triggerOnce: true
                        });
                    });
                } else {
                    console.warn('⚠️ Waypoints o CounterUp no disponibles, usando fallback');
                    
                    // Fallback: animación manual con CSS
                    $('.counter').each(function() {
                        var $this = $(this);
                        var finalValue = parseInt($this.text());
                        var currentValue = 0;
                        var increment = finalValue / 100;
                        
                        var timer = setInterval(function() {
                            currentValue += increment;
                            if (currentValue >= finalValue) {
                                currentValue = finalValue;
                                clearInterval(timer);
                            }
                            $this.text(Math.floor(currentValue));
                        }, 30);
                    });
                }
            }, 1000);
        });
        </script>
