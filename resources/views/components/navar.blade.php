@props(['language' => 'es'])

<!-- Debug: Language value = {{ $language }} -->
@if(config('app.debug'))
    <script>console.log('🔍 Navbar Language Debug:', '{{ $language }}');</script>
@endif

@php
    $currentLanguage = $language ?? 'es';
@endphp

<!-- Preloader Start -->
    <header>
        <!-- Inicio del Encabezado -->
        <div class="header-area header-transparent">
            <div class="main-header">
                <!-- <div class="header-top d-none d-lg-block">
                    <div class="container-fluid">
                        <div class="col-xl-12">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="header-info-left">
                                    <ul>     
                                        <li>+(123) 1234-567-8901</li>
                                        <li>info@domain.com</li>
                                        <li>Lun - Sáb 8:00 - 17:30, Domingo - CERRADO</li>
                                    </ul>
                                </div>
                                <div class="header-info-right">
                                    <ul class="header-social">    
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="header-bottom header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2 col-md-1">
                                <div class="logo">
                                    <!-- logo-1 -->
                                    <a href="{{ route('home') }}" class="big-logo">
                                        <img id="logo-big" src="assets/img/logo/logo.png" alt="" style="height: 80px; width: auto; max-width: 400px; margin-left: -60px;">
                                    </a>
                                    <!-- logo-2 -->
                                    <a href="{{ route('home') }}" class="small-logo">
                                        <img id="logo-small" src="assets/img/logo/logo.png" alt="" style="height: 60px; width: auto; max-width: 280px; margin-left: -60px;">
                                    </a>
                                    
                                    <!-- CSS específico para móviles -->
                                    <style>
                                        @media (max-width: 768px) {
                                            #logo-big, #logo-small {
                                                margin-left: -10px !important;
                                            }
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-7">
                                <!-- Menú principal -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav> 
                                        <ul id="navigation">                                                                                                                   
                                            <li><a href="{{ $currentLanguage === 'en' ? route('home.EN') : route('home.ES') }}" data-translate="home">{{ $currentLanguage === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                            <li><a href="{{ $currentLanguage === 'en' ? route('about.EN') : route('about.ES') }}" data-translate="about">{{ $currentLanguage === 'en' ? 'About Us' : 'Nosotros' }}</a></li>
                                            <li><a href="#" data-translate="projects">{{ $currentLanguage === 'en' ? 'Projects' : 'Proyectos' }}</a></li>
                                            <li><a href="{{ $currentLanguage === 'en' ? route('services.EN') : route('services.ES') }}" data-translate="services">{{ $currentLanguage === 'en' ? 'Services' : 'Servicios' }}</a></li>
                                        
                                            <li><a href="javascript:void(0)" data-translate="language">{{ $currentLanguage === 'en' ? 'Language' : 'Idioma' }}</a>
                                                <ul class="submenu">
                                                    <li>
                                        <a href="javascript:void(0)" onclick="changeLanguage('es')" @if($currentLanguage === 'es') style="font-weight: bold; color: #ff6b35;" @endif>
                                            <img src="{{ asset('assets/images/flags/mx.svg') }}" alt="Español" class="flag-icon me-2" style="width: 16px; height: auto; margin-right: 8px;">
                                            Español
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="changeLanguage('en')" @if($currentLanguage === 'en') style="font-weight: bold; color: #ff6b35;" @endif>
                                            <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English" class="flag-icon me-2" style="width: 16px; height: auto; margin-right: 8px;">
                                            English
                                        </a>
                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ $currentLanguage === 'en' ? route('contact.EN') : route('contact.ES') }}" data-translate="contact">{{ $currentLanguage === 'en' ? 'Contact' : 'Contacto' }}</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>             
                            <div class="col-xl-3 col-lg-3 col-md-4">
                                <div class="header-right-content d-flex align-items-center justify-content-end">
                                    <!-- Botón de contacto -->
                                    <div class="header-right-btn d-none d-lg-block">
                                        <a href="{{ $currentLanguage === 'en' ? route('contact.EN') : route('contact.ES') }}" class="btn" data-translate="contact_btn">{{ $currentLanguage === 'en' ? 'Contact Us' : 'Contáctanos' }}</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Menú Móvil -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin del Encabezado -->
    </header>
    
    <!-- Script para cambio de idioma dinámico -->
    <script>
        function changeLanguage(language) {
            // Obtener la URL actual
            const currentUrl = window.location.href;
            
            // Crear un formulario temporal para enviar la solicitud POST
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cambiar-idioma/' + language;
            
            // Agregar token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Agregar la URL actual como parámetro
            const currentUrlInput = document.createElement('input');
            currentUrlInput.type = 'hidden';
            currentUrlInput.name = 'current_url';
            currentUrlInput.value = currentUrl;
            form.appendChild(currentUrlInput);
            
            // Agregar el formulario al DOM y enviarlo
            document.body.appendChild(form);
            form.submit();
        }
    </script>