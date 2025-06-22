<!doctype html>
<html class="no-js" lang="{{ session('language', 'es') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ session('language') === 'en' ? 'Equipment - Vilba Construction' : 'Equipos - Vilba Construcción' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Header End -->
    </header>
    <!-- slider Area Start-->
    <div class="slider-area ">
        <div class="single-slider hero-overly slider-height2 d-flex align-items-center" style="background-image: url('{{ asset('assets/img/hero/about.jpg') }}');">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap pt-100">
                            <h2>{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</h2>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ session('language') === 'en' ? route('home.EN') : route('home') }}">{{ session('language') === 'en' ? 'Home' : 'Inicio' }}</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    
    @php
        $equipments = [
            [
                'slug' => 'gruas-torre',
                'name' => [
                    'es' => 'Grúas Torre',
                    'en' => 'Tower Cranes'
                ],
                'description' => [
                    'es' => 'Grúas torre de alta capacidad para proyectos de construcción de todos los tamaños. Perfectas para elevar materiales pesados a grandes alturas con precisión y seguridad.',
                    'en' => 'High-capacity tower cranes for construction projects of all sizes. Perfect for lifting heavy materials to great heights with precision and safety.'
                ],
                'image' => 'assets/img/service/servicess1.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 5-25 toneladas',
                        'Altura: Hasta 80m',
                        'Operadores profesionales incluidos'
                    ],
                    'en' => [
                        'Capacity: 5-25 tons',
                        'Height: Up to 80m',
                        'Professional operators included'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras grúas torre representan la vanguardia en tecnología de elevación para la construcción. Diseñadas para proyectos de gran envergadura, estas máquinas ofrecen una combinación perfecta de potencia, precisión y seguridad.',
                        'features' => [
                            'Sistema de control computarizado avanzado',
                            'Cabina ergonómica con aire acondicionado',
                            'Sistema anti-colisión integrado',
                            'Monitoreo en tiempo real de cargas',
                            'Certificaciones internacionales de seguridad'
                        ],
                        'applications' => [
                            'Construcción de edificios residenciales',
                            'Proyectos comerciales e industriales',
                            'Infraestructura urbana',
                            'Montaje de estructuras prefabricadas'
                        ],
                        'technical_specs' => [
                            'Capacidad máxima: 25 toneladas',
                            'Altura máxima: 80 metros',
                            'Radio de trabajo: 60 metros',
                            'Velocidad de elevación: 120 m/min',
                            'Alimentación: 380V/50Hz'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our tower cranes represent the cutting edge in construction lifting technology. Designed for large-scale projects, these machines offer a perfect combination of power, precision, and safety.',
                        'features' => [
                            'Advanced computerized control system',
                            'Ergonomic cabin with air conditioning',
                            'Integrated anti-collision system',
                            'Real-time load monitoring',
                            'International safety certifications'
                        ],
                        'applications' => [
                            'Residential building construction',
                            'Commercial and industrial projects',
                            'Urban infrastructure',
                            'Prefabricated structure assembly'
                        ],
                        'technical_specs' => [
                            'Maximum capacity: 25 tons',
                            'Maximum height: 80 meters',
                            'Working radius: 60 meters',
                            'Lifting speed: 120 m/min',
                            'Power supply: 380V/50Hz'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/crane1.jpg',
                    'assets/img/gallery/crane2.jpg',
                    'assets/img/gallery/crane3.jpg'
                ]
            ],
            [
                'slug' => 'gruas-moviles',
                'name' => [
                    'es' => 'Grúas Móviles',
                    'en' => 'Mobile Cranes'
                ],
                'description' => [
                    'es' => 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible. Ideales para proyectos que requieren movilidad y despliegue rápido.',
                    'en' => 'Versatile mobile cranes for quick setup and flexible positioning. Ideal for projects requiring mobility and rapid deployment.'
                ],
                'image' => 'assets/img/service/servicess2.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 10-100 toneladas',
                        'Capacidad todo terreno',
                        'Tiempo de montaje rápido'
                    ],
                    'en' => [
                        'Capacity: 10-100 tons',
                        'All-terrain capability',
                        'Quick setup time'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras grúas móviles ofrecen la máxima flexibilidad para proyectos que requieren movilidad constante. Con capacidades desde 10 hasta 100 toneladas, son perfectas para una amplia gama de aplicaciones.',
                        'features' => [
                            'Chasis todo terreno 4x4',
                            'Pluma telescópica de alta resistencia',
                            'Sistema de estabilización automática',
                            'Cabina giratoria 360°',
                            'Sistema de control Load Moment Indicator'
                        ],
                        'applications' => [
                            'Montaje industrial',
                            'Mantenimiento de infraestructura',
                            'Proyectos de emergencia',
                            'Trabajos en espacios reducidos'
                        ],
                        'technical_specs' => [
                            'Capacidad: 10-100 toneladas',
                            'Longitud de pluma: 12-60 metros',
                            'Velocidad máxima: 80 km/h',
                            'Motor: Diesel 6 cilindros',
                            'Tiempo de montaje: 15 minutos'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our mobile cranes offer maximum flexibility for projects requiring constant mobility. With capacities from 10 to 100 tons, they are perfect for a wide range of applications.',
                        'features' => [
                            '4x4 all-terrain chassis',
                            'High-strength telescopic boom',
                            'Automatic stabilization system',
                            '360° rotating cabin',
                            'Load Moment Indicator control system'
                        ],
                        'applications' => [
                            'Industrial assembly',
                            'Infrastructure maintenance',
                            'Emergency projects',
                            'Work in confined spaces'
                        ],
                        'technical_specs' => [
                            'Capacity: 10-100 tons',
                            'Boom length: 12-60 meters',
                            'Maximum speed: 80 km/h',
                            'Engine: 6-cylinder Diesel',
                            'Setup time: 15 minutes'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/mobile1.jpg',
                    'assets/img/gallery/mobile2.jpg',
                    'assets/img/gallery/mobile3.jpg'
                ]
            ],
            [
                'slug' => 'montacargas',
                'name' => [
                    'es' => 'Montacargas',
                    'en' => 'Forklifts'
                ],
                'description' => [
                    'es' => 'Montacargas eléctricos y diésel para manejo de materiales y operaciones de almacén. Disponibles en varias capacidades para uso interior y exterior.',
                    'en' => 'Electric and diesel forklifts for material handling and warehouse operations. Available in various capacities for indoor and outdoor use.'
                ],
                'image' => 'assets/img/service/servicess3.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 1.5-10 toneladas',
                        'Opciones eléctricas y diésel',
                        'Modelos interior/exterior'
                    ],
                    'en' => [
                        'Capacity: 1.5-10 tons',
                        'Electric & diesel options',
                        'Indoor/outdoor models'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestra flota de montacargas incluye modelos eléctricos y diésel para satisfacer todas las necesidades de manejo de materiales. Desde operaciones de almacén hasta trabajos pesados en exteriores.',
                        'features' => [
                            'Transmisión hidrostática',
                            'Mástil de elevación triple',
                            'Asiento ergonómico ajustable',
                            'Sistema de dirección asistida',
                            'Luces LED de trabajo'
                        ],
                        'applications' => [
                            'Operaciones de almacén',
                            'Carga y descarga de camiones',
                            'Manejo de materiales de construcción',
                            'Logística industrial'
                        ],
                        'technical_specs' => [
                            'Capacidad: 1.5-10 toneladas',
                            'Altura de elevación: 3-6 metros',
                            'Velocidad: 20 km/h',
                            'Radio de giro: 2.3 metros',
                            'Autonomía (eléctrico): 8 horas'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our forklift fleet includes electric and diesel models to meet all material handling needs. From warehouse operations to heavy outdoor work.',
                        'features' => [
                            'Hydrostatic transmission',
                            'Triple lift mast',
                            'Adjustable ergonomic seat',
                            'Power steering system',
                            'LED work lights'
                        ],
                        'applications' => [
                            'Warehouse operations',
                            'Truck loading and unloading',
                            'Construction material handling',
                            'Industrial logistics'
                        ],
                        'technical_specs' => [
                            'Capacity: 1.5-10 tons',
                            'Lift height: 3-6 meters',
                            'Speed: 20 km/h',
                            'Turning radius: 2.3 meters',
                            'Battery life (electric): 8 hours'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/forklift1.jpg',
                    'assets/img/gallery/forklift2.jpg',
                    'assets/img/gallery/forklift3.jpg'
                ]
            ],
            [
                'slug' => 'plataformas-elevadoras',
                'name' => [
                    'es' => 'Plataformas Elevadoras',
                    'en' => 'Aerial Platforms'
                ],
                'description' => [
                    'es' => 'Plataformas tijera y articuladas para acceso a trabajos en altura. Soluciones seguras y eficientes para tareas de mantenimiento, instalación y construcción.',
                    'en' => 'Scissor lifts and boom lifts for elevated work access. Safe and efficient solutions for maintenance, installation, and construction tasks.'
                ],
                'image' => 'assets/img/service/servicess4.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Altura: 6-30 metros',
                        'Modelos eléctricos y diésel',
                        'Uso interior/exterior'
                    ],
                    'en' => [
                        'Height: 6-30 meters',
                        'Electric & diesel models',
                        'Indoor/outdoor use'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras plataformas elevadoras proporcionan acceso seguro a trabajos en altura. Disponemos de modelos tijera y articulados para diferentes tipos de aplicaciones.',
                        'features' => [
                            'Plataforma antideslizante',
                            'Barandillas de seguridad',
                            'Control proporcional suave',
                            'Sistema de nivelación automática',
                            'Alarma de sobrecarga'
                        ],
                        'applications' => [
                            'Mantenimiento de edificios',
                            'Instalaciones eléctricas',
                            'Trabajos de pintura',
                            'Limpieza de fachadas'
                        ],
                        'technical_specs' => [
                            'Altura de trabajo: 6-30 metros',
                            'Capacidad de carga: 230-450 kg',
                            'Velocidad de elevación: 40 cm/s',
                            'Dimensiones de plataforma: 2.3x1.1m',
                            'Peso: 1500-4500 kg'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our aerial platforms provide safe access to elevated work. We have scissor and articulated models for different types of applications.',
                        'features' => [
                            'Non-slip platform',
                            'Safety railings',
                            'Smooth proportional control',
                            'Automatic leveling system',
                            'Overload alarm'
                        ],
                        'applications' => [
                            'Building maintenance',
                            'Electrical installations',
                            'Painting work',
                            'Facade cleaning'
                        ],
                        'technical_specs' => [
                            'Working height: 6-30 meters',
                            'Load capacity: 230-450 kg',
                            'Lifting speed: 40 cm/s',
                            'Platform dimensions: 2.3x1.1m',
                            'Weight: 1500-4500 kg'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/platform1.jpg',
                    'assets/img/gallery/platform2.jpg',
                    'assets/img/gallery/platform3.jpg'
                ]
            ],
            [
                'slug' => 'excavadoras',
                'name' => [
                    'es' => 'Excavadoras',
                    'en' => 'Excavators'
                ],
                'description' => [
                    'es' => 'Excavadoras de trabajo pesado para movimiento de tierra, demolición y proyectos de construcción. Disponibles en varios tamaños para diferentes requisitos de proyecto.',
                    'en' => 'Heavy-duty excavators for earthmoving, demolition, and construction projects. Available in various sizes for different project requirements.'
                ],
                'image' => 'assets/img/service/servicess5.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 5-50 toneladas',
                        'Múltiples accesorios',
                        'Operadores experimentados'
                    ],
                    'en' => [
                        'Weight: 5-50 tons',
                        'Multiple attachments',
                        'Experienced operators'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras excavadoras están diseñadas para los trabajos más exigentes. Desde mini excavadoras para espacios reducidos hasta grandes máquinas para proyectos de infraestructura.',
                        'features' => [
                            'Motor de alta eficiencia',
                            'Sistema hidráulico avanzado',
                            'Cabina ROPS/FOPS certificada',
                            'Múltiples accesorios intercambiables',
                            'Sistema de monitoreo inteligente'
                        ],
                        'applications' => [
                            'Excavación y movimiento de tierra',
                            'Demolición controlada',
                            'Construcción de carreteras',
                            'Proyectos de urbanización'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 5-50 toneladas',
                            'Potencia del motor: 75-400 HP',
                            'Capacidad del cucharón: 0.3-3.2 m³',
                            'Alcance máximo: 6-12 metros',
                            'Profundidad de excavación: 4-8 metros'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our excavators are designed for the most demanding jobs. From mini excavators for confined spaces to large machines for infrastructure projects.',
                        'features' => [
                            'High-efficiency engine',
                            'Advanced hydraulic system',
                            'ROPS/FOPS certified cabin',
                            'Multiple interchangeable attachments',
                            'Intelligent monitoring system'
                        ],
                        'applications' => [
                            'Excavation and earthmoving',
                            'Controlled demolition',
                            'Road construction',
                            'Urbanization projects'
                        ],
                        'technical_specs' => [
                            'Operating weight: 5-50 tons',
                            'Engine power: 75-400 HP',
                            'Bucket capacity: 0.3-3.2 m³',
                            'Maximum reach: 6-12 meters',
                            'Digging depth: 4-8 meters'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/excavator1.jpg',
                    'assets/img/gallery/excavator2.jpg',
                    'assets/img/gallery/excavator3.jpg'
                ]
            ],
            [
                'slug' => 'equipos-especializados',
                'name' => [
                    'es' => 'Equipos Especializados',
                    'en' => 'Specialized Equipment'
                ],
                'description' => [
                    'es' => 'Maquinaria personalizada y especializada para requisitos únicos de proyecto. Incluyendo bombas de concreto, hincadoras de pilotes y otros equipos especializados de construcción.',
                    'en' => 'Custom and specialized machinery for unique project requirements. Including concrete pumps, pile drivers, and other specialized construction equipment.'
                ],
                'image' => 'assets/img/service/servicess6.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Soluciones personalizadas',
                        'Última tecnología',
                        'Consultoría experta'
                    ],
                    'en' => [
                        'Custom solutions',
                        'Latest technology',
                        'Expert consultation'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Contamos con equipos especializados para proyectos únicos que requieren soluciones específicas. Nuestro inventario incluye maquinaria de última generación para aplicaciones especiales.',
                        'features' => [
                            'Tecnología de vanguardia',
                            'Configuraciones personalizadas',
                            'Soporte técnico especializado',
                            'Mantenimiento preventivo',
                            'Capacitación de operadores'
                        ],
                        'applications' => [
                            'Bombeo de concreto',
                            'Hincado de pilotes',
                            'Perforación especializada',
                            'Proyectos de infraestructura compleja'
                        ],
                        'technical_specs' => [
                            'Variedad de especializaciones',
                            'Configuración según proyecto',
                            'Tecnología adaptativa',
                            'Soporte 24/7',
                            'Certificaciones especiales'
                        ]
                    ],
                    'en' => [
                        'description' => 'We have specialized equipment for unique projects that require specific solutions. Our inventory includes state-of-the-art machinery for special applications.',
                        'features' => [
                            'Cutting-edge technology',
                            'Custom configurations',
                            'Specialized technical support',
                            'Preventive maintenance',
                            'Operator training'
                        ],
                        'applications' => [
                            'Concrete pumping',
                            'Pile driving',
                            'Specialized drilling',
                            'Complex infrastructure projects'
                        ],
                        'technical_specs' => [
                            'Variety of specializations',
                            'Project-based configuration',
                            'Adaptive technology',
                            '24/7 support',
                            'Special certifications'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/specialized1.jpg',
                    'assets/img/gallery/specialized2.jpg',
                    'assets/img/gallery/specialized3.jpg'
                ]
            ]
        ];
        $currentLang = session('language', 'es');
    @endphp

    <!-- Equipment Section Start -->
    <section class="services-area1 section-padding30">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle mb-55">
                        <div class="front-text">
                            <h2 class="">{{ session('language') === 'en' ? 'Our Equipment Fleet' : 'Nuestra Flota de Equipos' }}</h2>
                        </div>
                        <span class="back-text">{{ session('language') === 'en' ? 'Equipment' : 'Equipos' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Equipment Grid -->
            <div class="row">
                <!-- Crane Equipment -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess1.png') }}" alt="Grúas">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'tower-cranes') : route('equipos.detail.ES', 'gruas-torre') }}">{{ session('language') === 'en' ? 'Tower Cranes' : 'Grúas Torre' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'High-capacity tower cranes for construction projects of all sizes. Perfect for lifting heavy materials to great heights with precision and safety.' : 'Grúas torre de alta capacidad para proyectos de construcción de todos los tamaños. Perfectas para elevar materiales pesados a grandes alturas con precisión y seguridad.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 5-25 tons' : 'Capacidad: 5-25 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Height: Up to 80m' : 'Altura: Hasta 80m' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Professional operators included' : 'Operadores profesionales incluidos' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Cranes -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess2.png') }}" alt="Grúas Móviles">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'mobile-cranes') : route('equipos.detail.ES', 'gruas-moviles') }}">{{ session('language') === 'en' ? 'Mobile Cranes' : 'Grúas Móviles' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Versatile mobile cranes for quick setup and flexible positioning. Ideal for projects requiring mobility and rapid deployment.' : 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible. Ideales para proyectos que requieren movilidad y despliegue rápido.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 10-100 tons' : 'Capacidad: 10-100 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'All-terrain capability' : 'Capacidad todo terreno' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Quick setup time' : 'Tiempo de montaje rápido' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Forklifts -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess3.png') }}" alt="Montacargas">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'forklifts') : route('equipos.detail.ES', 'montacargas') }}">{{ session('language') === 'en' ? 'Forklifts' : 'Montacargas' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Electric and diesel forklifts for material handling and warehouse operations. Available in various capacities for indoor and outdoor use.' : 'Montacargas eléctricos y diésel para manejo de materiales y operaciones de almacén. Disponibles en varias capacidades para uso interior y exterior.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Capacity: 1.5-10 tons' : 'Capacidad: 1.5-10 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Electric & diesel options' : 'Opciones eléctricas y diésel' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Indoor/outdoor models' : 'Modelos interior/exterior' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Aerial Platforms -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess4.png') }}" alt="Plataformas Elevadoras">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'aerial-platforms') : route('equipos.detail.ES', 'plataformas-elevadoras') }}">{{ session('language') === 'en' ? 'Aerial Platforms' : 'Plataformas Elevadoras' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Scissor lifts and boom lifts for elevated work access. Safe and efficient solutions for maintenance, installation, and construction tasks.' : 'Plataformas tijera y articuladas para acceso a trabajos en altura. Soluciones seguras y eficientes para tareas de mantenimiento, instalación y construcción.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Height: 6-30 meters' : 'Altura: 6-30 metros' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Electric & diesel models' : 'Modelos eléctricos y diésel' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Indoor/outdoor use' : 'Uso interior/exterior' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Excavators -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess5.png') }}" alt="Excavadoras">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'excavators') : route('equipos.detail.ES', 'excavadoras') }}">{{ session('language') === 'en' ? 'Excavators' : 'Excavadoras' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Heavy-duty excavators for earthmoving, demolition, and construction projects. Available in various sizes for different project requirements.' : 'Excavadoras de trabajo pesado para movimiento de tierra, demolición y proyectos de construcción. Disponibles en varios tamaños para diferentes requisitos de proyecto.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Weight: 5-50 tons' : 'Peso: 5-50 toneladas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Multiple attachments' : 'Múltiples accesorios' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Experienced operators' : 'Operadores experimentados' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Specialized Equipment -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/service/servicess6.png') }}" alt="Equipos Especializados">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', 'specialized-equipment') : route('equipos.detail.ES', 'equipos-especializados') }}">{{ session('language') === 'en' ? 'Specialized Equipment' : 'Equipos Especializados' }}</a></h4>
                            <p>{{ session('language') === 'en' ? 'Custom and specialized machinery for unique project requirements. Including concrete pumps, pile drivers, and other specialized construction equipment.' : 'Maquinaria personalizada y especializada para requisitos únicos de proyecto. Incluyendo bombas de concreto, hincadoras de pilotes y otros equipos especializados de construcción.' }}</p>
                            <ul class="equipment-specs">
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Custom solutions' : 'Soluciones personalizadas' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Latest technology' : 'Última tecnología' }}</li>
                                <li><i class="ti-check"></i> {{ session('language') === 'en' ? 'Expert consultation' : 'Consultoría experta' }}</li>
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset('assets/img/icon/services_icon1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Equipment Section End -->
    
    <!-- Why Choose Our Equipment Section Start -->
    <section class="support-company-area fix pt-10">
        <div class="support-wrapper align-items-end">
            <div class="left-content">
                <!-- Section Title -->
                <div class="section-tittle section-tittle2 mb-55">
                    <div class="front-text">
                        <h2 class="">{{ session('language') === 'en' ? 'Why Choose Our Equipment?' : '¿Por qué elegir nuestros equipos?' }}</h2>
                    </div>
                    <span class="back-text">{{ session('language') === 'en' ? 'Quality' : 'Calidad' }}</span>
                </div>
                <div class="support-caption">
                    <p class="pera-top">
                        {{ session('language') === 'en' ? 'At VILBA, we maintain the highest standards for our equipment fleet. All our machinery undergoes regular maintenance and safety inspections to ensure optimal performance and reliability on your projects.' : 'En VILBA, mantenemos los más altos estándares para nuestra flota de equipos. Toda nuestra maquinaria se somete a mantenimiento regular e inspecciones de seguridad para garantizar un rendimiento óptimo y confiabilidad en sus proyectos.' }}
                    </p>
                    <p>
                        {{ session('language') === 'en' ? 'Our experienced team provides comprehensive support, from equipment selection to on-site operation. We ensure that you have the right equipment for your specific needs, backed by our commitment to safety and efficiency.' : 'Nuestro equipo experimentado brinda soporte integral, desde la selección de equipos hasta la operación en sitio. Nos aseguramos de que tenga el equipo adecuado para sus necesidades específicas, respaldado por nuestro compromiso con la seguridad y eficiencia.' }}
                    </p>
                    <a href="{{ session('language') === 'en' ? route('contact.EN') : route('contact.ES') }}" class="btn red-btn2">{{ session('language') === 'en' ? 'Request Quote' : 'Solicitar Cotización' }}</a>
                </div>
            </div>
            <div class="right-content">
                <!-- Image -->
                <div class="right-img">
                    <img src="{{ asset('assets/img/gallery/safe_in.png') }}" alt="">
                </div>
                <div class="support-img-cap text-center">
                    <span>30+</span>
                    <p>{{ session('language') === 'en' ? 'Years Experience' : 'Años de Experiencia' }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose Our Equipment Section End -->
    
    <!-- Footer Component -->
    <x-footer :language="$language ?? 'es'" />
    
    <!-- WhatsApp Button Component -->
    <x-whatsapp-button 
        phone="+525512345678" 
        :language="session('language') ?? 'es'" 
        :message="session('language') === 'en' ? 'Hello! I would like more information about your equipment rental services.' : 'Hola! Me gustaría obtener más información sobre sus servicios de renta de equipos.'" 
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

    <!-- Custom CSS for Equipment Specs -->
    <style>
        .equipment-specs {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }
        
        .equipment-specs li {
            padding: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .equipment-specs li i {
            color: #ff6b35;
            margin-right: 8px;
        }
        
        .single-service-cap {
            transition: transform 0.3s ease;
        }
        
        .single-service-cap:hover {
            transform: translateY(-5px);
        }
        
        .service-cap h4 {
            margin-bottom: 15px;
        }
        
        .service-cap p {
            margin-bottom: 15px;
            line-height: 1.6;
        }
    </style>

</body>

</html>