<!doctype html>
<html class="no-js" lang="{{ $language ?? 'es' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>
            @if(($language ?? 'es') === 'en')
                About Us - VILBA
            @else
                Acerca de Nosotros - VILBA
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
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-120">
                                <h2>
                                    @if(($language ?? 'es') === 'en')
                                        About Us
                                    @else
                                        Acerca de Nosotros
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->
        <!-- About Area Start -->
        <section class="support-company-area fix pt-10 section-padding30">
            <div class="support-wrapper align-items-end">
                <div class="left-content">
                    <!-- section tittle -->
                    <div class="section-tittle section-tittle2 mb-55">
                        <div class="front-text">
                            <h2 class="">
                                @if(($language ?? 'es') === 'en')
                                    Who we are
                                @else
                                    Quiénes somos
                                @endif
                            </h2>
                        </div>
                        <span class="back-text">
                            @if(($language ?? 'es') === 'en')
                                About us
                            @else
                                Acerca de nosotros
                            @endif
                        </span>
                    </div>
                    <div class="support-caption">
                        <p class="pera-top">
                            @if(($language ?? 'es') === 'en')
                                At VILBA, we are a company specialized in crane services with personalized attention and quick response throughout the city. We have been providing reliable and professional crane services since 1994.
                            @else
                                En VILBA, somos una empresa especializada en servicios de grúas con atención personalizada y rápida respuesta en toda la ciudad. Hemos estado brindando servicios de grúas confiables y profesionales desde 1994.
                            @endif
                        </p>
                        <p>
                            @if(($language ?? 'es') === 'en')
                                Our team of experienced professionals is committed to providing safe, efficient, and cost-effective solutions for all your lifting and transportation needs. We pride ourselves on our excellent customer service and our ability to handle projects of any size.
                            @else
                                Nuestro equipo de profesionales experimentados está comprometido a brindar soluciones seguras, eficientes y rentables para todas sus necesidades de elevación y transporte. Nos enorgullecemos de nuestro excelente servicio al cliente y nuestra capacidad para manejar proyectos de cualquier tamaño.
                            @endif
                        </p>
                        <a href="{{ ($language ?? 'es') === 'en' ? route('services.EN') : route('services.ES') }}" class="btn red-btn2">
                            @if(($language ?? 'es') === 'en')
                                Our Services
                            @else
                                Nuestros Servicios
                            @endif
                        </a>
                    </div>
                </div>
                <div class="right-content">
                    <!-- img -->
                    <div class="right-img">
                        <img src="{{ asset('assets/img/gallery/safe_in.png') }}" alt="">
                    </div>
                    <div class="support-img-cap text-center">
                        <span>1994</span>
                        <p>Since</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->
        <!-- Testimonial Start -->
        <div class="testimonial-area t-bg testimonial-padding">
            <div class="container ">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Section Tittle -->
                        <div class="section-tittle section-tittle6 mb-50">
                            <div class="front-text">
                                <h2 class="">Testimonial</h2>
                            </div>
                            <span class="back-text">Feedback</span>
                        </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-xl-10 col-lg-11 col-md-10 offset-xl-1">
                        <div class="h1-testimonial-active">
                            <!-- Single Testimonial -->
                            <div class="single-testimonial">
                                 <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <div class="testimonial-top-cap">
                                        <!-- SVG icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg"xmlns:xlink="http://www.w3.org/1999/xlink"width="86px" height="63px">
                                        <path fill-rule="evenodd"  stroke-width="1px" stroke="rgb(255, 95, 19)" fill-opacity="0" fill="rgb(0, 0, 0)"
                                        d="M82.623,59.861 L48.661,59.861 L48.661,25.988 L59.982,3.406 L76.963,3.406 L65.642,25.988 L82.623,25.988 L82.623,59.861 ZM3.377,25.988 L14.698,3.406 L31.679,3.406 L20.358,25.988 L37.340,25.988 L37.340,59.861 L3.377,59.861 L3.377,25.988 Z"/>
                                        </svg>
                                        <p>Mollit anim laborum.Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non aute iruxvfg dhjinulpadeserunt mollitemnth incididbnt ut;o5tu layjobore mofllit anim. Mollit anim laborum.Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjn.</p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center">
                                       <div class="founder-text">
                                            <span>Jessya Inn</span>
                                            <p>Co Founder</p>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial">
                                 <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <div class="testimonial-top-cap">
                                        <!-- SVG icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg"xmlns:xlink="http://www.w3.org/1999/xlink"width="86px" height="63px">
                                        <path fill-rule="evenodd"  stroke-width="1px" stroke="rgb(255, 95, 19)" fill-opacity="0" fill="rgb(0, 0, 0)"
                                        d="M82.623,59.861 L48.661,59.861 L48.661,25.988 L59.982,3.406 L76.963,3.406 L65.642,25.988 L82.623,25.988 L82.623,59.861 ZM3.377,25.988 L14.698,3.406 L31.679,3.406 L20.358,25.988 L37.340,25.988 L37.340,59.861 L3.377,59.861 L3.377,25.988 Z"/>
                                        </svg>
                                        <p>Mollit anim laborum.Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non aute iruxvfg dhjinulpadeserunt mollitemnth incididbnt ut;o5tu layjobore mofllit anim. Mollit anim laborum.Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjn.</p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center">
                                       <div class="founder-text">
                                            <span>Jessya Inn</span>
                                            <p>Co Founder</p>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
        <!-- Testimonial End -->
        <!-- Team Start -->
        <div class="team-area section-padding30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Section Tittle -->
                        <div class="section-tittle section-tittle5 mb-50">
                            <div class="front-text">
                                <h2 class="">Our team</h2>
                            </div>
                            <span class="back-text">exparts</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- single Tem -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="{{ asset('assets/img/team/team1.png') }}" alt="">
                            </div>
                            <div class="team-caption">
                                <span>UX Designer</span>
                                <h3>Ethan Welch</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="{{ asset('assets/img/team/team2.png') }}" alt="">
                            </div>
                            <div class="team-caption">
                                <span>UX Designer</span>
                                <h3>Ethan Welch</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="{{ asset('assets/img/team/team3.png') }}" alt="">
                            </div>
                            <div class="team-caption">
                                <span>UX Designer</span>
                                <h3>Ethan Welch</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
    </main>

    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />

        <!-- JS here -->
        <x-assets-links/>

    </body>
</html>