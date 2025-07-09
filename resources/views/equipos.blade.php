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
                        'slug' => 'excavadora',
                        'name' => [
                            'es' => 'Excavadora',
                            'en' => 'Dump Truck'
                        ],
                        'description' => [
                            'es' => 'Camiones de volteo para transporte y descarga de materiales. Disponibles en diferentes capacidades para proyectos de construcción y minería.',
                            'en' => 'Dump trucks for material transport and unloading. Available in different capacities for construction and mining projects.'
                        ],
                        'image' => 'assets/img/equipos/excavadora.png',
                        'icon' => 'assets/img/icon/services_icon1.png',
                        'specs' => [
                            'es' => [
                                'Capacidad: 10-40 toneladas',
                                'Sistema hidráulico de volteo',
                                'Múltiples configuraciones'
                            ],
                            'en' => [
                                'Capacity: 10-40 tons',
                                'Hydraulic dumping system',
                                'Multiple configurations'
                            ]
                        ],
                        'detailed_info' => [
                            'es' => [
                                'description' => 'Nuestros camiones de volteo ofrecen soluciones eficientes para el transporte y descarga de materiales en proyectos de construcción de gran escala.',
                                'features' => [
                                    'Caja de volteo reforzada',
                                    'Sistema hidráulico de alta potencia',
                                    'Compuerta trasera automática',
                                    'Suspensión neumática',
                                    'Sistema de frenado ABS'
                                ],
                                'applications' => [
                                    'Transporte de agregados',
                                    'Movimiento de tierra',
                                    'Proyectos de minería',
                                    'Construcción de carreteras'
                                ],
                                'technical_specs' => [
                                    'Capacidad de carga: 10-40 toneladas',
                                    'Volumen de caja: 8-25 m³',
                                    'Potencia del motor: 300-500 HP',
                                    'Tiempo de volteo: 15-25 segundos',
                                    'Velocidad máxima: 90 km/h'
                                ]
                            ],
                            'en' => [
                                'description' => 'Our dump trucks offer efficient solutions for material transport and unloading in large-scale construction projects.',
                                'features' => [
                                    'Reinforced dump body',
                                    'High-power hydraulic system',
                                    'Automatic tailgate',
                                    'Air suspension',
                                    'ABS braking system'
                                ],
                                'applications' => [
                                    'Aggregate transport',
                                    'Earthmoving',
                                    'Mining projects',
                                    'Road construction'
                                ],
                                'technical_specs' => [
                                    'Load capacity: 10-40 tons',
                                    'Body volume: 8-25 m³',
                                    'Engine power: 300-500 HP',
                                    'Dumping time: 15-25 seconds',
                                    'Maximum speed: 90 km/h'
                                ]
                            ]
                        ],
                        'gallery' => [
                            'assets/img/equipos/camion-volteo.svg',
                            'assets/img/gallery/dumptruck1.jpg',
                            'assets/img/gallery/dumptruck2.jpg'
                        ]
],
            [
                'slug' => 'retroexcavadora-414E',
                'name' => [
                    'es' => 'Retroexcavadora 414E',
                    'en' => 'Backhoe Loader 414E'
                ],
                'description' => [
                    'es' => 'Grúas torre de alta capacidad para proyectos de construcción de todos los tamaños. Perfectas para elevar materiales pesados a grandes alturas con precisión y seguridad.',
                    'en' => 'High-capacity tower cranes for construction projects of all sizes. Perfect for lifting heavy materials to great heights with precision and safety.'
                ],
                'image' => 'assets/img/equipos/Retro-414.png',
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
                'slug' => 'camion-ford',
                'name' => [
                    'es' => 'Camión de Volteo Ford',
                    'en' => 'Dump Truck'
                ],
                'description' => [
                    'es' => 'Camiones de volteo para transporte y descarga de materiales. Disponibles en diferentes capacidades para proyectos de construcción y minería.',
                    'en' => 'Dump trucks for material transport and unloading. Available in different capacities for construction and mining projects.'
                ],
                'image' => 'assets/img/equipos/camion.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 10-40 toneladas',
                        'Sistema hidráulico de volteo',
                        'Múltiples configuraciones'
                    ],
                    'en' => [
                        'Capacity: 10-40 tons',
                        'Hydraulic dumping system',
                        'Multiple configurations'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestros camiones de volteo ofrecen soluciones eficientes para el transporte y descarga de materiales en proyectos de construcción de gran escala.',
                        'features' => [
                            'Caja de volteo reforzada',
                            'Sistema hidráulico de alta potencia',
                            'Compuerta trasera automática',
                            'Suspensión neumática',
                            'Sistema de frenado ABS'
                        ],
                        'applications' => [
                            'Transporte de agregados',
                            'Movimiento de tierra',
                            'Proyectos de minería',
                            'Construcción de carreteras'
                        ],
                        'technical_specs' => [
                            'Capacidad de carga: 10-40 toneladas',
                            'Volumen de caja: 8-25 m³',
                            'Potencia del motor: 300-500 HP',
                            'Tiempo de volteo: 15-25 segundos',
                            'Velocidad máxima: 90 km/h'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our dump trucks offer efficient solutions for material transport and unloading in large-scale construction projects.',
                        'features' => [
                            'Reinforced dump body',
                            'High-power hydraulic system',
                            'Automatic tailgate',
                            'Air suspension',
                            'ABS braking system'
                        ],
                        'applications' => [
                            'Aggregate transport',
                            'Earthmoving',
                            'Mining projects',
                            'Road construction'
                        ],
                        'technical_specs' => [
                            'Load capacity: 10-40 tons',
                            'Body volume: 8-25 m³',
                            'Engine power: 300-500 HP',
                            'Dumping time: 15-25 seconds',
                            'Maximum speed: 90 km/h'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/camion-volteo.svg',
                    'assets/img/gallery/dumptruck1.jpg',
                    'assets/img/gallery/dumptruck2.jpg'
                ]
            ],
            [
                'slug' => 'camion-kenworth',
                'name' => [
                    'es' => 'Camión Kenworth',
                    'en' => 'Mobile Cranes'
                ],
                'description' => [
                    'es' => 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible. Ideales para proyectos que requieren movilidad y despliegue rápido.',
                    'en' => 'Versatile mobile cranes for quick setup and flexible positioning. Ideal for projects requiring mobility and rapid deployment.'
                ],
                'image' => 'assets/img/equipos/camion-kenworth.png',
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
                'slug' => 'retroexcavadora-416F',
                'name' => [
                    'es' => 'Retroexcavadora 416F',
                    'en' => 'Backhoe Loader 416F'
                ],
                'description' => [
                    'es' => 'Retroexcavadora 416F de alto rendimiento para excavación y carga. Ideal para proyectos de construcción y mantenimiento en terrenos variados.',
                    'en' => 'High-performance 416F backhoe loader for excavation and loading. Ideal for construction and maintenance projects on varied terrains.'
                ],
                'image' => 'assets/img/equipos/Retro-416.png',
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
                        'description' => 'Nuestra retroexcavadora 416F combina potencia y versatilidad para realizar tareas de excavación, carga y movimiento de tierra en una amplia variedad de terrenos. Ideal para proyectos de construcción y mantenimiento.',
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
            ],
            [
                'slug' => 'retroexcavadora',
                'name' => [
                    'es' => 'Retroexcavadora',
                    'en' => 'Backhoe Loader'
                ],
                'description' => [
                    'es' => 'Retroexcavadoras versátiles para excavación, carga y múltiples tareas de construcción. Combinan la funcionalidad de una excavadora y un cargador frontal.',
                    'en' => 'Versatile backhoe loaders for excavation, loading, and multiple construction tasks. Combine the functionality of an excavator and front loader.'
                ],
                'image' => 'assets/img/equipos/retroexcavadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 7-10 toneladas',
                        'Doble funcionalidad',
                        'Alta maniobrabilidad'
                    ],
                    'en' => [
                        'Weight: 7-10 tons',
                        'Dual functionality',
                        'High maneuverability'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras retroexcavadoras ofrecen la versatilidad de dos máquinas en una. Con cargador frontal y brazo excavador trasero, son ideales para proyectos medianos que requieren flexibilidad.',
                        'features' => [
                            'Cargador frontal de alta capacidad',
                            'Brazo excavador articulado',
                            'Transmisión powershift',
                            'Cabina ROPS certificada',
                            'Sistema hidráulico piloto'
                        ],
                        'applications' => [
                            'Excavación de zanjas',
                            'Carga de materiales',
                            'Nivelación de terrenos',
                            'Trabajos urbanos'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 7-10 toneladas',
                            'Potencia del motor: 95-110 HP',
                            'Capacidad cucharón frontal: 1.0 m³',
                            'Capacidad cucharón trasero: 0.3 m³',
                            'Profundidad de excavación: 4.5 metros'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our backhoe loaders offer the versatility of two machines in one. With front loader and rear excavator arm, they are ideal for medium projects requiring flexibility.',
                        'features' => [
                            'High-capacity front loader',
                            'Articulated excavator arm',
                            'Powershift transmission',
                            'ROPS certified cabin',
                            'Pilot hydraulic system'
                        ],
                        'applications' => [
                            'Trench excavation',
                            'Material loading',
                            'Land leveling',
                            'Urban work'
                        ],
                        'technical_specs' => [
                            'Operating weight: 7-10 tons',
                            'Engine power: 95-110 HP',
                            'Front bucket capacity: 1.0 m³',
                            'Rear bucket capacity: 0.3 m³',
                            'Digging depth: 4.5 meters'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/retroexcavadora.svg',
                    'assets/img/gallery/backhoe1.jpg',
                    'assets/img/gallery/backhoe2.jpg'
                ]
            ],
            [
                'slug' => 'vibrocompactadora',
                'name' => [
                    'es' => 'Vibrocompactadora',
                    'en' => 'Vibratory Roller'
                ],
                'description' => [
                    'es' => 'Vibrocompactadoras para compactación de suelos y asfalto. Equipos especializados para lograr la densidad óptima en pavimentos y terraplenes.',
                    'en' => 'Vibratory rollers for soil and asphalt compaction. Specialized equipment to achieve optimal density in pavements and embankments.'
                ],
                'image' => 'assets/img/equipos/vibrocompactadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 3-15 toneladas',
                        'Compactación por vibración',
                        'Uso en asfalto y suelo'
                    ],
                    'en' => [
                        'Weight: 3-15 tons',
                        'Vibration compaction',
                        'Asphalt and soil use'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras vibrocompactadoras están diseñadas para lograr la compactación perfecta en proyectos de pavimentación y construcción de carreteras.',
                        'features' => [
                            'Sistema de vibración ajustable',
                            'Rodillos de acero de alta calidad',
                            'Sistema de riego automático',
                            'Control de frecuencia variable',
                            'Cabina con suspensión'
                        ],
                        'applications' => [
                            'Compactación de asfalto',
                            'Compactación de suelos',
                            'Construcción de carreteras',
                            'Preparación de bases'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 3-15 toneladas',
                            'Ancho de compactación: 1.2-2.1 metros',
                            'Frecuencia de vibración: 2800-4200 vpm',
                            'Velocidad de trabajo: 0-12 km/h',
                            'Tanque de agua: 400-1000 litros'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our vibratory rollers are designed to achieve perfect compaction in paving and road construction projects.',
                        'features' => [
                            'Adjustable vibration system',
                            'High-quality steel drums',
                            'Automatic sprinkler system',
                            'Variable frequency control',
                            'Suspended cabin'
                        ],
                        'applications' => [
                            'Asphalt compaction',
                            'Soil compaction',
                            'Road construction',
                            'Base preparation'
                        ],
                        'technical_specs' => [
                            'Operating weight: 3-15 tons',
                            'Compaction width: 1.2-2.1 meters',
                            'Vibration frequency: 2800-4200 vpm',
                            'Working speed: 0-12 km/h',
                            'Water tank: 400-1000 liters'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/vibrocompactadora.svg',
                    'assets/img/gallery/roller1.jpg',
                    'assets/img/gallery/roller2.jpg'
                ]
            ],
            [
                'slug' => 'motoconformadora',
                'name' => [
                    'es' => 'Motoconformadora',
                    'en' => 'Motor Grader'
                ],
                'description' => [
                    'es' => 'Motoconformadoras para nivelación y conformación de terrenos. Equipos especializados para construcción y mantenimiento de carreteras.',
                    'en' => 'Motor graders for land leveling and shaping. Specialized equipment for road construction and maintenance.'
                ],
                'image' => 'assets/img/equipos/motoconformadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 12-20 toneladas',
                        'Hoja niveladora ajustable',
                        'Alta precisión'
                    ],
                    'en' => [
                        'Weight: 12-20 tons',
                        'Adjustable blade',
                        'High precision'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras motoconformadoras proporcionan la precisión necesaria para trabajos de nivelación y conformación de superficies en proyectos viales.',
                        'features' => [
                            'Hoja moldboard de 3.7 metros',
                            'Sistema de control hidráulico',
                            'Articulación central',
                            'Ripper trasero opcional',
                            'Sistema GPS disponible'
                        ],
                        'applications' => [
                            'Nivelación de carreteras',
                            'Conformación de taludes',
                            'Mantenimiento vial',
                            'Preparación de subrasante'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 12-20 toneladas',
                            'Potencia del motor: 140-200 HP',
                            'Longitud de hoja: 3.7 metros',
                            'Velocidad máxima: 45 km/h',
                            'Radio de giro: 7.3 metros'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our motor graders provide the precision needed for leveling and surface shaping work in road projects.',
                        'features' => [
                            '3.7-meter moldboard blade',
                            'Hydraulic control system',
                            'Center articulation',
                            'Optional rear ripper',
                            'GPS system available'
                        ],
                        'applications' => [
                            'Road leveling',
                            'Slope shaping',
                            'Road maintenance',
                            'Subgrade preparation'
                        ],
                        'technical_specs' => [
                            'Operating weight: 12-20 tons',
                            'Engine power: 140-200 HP',
                            'Blade length: 3.7 meters',
                            'Maximum speed: 45 km/h',
                            'Turning radius: 7.3 meters'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/motoconformadora.svg',
                    'assets/img/gallery/grader1.jpg',
                    'assets/img/gallery/grader2.jpg'
                ]
            ],
            [
                'slug' => 'pipa-agua',
                'name' => [
                    'es' => 'Pipa de Agua',
                    'en' => 'Water Truck'
                ],
                'description' => [
                    'es' => 'Pipas de agua para control de polvo, compactación y riego. Equipos esenciales para mantener condiciones óptimas en obras de construcción.',
                    'en' => 'Water trucks for dust control, compaction, and irrigation. Essential equipment to maintain optimal conditions at construction sites.'
                ],
                'image' => 'assets/img/equipos/pipa-agua.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 5,000-20,000 litros',
                        'Sistema de aspersión',
                        'Control de polvo'
                    ],
                    'en' => [
                        'Capacity: 5,000-20,000 liters',
                        'Spraying system',
                        'Dust control'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras pipas de agua son fundamentales para el control de polvo y el mantenimiento de condiciones de trabajo seguras en proyectos de construcción.',
                        'features' => [
                            'Tanque de acero inoxidable',
                            'Sistema de bombeo de alta presión',
                            'Boquillas de aspersión ajustables',
                            'Control remoto de aspersión',
                            'Medidor de nivel de agua'
                        ],
                        'applications' => [
                            'Control de polvo en obras',
                            'Compactación de suelos',
                            'Riego de áreas verdes',
                            'Limpieza de equipos'
                        ],
                        'technical_specs' => [
                            'Capacidad del tanque: 5,000-20,000 litros',
                            'Presión de bombeo: 3-5 bar',
                            'Ancho de aspersión: 8-15 metros',
                            'Velocidad de trabajo: 5-25 km/h',
                            'Autonomía: 4-8 horas'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our water trucks are essential for dust control and maintaining safe working conditions in construction projects.',
                        'features' => [
                            'Stainless steel tank',
                            'High-pressure pumping system',
                            'Adjustable spray nozzles',
                            'Remote spray control',
                            'Water level gauge'
                        ],
                        'applications' => [
                            'Dust control at sites',
                            'Soil compaction',
                            'Green area irrigation',
                            'Equipment cleaning'
                        ],
                        'technical_specs' => [
                            'Tank capacity: 5,000-20,000 liters',
                            'Pumping pressure: 3-5 bar',
                            'Spray width: 8-15 meters',
                            'Working speed: 5-25 km/h',
                            'Autonomy: 4-8 hours'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/pipa-agua.svg',
                    'assets/img/gallery/watertruck1.jpg',
                    'assets/img/gallery/watertruck2.jpg'
                ]
            ],
            
                    
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
                @foreach($equipments as $equipment)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <div class="service-img">
                            <img src="{{ asset($equipment['image']) }}" alt="{{ $equipment['name'][$currentLang] }}">
                        </div>
                        <div class="service-cap">
                            <h4><a href="{{ session('language') === 'en' ? route('equipos.detail.EN', $equipment['slug']) : route('equipos.detail.ES', $equipment['slug']) }}">{{ $equipment['name'][$currentLang] }}</a></h4>
                            <p>{{ $equipment['description'][$currentLang] }}</p>
                            <ul class="equipment-specs">
                                @foreach($equipment['specs'][$currentLang] as $spec)
                                <li><i class="ti-check"></i> {{ $spec }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="service-icon">
                            <img src="{{ asset($equipment['icon']) }}" alt="">
                        </div>
                    </div>
                </div>
                @endforeach
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