<!-- Debug: Footer Language value = {{ $language }} -->
@if(config('app.debug'))
    <script>console.log('🔍 Footer Language Debug:', '{{ $language }}');</script>
@endif

@php
    $currentLanguage = $language ?? 'es';
@endphp

            <style>
                /* Estilo solo para PC (pantallas mayores a 768px) */
                @media (max-width: 769px) {
                    #copy-right {
                        padding-bottom: 70px !important;
                    }
                }
                
                /* Estilos para el mapa y botones del footer */
                .footer-map-container {
                    width: 100%;
                }
                
                .footer-map-buttons {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 10px;
                    margin-top: 15px;
                }
                
                .footer-nav-button {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 16px 12px;
                    border-radius: 12px;
                    text-decoration: none;
                    color: #fff;
                    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    position: relative;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    border: 1px solid transparent;
                    font-size: 0.85rem;
                    text-align: center;
                    min-height: 80px;
                }
                
                .footer-nav-button::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(
                        90deg,
                        transparent,
                        rgba(255, 255, 255, 0.2),
                        transparent
                    );
                    transition: left 0.5s ease;
                }
                
                .footer-nav-button:hover::before {
                    left: 100%;
                }
                
                .footer-nav-button:hover {
                    transform: translateY(-2px) scale(1.02);
                    text-decoration: none;
                    color: #fff;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                }
                
                .footer-nav-button:active {
                    transform: translateY(-1px) scale(1.01);
                }
                
                .footer-button-icon {
                    width: 40px;
                    height: 40px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 8px;
                    background: rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    transition: all 0.3s ease;
                }
                
                .footer-button-icon i,
                .footer-button-icon svg {
                    font-size: 20px;
                    color: #ffffff; /* Iconos blancos */
                }
                
                .footer-button-content {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                }
                
                .footer-button-title {
                    font-size: 0.9rem;
                    font-weight: 700;
                    margin-bottom: 2px;
                    display: block;
                }
                
                .footer-button-subtitle {
                    font-size: 0.7rem;
                    opacity: 0.9;
                    font-weight: 400;
                    display: block;
                    line-height: 1.2;
                }
                
                .footer-nav-button:hover .footer-button-icon {
                    background: rgba(255, 255, 255, 0.2);
                    transform: scale(1.05);
                }
                
                /* Estilo unificado para ambos botones del footer */
                .footer-nav-button.google-maps,
                .footer-nav-button.waze {
                    background: transparent; /* Fondo transparente */
                    border-color: rgba(255, 255, 255, 0.3);
                    color: #ffffff; /* Texto blanco */
                }
                
                .footer-nav-button.google-maps:hover,
                .footer-nav-button.waze:hover {
                    background: #1e40af; /* Azul marino más claro en hover */
                    box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
                    color: #ffffff; /* Mantener texto blanco en hover */
                }
                
                /* Responsive para footer */
                @media (max-width: 768px) {
                    .footer-nav-button {
                        padding: 12px 8px;
                        border-radius: 10px;
                        font-size: 0.8rem;
                        min-height: 70px;
                    }
                    
                    .footer-button-icon {
                        width: 32px;
                        height: 32px;
                        margin-bottom: 6px;
                    }
                    
                    .footer-button-icon i,
                    .footer-button-icon svg {
                        font-size: 16px;
                    }
                    
                    .footer-button-title {
                        font-size: 0.8rem;
                    }
                    
                    .footer-button-subtitle {
                        font-size: 0.65rem;
                    }
                }
                
                @media (max-width: 480px) {
                    .footer-nav-button {
                        padding: 10px 6px;
                        font-size: 0.75rem;
                        min-height: 65px;
                    }
                    
                    .footer-button-icon {
                        width: 28px;
                        height: 28px;
                        margin-bottom: 4px;
                    }
                    
                    .footer-button-icon i,
                    .footer-button-icon svg {
                        font-size: 14px;
                    }
                    
                    .footer-button-title {
                        font-size: 0.75rem;
                    }
                    
                    .footer-button-subtitle {
                        font-size: 0.6rem;
                    }
                }
            </style>


<footer>
    <!-- Inicio del Pie de Página -->
    <div class="footer-main">
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="single-footer-caption mb-30">
                            <!-- Logo -->
                            <div class="footer-logo">
                                <a href="{{ $currentLanguage === 'en' ? route('home.EN') : route('home.ES') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt="{{ $currentLanguage === 'en' ? 'Vilba Cranes Logo' : 'Logo Grúas Vilba' }}" style="height: 60px; width: auto; max-width: 200px;"></a>
                            </div>
                            <div class="footer-tittle">
                                <div class="footer-pera">
                                    <p class="info1">{{ $currentLanguage === 'en' ? 'Vilba is a company specialized in crane services with personalized attention and quick response throughout the city.' : 'Vilba empresa especializada en servicios de grúas con atención personalizada y rápida respuesta en toda la ciudad.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>{{ $currentLanguage === 'en' ? 'Quick Links' : 'Enlaces Rápidos' }}</h4>
                                <ul>
                                    <li><a href="{{ $currentLanguage === 'en' ? route('about.EN') : route('about.ES') }}">{{ $currentLanguage === 'en' ? 'About Us' : 'Nosotros' }}</a></li>
                                    <li><a href="{{ $currentLanguage === 'en' ? route('services.EN') : route('services.ES') }}">{{ $currentLanguage === 'en' ? 'Services' : 'Servicios' }}</a></li>
                                    <li><a href="#">{{ $currentLanguage === 'en' ? 'Projects' : 'Proyectos' }}</a></li>
                                    <li><a href="{{ $currentLanguage === 'en' ? route('contact.EN') : route('contact.ES') }}">{{ $currentLanguage === 'en' ? 'Contact Us' : 'Contáctanos' }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>{{ $currentLanguage === 'en' ? 'Contact' : 'Contacto' }}</h4>
                                <div class="footer-pera">
                                    <p class="info1">{{ $currentLanguage === 'en' ? 'Main Street 123, Downtown, City, State' : 'Calle Principal 123, Colonia Centro, Ciudad, Estado' }}</p>
                                </div>
                                <ul>
                                    <li><a href="#">{{ $currentLanguage === 'en' ? 'Phone: +52 (123) 456 7890' : 'Teléfono: +52 (123) 456 7890' }}</a></li>
                                    <li><a href="#">{{ $currentLanguage === 'en' ? 'Mobile: +52 (123) 987 6543' : 'Celular: +52 (123) 987 6543' }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="single-footer-caption mb-50">
                            <!-- Mapa Interactivo -->
                            <div class="map-footer">
                                <div class="footer-map-container">
                                    <!-- Mapa de Google Maps -->
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.8445194652563!2d-99.96694989999999!3d19.4191227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d2856ba145a859%3A0xdca48ae2e494098d!2sCONCRETOS%20Y%20CONSTRUCCIONES%20VILBA%20SA%20DE%20CV!5e0!3m2!1ses-419!2smx!4v1751433490665!5m2!1ses-419!2smx" 
                                        width="100%" 
                                        height="200" 
                                        style="border:0; border-radius: 12px;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                    
                                    <!-- Botones de Navegación -->
                                    <div class="footer-map-navigation mt-3">
                                        <div class="footer-map-buttons">
                                            <a href="https://www.google.com/maps/search/?api=1&query=CONCRETOS+Y+CONSTRUCCIONES+VILBA+SA+DE+CV" target="_blank" class="footer-nav-button google-maps" data-app="google">
                                                <div class="footer-button-icon">
                                                    <i class="fab fa-google"></i>
                                                </div>
                                                <div class="footer-button-content">
                                                    <span class="footer-button-title">{{ $currentLanguage === 'en' ? 'Open in Google Maps' : 'Abrir en Google Maps' }}</span>
                                                </div>
                                            </a>
                                            <a href="https://waze.com/ul?q=CONCRETOS+Y+CONSTRUCCIONES+VILBA+SA+DE+CV&navigate=yes" target="_blank" class="footer-nav-button waze" data-app="waze">
                                                <div class="footer-button-icon">
                                                    <svg style="color: white; !important; fill: currentColor;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M566.6 265.7C581.1 351.6 535.7 433.6 453.4 473.8C466.4 507.9 441 544 405.1 544C391.9 544 379.1 538.9 369.5 529.8C359.9 520.7 354.2 508.2 353.5 495C347.1 495.2 289.3 495 277.2 494.4C276.9 501.2 275.3 507.9 272.5 514C269.7 520.1 265.6 525.7 260.6 530.3C255.6 534.9 249.8 538.5 243.4 540.8C237 543.1 230.2 544.2 223.5 543.9C189.6 542.5 165.5 509.1 176.5 476C139.3 462.9 104 441.1 76.9 405.2C63.9 387.9 76.4 363.4 97.7 363.4C144 363.4 129.9 309.2 140.9 253.1C159.3 159.2 257.7 96 352.6 96C455.1 96 549.8 166.7 566.7 265.7zM437.9 452.3C479.9 433.1 519.2 395.6 534.2 350.2C574.7 227.1 470 122.2 352.5 122.2C269.1 122.2 182.2 177.6 166.4 258.2C156.9 307.1 171.4 389.6 97.7 389.6C122.6 422.7 156 442.2 191.4 453.6C216.1 431.8 255.3 438.1 271.2 467.9C285.4 468.9 350.4 469.1 359.1 468.7C362.6 461.8 367.6 455.8 373.8 451.2C380 446.6 387 443.3 394.6 441.7C402.2 440.1 410 440.3 417.5 442.1C425 443.9 432 447.4 438 452.3zM269.5 251.1C269.5 216.4 320.3 216.4 320.3 251.1C320.3 285.8 269.5 285.8 269.5 251.1zM386.1 251.1C386.1 216.4 437 216.4 437 251.1C437 285.8 386.1 285.9 386.1 251.1zM263.5 321.8C260.1 304.9 285.7 299.6 289.1 316.6L289.2 316.9C293.3 338.3 319 360.9 353.3 360C389 359.1 412.6 337.8 417.4 317.2C421.9 301.1 446 306.8 442.9 323.2C437.7 345.4 411.7 385.2 351.4 386.1C308.8 386.1 270.5 358.3 263.5 321.9L263.5 321.9z"/></svg>
                                                    <!-- Opción 3: Texto como último respaldo -->
                                                    <span class="waze-text-icon" style="display: none; font-weight: bold; font-size: 16px;">W</span>
                                                </div>
                                                <div class="footer-button-content">
                                                    <span class="footer-button-title">{{ $currentLanguage === 'en' ? 'Open in Waze' : 'Abrir en Waze' }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Derechos de autor -->
                <div id="copy-right" class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="footer-copy-right text-center">
                            <p>{{ $currentLanguage === 'en' ? 'Copyright' : 'Copyright' }} &copy;<script>document.write(new Date().getFullYear());</script> {{ $currentLanguage === 'en' ? 'All rights reserved' : 'Todos los derechos reservados' }} | <a href="#" target="_blank">Vilba</a> 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del Pie de Página -->
</footer>