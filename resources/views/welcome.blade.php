<!doctype html>
<html class="no-js" lang="zxx">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GRÚAS VILBA</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                                        <span data-animation="fadeInUp" data-delay=".3s" data-translate="hero_subtitle">maquinaria industrial y servicios de construcción</span>
                                    </div>
                                    <h1 data-animation="fadeInUp" data-delay=".5s" data-translate="welcome">Bienvenido</h1>
                                    <div class="stock-text" data-animation="fadeInUp" data-delay=".8s" style="margin-top: 20px;">
                                        <h2>GrÚas Vilba</h2>
                                        <h2>GrÚas Vilba</h2>
                                    </div>
                                    <div class="hero-text2 mt-110" data-animation="fadeInUp" data-delay=".9s">
                                       <span><a href="services.html" data-translate="our_services">Nuestros Servicios</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider  hero-overly slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-11">
                                <div class="hero__caption">
                                    <div class="hero-text1">
                                        <span data-animation="fadeInUp" data-delay=".3s">hand car wash and detailing service</span>
                                    </div>
                                    <h1 data-animation="fadeInUp" data-delay=".5s" data-translate="welcome">advanced</h1>
                                    <div class="stock-text" data-animation="fadeInUp" data-delay=".8s">
                                        <h2>Construction</h2>
                                        <h2>Construction</h2>
                                    </div>
                                    <div class="hero-text2 mt-110" data-animation="fadeInUp" data-delay=".9s">
                                        <span><a href="services.html" data-translate="services">Our Services</a></span>
                                    </div>
                                </div>
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
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="assets/img/service/servicess1.png" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="services_details.html" data-translate="engineering_techniques">Técnicas e implementación de ingeniería</a></h4>
                                <a href="services_details.html" class="more-btn" data-translate="read_more">Leer más <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="assets/img/service/servicess2.png" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="services_details.html">Técnicas e implementación de ingeniería</a></h4>
                                <a href="services_details.html" class="more-btn">Leer más <i class="ti-plus"></i></a>
                            </div>
                            <div class="service-icon">
                                <img src="assets/img/icon/services_icon1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-service-cap mb-30">
                            <div class="service-img">
                                <img src="assets/img/service/servicess3.png" alt="">
                            </div>
                            <div class="service-cap">
                                <h4><a href="services_details.htmlaa">Técnicas e implementación de ingeniería</a></h4>
                                <a href="services_details.html" class="more-btn">Leer más <i class="ti-plus"></i></a>
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
        <section class="support-company-area fix pt-10">
            <div class="support-wrapper align-items-end">
                <div class="left-content">
                    <!-- Título de la sección -->
                    <div class="section-tittle section-tittle2 mb-55">
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
        <!-- Project Area Start -->
        <section class="project-area  section-padding30">
            <div class="container">
               <div class="project-heading mb-35">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle3">
                                <div class="front-text">
                                    <h2 class="" data-translate="our_projects">Nuestros Proyectos</h2>
                                </div>
                                <span class="back-text" data-translate="gallery">Galería</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="properties__button">
                                <!--Nav Button  -->                                            
                                <nav> 
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false" data-translate="all">Todos</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" data-translate="interiors">Interiores</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false" data-translate="recent">Recientes</a>
                                        <a class="nav-item nav-link" id="nav-last-tab" data-toggle="tab" href="#nav-last" role="tab" aria-controls="nav-contact" aria-selected="false" data-translate="drainage">Drenaje</a>
                                        <a class="nav-item nav-link" id="nav-technology" data-toggle="tab" href="#nav-techno" role="tab" aria-controls="nav-contact" aria-selected="false" data-translate="parks">Parques</a>
                                    </div>
                                </nav>
                                <!--End Nav Button  -->
                            </div>
                        </div>
                    </div>
               </div>
                <div class="row">
                    <div class="col-12">
                        <!-- Nav Card -->
                        <div class="tab-content active" id="nav-tabContent">
                            <!-- card ONE -->
                            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">           
                                <div class="project-caption">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project1.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                    <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project2.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project3.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project4.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project5.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project6.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card TWO -->
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="project-caption">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project5.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project6.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project1.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project2.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project3.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project4.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card THREE -->
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="project-caption">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project3.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project4.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project1.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project2.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project5.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project6.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card FUR -->
                            <div class="tab-pane fade" id="nav-last" role="tabpanel" aria-labelledby="nav-last-tab">
                                <div class="project-caption">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project1.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project2.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project3.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project4.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project5.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project6.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card FIVE -->
                            <div class="tab-pane fade" id="nav-techno" role="tabpanel" aria-labelledby="nav-technology">
                                <div class="project-caption">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project1.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project2.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project3.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project4.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project5.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="single-project mb-30">
                                                <div class="project-img">
                                                    <img src="assets/img/gallery/project6.png" alt="">
                                                </div>
                                                <div class="project-cap">
                                                    <a href="project_details.html" class="plus-btn"><i class="ti-plus"></i></a>
                                                   <h4><a href="project_details.html">Floride Chemicals</a></h4>
                                                    <h4><a href="project_details.html">Factory</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- End Nav Card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Project Area End -->
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
<div class="count-area">
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
                                <p>Maquinaria</p>
                                <h5>Herramientas</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="count-clients">
                        <div class="single-counter">
                            <div class="count-number">
                                <span class="counter">76</span>
                            </div>
                            <div class="count-text">
                                <p>Maquinaria</p>
                                <h5>Herramientas</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="count-clients">
                        <div class="single-counter">
                            <div class="count-number">
                                <span class="counter">08</span>
                            </div>
                            <div class="count-text">
                                <p>Maquinaria</p>
                                <h5>Herramientas</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Área de Contador Fin -->

<!-- Equipo Inicio -->
<div class="team-area section-padding30">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Título de Sección -->
                <div class="section-tittle section-tittle5 mb-50">
                    <div class="front-text">
                        <h2 class="">Nuestro equipo</h2>
                    </div>
                    <span class="back-text">expertos</span>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Miembro del equipo individual -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <img src="assets/img/team/team1.png" alt="">
                    </div>
                    <div class="team-caption">
                        <span>Arquitecto</span>
                        <h3>Ethan Welch</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <img src="assets/img/team/team2.png" alt="">
                    </div>
                    <div class="team-caption">
                        <span>Agente Vendedor</span>
                        <h3>Ethan Welch</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                <div class="single-team mb-30">
                    <div class="team-img">
                        <img src="assets/img/team/team3.png" alt="">
                    </div>
                    <div class="team-caption">
                        <span>Diseñador UX</span>
                        <h3>Ethan Welch</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Equipo Fin -->

<!-- Testimonios Inicio -->
<div class="testimonial-area t-bg testimonial-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Título de Sección -->
                <div class="section-tittle section-tittle6 mb-50">
                    <div class="front-text">
                        <h2 class="">Testimonios</h2>
                    </div>
                    <span class="back-text">Opiniones</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-10 col-lg-11 col-md-10 offset-xl-1">
                <div class="h1-testimonial-active">
                    <!-- Testimonio individual -->
                    <div class="single-testimonial">
                        <div class="testimonial-caption">
                            <div class="testimonial-top-cap">
                                <!-- Icono SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="86px" height="63px">
                                    <path fill-rule="evenodd" stroke-width="1px" stroke="rgb(255, 95, 19)" fill-opacity="0" fill="rgb(0, 0, 0)"
                                    d="M82.623,59.861 L48.661,59.861 L48.661,25.988 L59.982,3.406 L76.963,3.406 L65.642,25.988 L82.623,25.988 L82.623,59.861 ZM3.377,25.988 L14.698,3.406 L31.679,3.406 L20.358,25.988 L37.340,25.988 L37.340,59.861 L3.377,59.861 L3.377,25.988 Z"/>
                                </svg>
                                <p>Mollit anim laborum. Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non aute iruxvfg dhjinulpadeserunt mollitemnth incididbnt ut;o5tu layjobore mofllit anim.</p>
                            </div>
                            <!-- Fundadora -->
                            <div class="testimonial-founder d-flex align-items-center">
                                <div class="founder-text">
                                    <span>Jessya Inn</span>
                                    <p>Co-Fundadora</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Otro Testimonio -->
                    <div class="single-testimonial">
                        <div class="testimonial-caption">
                            <div class="testimonial-top-cap">
                                <!-- Icono SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="86px" height="63px">
                                    <path fill-rule="evenodd" stroke-width="1px" stroke="rgb(255, 95, 19)" fill-opacity="0" fill="rgb(0, 0, 0)"
                                    d="M82.623,59.861 L48.661,59.861 L48.661,25.988 L59.982,3.406 L76.963,3.406 L65.642,25.988 L82.623,25.988 L82.623,59.861 ZM3.377,25.988 L14.698,3.406 L31.679,3.406 L20.358,25.988 L37.340,25.988 L37.340,59.861 L3.377,59.861 L3.377,25.988 Z"/>
                                </svg>
                                <p>Mollit anim laborum. Dvcuis aute iruxvfg dhjkolohr in re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non aute iruxvfg dhjinulpadeserunt mollitemnth incididbnt ut;o5tu layjobore mofllit anim.</p>
                            </div>
                            <!-- Fundadora -->
                            <div class="testimonial-founder d-flex align-items-center">
                                <div class="founder-text">
                                    <span>Jessya Inn</span>
                                    <p>Co-Fundadora</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Fin de .h1-testimonial-active -->
            </div>
        </div>
    </div>
</div>

<!-- Testimonios Fin -->

<!-- Últimas Noticias Inicio -->
<div class="latest-news-area section-padding30">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Título de Sección -->
                <div class="section-tittle section-tittle7 mb-50">
                    <div class="front-text">
                        <h2 class="">Últimas noticias</h2>
                    </div>
                    <span class="back-text">Nuestro Blog</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <!-- Noticia individual -->
                <div class="single-news mb-30">
                    <div class="news-img">
                        <img src="assets/img/david/david_1.png" alt="">
                        <div class="news-date text-center">
                            <span>24</span>
                            <p>Ahora</p>
                        </div>
                    </div>
                    <div class="news-caption">
                        <ul class="david-info">
                            <li> | &nbsp; &nbsp; Propiedades</li>
                        </ul>
                        <h2><a href="single-blog.html">Huellas en el tiempo: la casa perfecta en Kurashiki</a></h2>
                        <a href="single-blog.html" class="d-btn">Leer más »</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <!-- Noticia individual -->
                <div class="single-news mb-30">
                    <div class="news-img">
                        <img src="assets/img/david/david_2.png" alt="">
                        <div class="news-date text-center">
                            <span>24</span>
                            <p>Ahora</p>
                        </div>
                    </div>
                    <div class="news-caption">
                        <ul class="david-info">
                            <li> | &nbsp; &nbsp; Propiedades</li>
                        </ul>
                        <h2><a href="single-blog.html">Huellas en el tiempo: la casa perfecta en Kurashiki</a></h2>
                        <a href="single-blog.html" class="d-btn">Leer más »</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Últimas Noticias Fin -->

        <!--latest News Area End -->

    </main>
    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
   
	<!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="./assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="./assets/js/owl.carousel.min.js"></script>
        <script src="./assets/js/slick.min.js"></script>
        <!-- Date Picker -->
        <script src="./assets/js/gijgo.min.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./assets/js/wow.min.js"></script>
		<script src="./assets/js/animated.headline.js"></script>
        <script src="./assets/js/jquery.magnific-popup.js"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="./assets/js/jquery.scrollUp.min.js"></script>
        <script src="./assets/js/jquery.nice-select.min.js"></script>
		<script src="./assets/js/jquery.sticky.js"></script>
               
        <!-- counter , waypoint -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
        <script src="./assets/js/jquery.counterup.min.js"></script>

        <!-- contact js -->
        <script src="./assets/js/contact.js"></script>
        <script src="./assets/js/jquery.form.js"></script>
        <script src="./assets/js/jquery.validate.min.js"></script>
        <script src="./assets/js/mail-script.js"></script>
        <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="./assets/js/plugins.js"></script>
        <script src="./assets/js/main.js"></script>
        
    </body>
</html>