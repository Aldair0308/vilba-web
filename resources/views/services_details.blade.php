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
    </header>
    <main>
        <!-- slider Area Start-->
        <div class="slider-area ">
            <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="{{ asset('assets/img/hero/about.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-8">
                            <div class="hero-cap hero-cap2 pt-120">
                                <h2>
                                    @if(($language ?? 'es') === 'en')
                                        Engineering Techniques & Implementation
                                    @else
                                        Técnicas de Ingeniería e Implementación
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->
        <!-- Services Details Start -->
        <div class="services-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-services section-padding2">
                            <div class="details-img mb-40">
                                <img src="{{ asset('assets/img/gallery/services_details.png') }}" alt="">
                            </div>
                            <div class="details-caption">
                                <p>
                                    @if(($language ?? 'es') === 'en')
                                        At VILBA, we specialize in providing comprehensive engineering solutions that combine cutting-edge technology with proven methodologies. Our team of experienced engineers is dedicated to delivering innovative solutions that meet the highest industry standards and exceed our clients' expectations.
                                    @else
                                        En VILBA, nos especializamos en brindar soluciones integrales de ingeniería que combinan tecnología de vanguardia con metodologías comprobadas. Nuestro equipo de ingenieros experimentados se dedica a entregar soluciones innovadoras que cumplen con los más altos estándares de la industria y superan las expectativas de nuestros clientes.
                                    @endif
                                </p>

                                <p class="mb-50">
                                    @if(($language ?? 'es') === 'en')
                                        We understand that every project is unique, which is why we take a personalized approach to each challenge. From initial consultation to final implementation, we work closely with our clients to ensure that every detail is carefully planned and executed with precision.
                                    @else
                                        Entendemos que cada proyecto es único, por eso adoptamos un enfoque personalizado para cada desafío. Desde la consulta inicial hasta la implementación final, trabajamos estrechamente con nuestros clientes para asegurar que cada detalle sea cuidadosamente planificado y ejecutado con precisión.
                                    @endif
                                </p>

                                <h3>
                                    @if(($language ?? 'es') === 'en')
                                        How can we help?
                                    @else
                                        ¿Cómo podemos ayudarte?
                                    @endif
                                </h3>
                                <p>
                                    @if(($language ?? 'es') === 'en')
                                        Our comprehensive range of engineering services includes structural design, project management, technical consulting, and quality assurance. We leverage the latest software and technologies to provide accurate calculations, detailed drawings, and efficient project execution.
                                    @else
                                        Nuestra amplia gama de servicios de ingeniería incluye diseño estructural, gestión de proyectos, consultoría técnica y aseguramiento de calidad. Aprovechamos el software y las tecnologías más recientes para proporcionar cálculos precisos, dibujos detallados y ejecución eficiente de proyectos.
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

        <!-- JS here -->

    <x-assets-links/>

    </body>
</html>