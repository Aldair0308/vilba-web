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
                <div class="d-none d-sm-block mb-5 pb-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.8445194652563!2d-99.96694989999999!3d19.4191227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d2856ba145a859%3A0xdca48ae2e494098d!2sCONCRETOS%20Y%20CONSTRUCCIONES%20VILBA%20SA%20DE%20CV!5e0!3m2!1ses-419!2smx!4v1751433490665!5m2!1ses-419!2smx" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><script>
                        function initMap() {
                            var uluru = {
                                lat: -25.363,
                                lng: 131.044
                            };
                            var grayStyles = [{
                                    featureType: "all",
                                    stylers: [{
                                            saturation: -90
                                        },
                                        {
                                            lightness: 50
                                        }
                                    ]
                                },
                                {
                                    elementType: 'labels.text.fill',
                                    stylers: [{
                                        color: '#ccdee9'
                                    }]
                                }
                            ];
                            var map = new google.maps.Map(document.getElementById('map'), {
                                center: {
                                    lat: -31.197,
                                    lng: 150.744
                                },
                                zoom: 9,
                                styles: grayStyles,
                                scrollwheel: false
                            });
                        }
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I&amp;callback=initMap">
                    </script>
<!-- Map Navigation Buttons -->
                        <div class="map-navigation-section mt-4">
                            <div class="navigation-header text-center mb-3">
                                <h5 class="navigation-title">{{ session('language') === 'en' ? 'Navigate to our location' : 'Navega a nuestra ubicación' }}</h5>
                                <p class="navigation-subtitle">{{ session('language') === 'en' ? 'Choose your preferred navigation app' : 'Elige tu app de navegación preferida' }}</p>
                            </div>
                            <div class="map-buttons-container">
                                <a href="https://www.google.com/maps/search/?api=1&query=CONCRETOS+Y+CONSTRUCCIONES+VILBA+SA+DE+CV" target="_blank" class="map-nav-button google-maps" data-app="google">
                                    <div class="button-icon">
                                        <i class="fab fa-google"></i>
                                    </div>
                                    <div class="button-content">
                                        <span class="button-title">Google Maps</span>
                                        <span class="button-subtitle">{{ session('language') === 'en' ? 'Open in Google Maps' : 'Abrir en Google Maps' }}</span>
                                    </div>
                                    <div class="button-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                                <a href="https://waze.com/ul?q=CONCRETOS+Y+CONSTRUCCIONES+VILBA+SA+DE+CV&navigate=yes" target="_blank" class="map-nav-button waze" data-app="waze">
                                    <div class="button-icon">
                                        <!-- Using a custom Waze icon since Font Awesome might not have it -->
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 15.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm3 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-5c0 .55-.45 1-1 1H10c-.55 0-1-.45-1-1s.45-1 1-1h4c.55 0 1 .45 1 1z"/>
                                        </svg>
                                    </div>
                                    <div class="button-content">
                                        <span class="button-title">Waze</span>
                                        <span class="button-subtitle">{{ session('language') === 'en' ? 'Open in Waze' : 'Abrir en Waze' }}</span>
                                    </div>
                                    <div class="button-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>


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
    
    <style>
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }
        
        .notification {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateX(450px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border-left: 5px solid rgba(255, 255, 255, 0.3);
        }
        
        .notification.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-left-color: #00f2fe;
        }
        
        .notification.error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border-left-color: #ee5a24;
        }
        
        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .notification-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
            vertical-align: middle;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            text-align: center;
            line-height: 24px;
            font-size: 14px;
        }
        
        .notification-content {
            display: inline-block;
            vertical-align: middle;
            max-width: calc(100% - 50px);
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
            display: block;
        }
        
        .notification-message {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.4;
        }
        
        .notification-close {
            position: absolute;
            top: 8px;
            right: 12px;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            cursor: pointer;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .notification-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
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