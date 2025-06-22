<!doctype html>
<html class="no-js" lang="{{ $language === 'en' ? 'en' : 'es' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $language === 'en' ? 'Services - Vilba' : 'Servicios - Vilba' }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="manifest" href="site.webmanifest">
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
            <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
            
            <!-- Language Switcher Script -->
            <script src="{{ asset('assets/js/language-switcher.js') }}"></script>
            <script>
                window.currentLanguage = '{{ $language ?? "es" }}';
            </script>
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

    <x-navar :language="$language ?? 'es'" />
    <main>
        <!-- slider Area Start-->
        <div class="slider-area ">
            <div class="single-slider hero-overly slider-height2 d-flex align-items-center" style="background-image: url('{{ asset('assets/img/hero/about.jpg') }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap pt-100">
                                <h2>{{ $language === 'en' ? 'Services' : 'Servicios' }}</h2>
                                <nav aria-label="breadcrumb ">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $language === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                    <li class="breadcrumb-item"><a href="#">{{ $language === 'en' ? 'Services' : 'Servicios' }}</a></li> 
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->
        <!-- Services Area Start -->
        <div class="services-area1 section-padding30">
            <div class="container">
                <!-- section tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-55">
                            <div class="front-text">
                                <h2 class="">{{ $language === 'en' ? 'Our Services' : 'Nuestros Servicios' }}</h2>
                            </div>
                            <span class="back-text">{{ $language === 'en' ? 'Services' : 'Servicios' }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess1.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess2.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess3.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess4.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess5.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/service/servicess6.png') }}" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="{{ route('services-detail') }}">{{ $language === 'en' ? 'Engineering techniques & implementation' : 'Técnicas de ingeniería e implementación' }}</a></h4>
                                <a href="{{ route('services-detail') }}" class="more-btn">{{ $language === 'en' ? 'Read More' : 'Leer Más' }} <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Services Area End -->
    </main>
    <footer>
        <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
    <!-- WhatsApp Button Component -->
    <x-whatsapp-button 
        phone="+525512345678" 
        :language="session('language') ?? 'es'" 
        :message="session('language') === 'en' ? 'Hello! I would like more information about your services.' : 'Hola! Me gustaría obtener más información sobre sus servicios.'" 
    />
    </footer>
   
        <!-- JS here -->
        <x-assets-links/>
        
    </body>
</html>