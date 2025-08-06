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
                                <a href="{{ $currentLanguage === 'en' ? route('home.EN') : route('home.ES') }}"><img src="/assets/img/logo/logo.png" alt="{{ $currentLanguage === 'en' ? 'Vilba Cranes Logo' : 'Logo Grúas Vilba' }}" style="height: 60px; width: auto; max-width: 200px;"></a>
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
                                                    <span class="footer-button-title">Google Maps</span>
                                                    <span class="footer-button-subtitle">{{ $currentLanguage === 'en' ? 'Open in Google Maps' : 'Abrir en Google Maps' }}</span>
                                                </div>
                                            </a>
                                            <a href="https://waze.com/ul?q=CONCRETOS+Y+CONSTRUCCIONES+VILBA+SA+DE+CV&navigate=yes" target="_blank" class="footer-nav-button waze" data-app="waze">
                                                <div class="footer-button-icon">
                                                    <!-- Opción 1: Icono oficial de Waze con Font Awesome 6.0+ -->
                                                    <i class="fa-brands fa-waze waze-fa-icon"></i>
                                                    <!-- Opción 2: SVG oficial de Waze como respaldo -->
                                                    <svg class="waze-svg-icon" style="display: none;" width="20" height="20" viewBox="0 0 512 512" fill="currentColor">
                                                        <path d="M502.17 201.67C516.69 287.53 471.23 369.59 389 409.8c13 34.1-12.4 70.2-48.32 70.2a51.68 51.68 0 0 1-51.57-49c-6.44.19-64.2 0-76.33-.64A51.69 51.69 0 0 1 159 479.9c-33.86-1.36-57.95-34.84-47-67.92-37.9-13.9-72.5-36.8-100.33-68.39-34.3-38.9-55.25-90.78-55.25-145.27C-43.45 84.47 81.25-16.5 187.79 5.86a196.14 196.14 0 0 1 129.52 85.85c18.53-11.09 40.72-17.64 64.59-17.64C447.48 74.07 497.61 130.69 502.17 201.67zM316.08 82.71a153.11 153.11 0 0 0-110.79-34.49c-83.53-13.47-166.31 36.06-166.31 149.44 0 107.28 84.69 194.61 189.21 194.61 104.06 0 188.78-87.33 188.78-194.61 0-65.67-32.77-124.5-84.12-158.95a140.44 140.44 0 0 0-16.77 44z"/>
                                                    </svg>
                                                    <!-- Opción 3: Texto como último respaldo -->
                                                    <span class="waze-text-icon" style="display: none; font-weight: bold; font-size: 16px;">W</span>
                                                </div>
                                                <div class="footer-button-content">
                                                    <span class="footer-button-title">Waze</span>
                                                    <span class="footer-button-subtitle">{{ $currentLanguage === 'en' ? 'Open in Waze' : 'Abrir en Waze' }}</span>
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