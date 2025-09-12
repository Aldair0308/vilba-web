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
                
                /* Responsive específico para tablets (768px - 1024px) */
                @media (min-width: 768px) and (max-width: 1024px) {
                    .footer-area {
                        padding: 60px 0 40px;
                    }
                    
                    .footer-area .container {
                        max-width: 95%;
                    }
                    
                    .footer-area .row {
                        margin: 0 -10px;
                    }
                    
                    .footer-area .row > [class*="col-"] {
                        padding: 0 10px;
                        margin-bottom: 40px;
                    }
                    
                    /* Logo y descripción más compactos */
                    .footer-logo img {
                        height: 50px !important;
                        max-width: 180px !important;
                    }
                    
                    .footer-pera p.info1 {
                        font-size: 0.9rem;
                        line-height: 1.5;
                        margin-bottom: 20px;
                    }
                    
                    /* Enlaces rápidos más organizados */
                    .footer-tittle h4 {
                        font-size: 1.1rem;
                        margin-bottom: 20px;
                        color: #fff;
                        font-weight: 600;
                    }
                    
                    .footer-tittle ul {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 8px 15px;
                        margin: 0;
                        padding: 0;
                    }
                    
                    .footer-tittle ul li {
                        margin-bottom: 8px;
                    }
                    
                    .footer-tittle ul li a {
                        font-size: 0.85rem;
                        padding: 5px 0;
                        display: block;
                        transition: all 0.3s ease;
                    }
                    
                    /* Sección de contacto optimizada */
                    .single-footer-caption:nth-child(3) .footer-pera p.info1 {
                        font-size: 0.8rem;
                        line-height: 1.4;
                        margin-bottom: 15px;
                    }
                    
                    .single-footer-caption:nth-child(3) ul {
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                    }
                    
                    .single-footer-caption:nth-child(3) ul li a {
                        font-size: 0.8rem;
                        padding: 3px 0;
                    }
                    
                    /* Mapa y navegación rediseñados para tablets */
                    .footer-map-container {
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 15px;
                        padding: 20px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }
                    
                    .footer-map-container iframe {
                        height: 180px !important;
                        border-radius: 10px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    }
                    
                    .footer-map-buttons {
                        display: flex;
                        gap: 12px;
                        margin-top: 20px;
                    }
                    
                    .footer-nav-button {
                        flex: 1;
                        padding: 14px 10px;
                        border-radius: 10px;
                        font-size: 0.8rem;
                        min-height: 75px;
                        background: rgba(255, 255, 255, 0.08);
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        backdrop-filter: blur(10px);
                    }
                    
                    .footer-nav-button:hover {
                        background: rgba(30, 64, 175, 0.8);
                        transform: translateY(-1px);
                        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
                    }
                    
                    .footer-button-icon {
                        width: 36px;
                        height: 36px;
                        margin-bottom: 6px;
                        background: rgba(255, 255, 255, 0.15);
                    }
                    
                    .footer-button-icon i,
                    .footer-button-icon svg,
                    .footer-button-icon img {
                        font-size: 18px;
                    }
                    
                    .footer-button-title {
                        font-size: 0.85rem;
                        font-weight: 600;
                    }
                    
                    .footer-button-subtitle {
                        font-size: 0.7rem;
                        opacity: 0.85;
                    }
                    
                    /* Copyright optimizado */
                    #copy-right {
                        margin-top: 30px;
                        padding-top: 25px;
                        border-top: 1px solid rgba(255, 255, 255, 0.1);
                    }
                    
                    .footer-copy-right p {
                        font-size: 0.85rem;
                        margin: 0;
                    }
                }
                
                /* Responsive para móviles (mantener existente) */
                @media (max-width: 767px) {
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
                                    <p class="info1">{{ $currentLanguage === 'en' ? 'Av. Insurgentes Sur 1234, Col. Del Valle, Benito Juárez, CDMX, México' : 'Av. Insurgentes Sur 1234, Col. Del Valle, Benito Juárez, CDMX, México' }}</p>
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
                                                    <img src="{{ asset('assets/img/logo/waze.png') }}" alt="Waze" class="waze-png-icon" width="20" height="20" style="filter: brightness(0) invert(1); object-fit: contain; vertical-align: middle;">
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

<script>
// Script para optimizar la visualización del icono de Waze
document.addEventListener('DOMContentLoaded', function() {
    const wazeButton = document.querySelector('.footer-nav-button.waze');
    if (!wazeButton) return;
    
    const pngIcon = wazeButton.querySelector('.waze-png-icon');
    const faIcon = wazeButton.querySelector('.waze-fa-icon');
    const textIcon = wazeButton.querySelector('.waze-text-icon');
    
    // Función para manejar la carga de la imagen
    function handleImageLoad() {
        if (pngIcon && pngIcon.complete && pngIcon.naturalHeight !== 0) {
            // La imagen PNG se cargó correctamente
            pngIcon.style.display = 'inline-block';
            if (faIcon) faIcon.style.display = 'none';
            if (textIcon) textIcon.style.display = 'none';
        } else {
            // Fallback a Font Awesome o texto
            if (pngIcon) pngIcon.style.display = 'none';
            if (faIcon) {
                faIcon.style.display = 'inline-block';
                if (textIcon) textIcon.style.display = 'none';
            } else if (textIcon) {
                textIcon.style.display = 'inline-block';
            }
        }
    }
    
    // Ejecutar inmediatamente
    handleImageLoad();
    
    // Escuchar eventos de carga de la imagen
    if (pngIcon) {
        pngIcon.addEventListener('load', handleImageLoad);
        pngIcon.addEventListener('error', handleImageLoad);
    }
});
</script>
