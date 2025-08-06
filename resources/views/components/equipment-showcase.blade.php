<!-- Equipment Showcase Area Start -->
<div class="services-area1 section-padding30">
    <div class="container">
        <!-- Título de la sección -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle mb-55">
                    <div class="front-text">
                        <h2 class="" data-translate="our_equipment_title">
                            {{ $currentLanguage === 'en' ? 'Our Equipment' : 'Nuestros Equipos' }}
                        </h2>
                    </div>
                    <span class="back-text" data-translate="equipment_back">
                        {{ $currentLanguage === 'en' ? 'Equipment' : 'Equipos' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($equipments as $equipment)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="single-service-cap mb-30">
                    <div class="service-img">
                        <img src="{{ $equipment['hero_image'] }}" alt="{{ $equipment['name'][$currentLanguage] }}">
                    </div>
                    <div class="service-cap">
                        <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', $equipment['slug']) : route('equipos.detail.ES', $equipment['slug']) }}">{{ $equipment['name'][$currentLanguage] }}</a></h4>
                        
                        <p class="equipment-description">{{ $equipment['description'][$currentLanguage] }}</p>
                        
                        <a href="{{ session('language') === 'en' ? route('equipos.detail.EN', $equipment['slug']) : route('equipos.detail.ES', $equipment['slug']) }}" class="more-btn" data-translate="read_more">
                            {{ $currentLanguage === 'es' ? 'Leer más' : 'Read more' }} <i class="ti-plus"></i>
                        </a>
                    </div>
                    <div class="service-icon">
                        <img src="{{ url('/assets/img/icon/services_icon1.png') }}" alt="">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Ver todos los equipos button -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{ session('language') === 'en' ? route('equipos.EN') : route('equipos.ES') }}" class="btn red-btn2 mt-30">
                    {{ $currentLanguage === 'es' ? 'Ver Todos los Equipos' : 'View All Equipment' }}
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Equipment Showcase Area End -->