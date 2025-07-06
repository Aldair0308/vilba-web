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
                            <!-- Formulario de suscripción -->
                            <div class="footer-form">
                                <div id="mc_embed_signup">
                                    <form target="_blank" action="#" method="get" class="subscribe_form relative mail_part" novalidate="true">
                                        <input type="email" name="EMAIL" id="newsletter-form-email" placeholder="{{ $currentLanguage === 'en' ? 'Email address' : 'Correo electrónico' }}" class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ $currentLanguage === 'en' ? 'Email address' : 'Correo electrónico' }}'">
                                        <div class="form-icon">
                                            <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm">
                                                {{ $currentLanguage === 'en' ? 'SUBSCRIBE' : 'SUSCRIBIRSE' }}
                                            </button>
                                        </div>
                                        <div class="mt-10 info"></div>
                                    </form>
                                </div>
                            </div>
                            <!-- Mapa -->
                            <div class="map-footer">
                                <img src="{{ asset('assets/img/gallery/map-footer.png') }}" alt="{{ $currentLanguage === 'en' ? 'Location map' : 'Mapa de ubicación' }}">
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