<!doctype html>
<html class="no-js" lang="{{ $language ?? 'es' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>
            @if(($language ?? 'es') === 'en')
                Engineering Services - VILBA
            @else
                Servicios de Ingeniería - VILBA
            @endif
        </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
                <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

   <!-- CSS here -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/assets/css/gijgo.css">
        <link rel="stylesheet" href="/assets/css/slicknav.css">
        <link rel="stylesheet" href="/assets/css/animate.min.css">
        <link rel="stylesheet" href="/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="/assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="/assets/css/themify-icons.css">
        <link rel="stylesheet" href="/assets/css/slick.css">
        <link rel="stylesheet" href="/assets/css/nice-select.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/responsive.css">
   </head>

   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="/assets/img/logo/loder-logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        @include('components.navar')
    </header>
    <main>
        <!-- Slider Area Start -->
        <div class="slider-area">
            <div class="single-slider slider-height2 d-flex align-items-center" data-background="/assets/img/hero/about.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-120 text-center">
                                <h2>{{ $serviceData['title'][$language] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-overly"></div>
            </div>
        </div>
        <!-- Slider Area End -->
        <!-- Services Details Start -->
        <div class="services-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-services section-padding2">
                            <div class="details-img mb-40">
                                <img src="/assets/img/gallery/services_details.png" alt="">
                            </div>
                            <div class="details-caption">
                                <h4>{{ $serviceData['title'][$language] }}</h4>
                                <p>{{ $serviceData['description'][$language] }}</p>
                                
                                <div class="services-features mt-30">
                                    <h5>{{ $language == 'es' ? 'Características principales:' : 'Main features:' }}</h5>
                                    <ul class="unordered-list">
                                        @foreach($serviceData['features'][$language] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <h3>
                                    @if(($language ?? 'es') === 'en')
                                        Why Choose Our Services?
                                    @else
                                        ¿Por qué elegir nuestros servicios?
                                    @endif
                                </h3>
                                <p>
                                    @if(($language ?? 'es') === 'en')
                                        At VILBA, we are committed to delivering exceptional results that exceed our clients' expectations. Our experienced team, combined with state-of-the-art equipment and proven methodologies, ensures that every project is completed with the highest standards of quality and safety.
                                    @else
                                        En VILBA, estamos comprometidos a entregar resultados excepcionales que superen las expectativas de nuestros clientes. Nuestro equipo experimentado, combinado con equipos de última generación y metodologías comprobadas, asegura que cada proyecto se complete con los más altos estándares de calidad y seguridad.
                                    @endif
                                </p>

                                <p>
                                    @if(($language ?? 'es') === 'en')
                                        Whether you need support for a small residential project or a large-scale commercial development, our team has the expertise and resources to deliver exceptional results. Contact us today to discuss how we can contribute to the success of your next project.
                                    @else
                                        Ya sea que necesites apoyo para un pequeño proyecto residencial o un desarrollo comercial a gran escala, nuestro equipo tiene la experiencia y los recursos para entregar resultados excepcionales. Contáctanos hoy para discutir cómo podemos contribuir al éxito de tu próximo proyecto.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Services Details End -->
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

    <x-assets-links/>

    </body>
</html>