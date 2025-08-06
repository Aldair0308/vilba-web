<!doctype html>
<html class="no-js" lang="{{ session('language', 'es') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ session('language') === 'en' ? 'Contact - Vilba Construction' : 'Contacto - Vilba Construcción' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <link rel="stylesheet" href="/assets/css/themify-icons.css">
        <link rel="stylesheet" href="/assets/css/slick.css">
        <link rel="stylesheet" href="/assets/css/nice-select.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/responsive.css">
</head>

<body data-language="{{ session('language') ?? 'es' }}">
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
        <x-navar :language="$language ?? 'es'" />
        <!-- Header End -->
    </header>
    <!-- slider Area Start-->
    <div class="slider-area ">
            <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="/assets/img/hero/about.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap pt-100">
                            <h2>{{ session('language') === 'en' ? 'Contact' : 'Contacto' }}</h2>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ session('language') === 'en' ? route('home.EN') : route('home') }}">{{ session('language') === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ session('language') === 'en' ? 'Contact' : 'Contacto' }}</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">



                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">{{ session('language') === 'en' ? 'Get in Touch' : 'Ponte en Contacto' }}</h2>
                    </div>
                    <div class="col-lg-8">
                        <form class="form-contact contact_form" action="{{ route('contact.submit') }}" method="POST" id="contactForm" novalidate="novalidate">
                                @csrf
                                <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ session('language') === 'en' ? 'Enter Message' : 'Ingresa tu Mensaje' }}'" placeholder="{{ session('language') === 'en' ? 'Enter Message' : 'Ingresa tu Mensaje' }}"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ session('language') === 'en' ? 'Enter your name' : 'Ingresa tu nombre' }}'" placeholder="{{ session('language') === 'en' ? 'Enter your name' : 'Ingresa tu nombre' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ session('language') === 'en' ? 'Enter email address' : 'Ingresa tu correo electrónico' }}'" placeholder="{{ session('language') === 'en' ? 'Email' : 'Correo Electrónico' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="phone" id="phone" type="tel" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ session('language') === 'en' ? 'Enter phone number' : 'Ingresa tu teléfono' }}'" placeholder="{{ session('language') === 'en' ? 'Phone (optional)' : 'Teléfono (opcional)' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ session('language') === 'en' ? 'Enter Subject' : 'Ingresa el Asunto' }}'" placeholder="{{ session('language') === 'en' ? 'Enter Subject' : 'Ingresa el Asunto' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="button button-contactForm boxed-btn">{{ session('language') === 'en' ? 'Send' : 'Enviar' }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>{{ session('language') === 'en' ? 'CONCRETOS Y CONSTRUCCIONES VILBA SA DE CV, 50974 Secc. de Guadalupe, Méx.' : 'CONCRETOS Y CONSTRUCCIONES VILBA SA DE CV, 50974 Secc. de Guadalupe, Méx.' }}</h3>
                                <p></p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                            <div class="media-body">
                                <h3>+52 55 5555 5555</h3>
                                <p>{{ session('language') === 'en' ? 'Mon to Fri 9am to 6pm' : 'Lun a Vie 9am a 6pm' }}</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-email"></i></span>
                            <div class="media-body">
                                <h3>contacto@vilbaconstruccion.com</h3>
                                <p>{{ session('language') === 'en' ? 'Send us your query anytime!' : '¡Envíanos tu consulta en cualquier momento!' }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    
    <!-- Animated Notification System -->
    <div id="notification-container" class="notification-container"></div>

            transition: width linear;
        }
        
        @media (max-width: 768px) {
            .notification-container {
                left: 20px;
                right: 20px;
                max-width: none;
            }
            
            .notification {
                transform: translateY(-100px);
            }
            
            .notification.show {
                transform: translateY(0);
            }
        }
        
        /* Loading animation for form submission */
        .form-loading {
            position: relative;
            pointer-events: none;
        }
        
        .form-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        .form-loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin: -20px 0 0 -20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
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

    </body>

    </html>