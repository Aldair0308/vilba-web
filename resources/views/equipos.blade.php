<!doctype html>
<html class="no-js" lang="{{ session('language', 'es') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ session('language') === 'en' ? 'Equipment - Vilba Construction' : 'Equipos - Vilba Construcción' }}</title>
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

<body>
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
                'slug' => 'camion-volvo',
                'name' => [
                    'es' => 'Camión Volvo FH',
                    'en' => 'Volvo FH Truck'
                ],
                'description' => [
                    'es' => 'Camión Volvo FH para transporte de larga distancia y construcción. Potencia de 420-540 CV, ideal para tareas de transporte regional y relacionado con edificación.',
                    'en' => 'Volvo FH truck for long-distance transport and construction. Power 420-540 HP, ideal for regional transport and building-related tasks.'
                ],
                'image' => 'assets/img/service/servicess4.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Potencia: 420-540 CV',
                        'Transmisión automática',
                        'Cabina ergonómica'
                    ],
                    'en' => [
                        'Power: 420-540 HP',
                        'Automatic transmission',
                        'Ergonomic cabin'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestros camiones Volvo FH ofrecen soluciones de transporte confiables para construcción y logística. Diseñados para máximo rendimiento y eficiencia en rutas de larga distancia.',
                        'features' => [
                            'Motor D13K de alta eficiencia',
                            'Transmisión I-Shift automatizada',
                            'Cabina con suspensión neumática',
                            'Sistema de gestión de combustible',
                            'Tecnología de seguridad avanzada'
                        ],
                        'applications' => [
                            'Transporte de materiales de construcción',
                            'Logística regional',
                            'Distribución urbana',
                            'Proyectos de infraestructura'
                        ],
                        'technical_specs' => [
                            'Potencia: 420-540 CV',
                            'Torque: 2100-2600 Nm',
                            'Capacidad de carga: hasta 40 toneladas',
                            'Consumo: 32-35 L/100km',
                            'Emisiones: Euro 6'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our Volvo FH trucks offer reliable transport solutions for construction and logistics. Designed for maximum performance and efficiency on long-distance routes.',
                        'features' => [
                            'High-efficiency D13K engine',
                            'I-Shift automated transmission',
                            'Air-suspended cabin',
                            'Fuel management system',
                            'Advanced safety technology'
                        ],
                        'applications' => [
                            'Construction material transport',
                            'Regional logistics',
                            'Urban distribution',
                            'Infrastructure projects'
                        ],
                        'technical_specs' => [
                            'Power: 420-540 HP',
                            'Torque: 2100-2600 Nm',
                            'Load capacity: up to 40 tons',
                            'Consumption: 32-35 L/100km',
                            'Emissions: Euro 6'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/gallery/volvo1.jpg',
                    'assets/img/gallery/volvo2.jpg',
                    'assets/img/gallery/volvo3.jpg'
                ]
            ],
            [
                'slug' => 'excavadoras',
                'name' => [
                    'es' => 'Excavadora Caterpillar 330C',
                    'en' => 'Caterpillar 330C Excavator'
                ],
                'description' => [
                    'es' => 'Excavadora Caterpillar 330C modelo 2004 (Serie: CAT0330CCJAB00810) para movimiento de tierra, demolición y proyectos de construcción con motor CAT C9 de 244 HP.',
                    'en' => 'Caterpillar 330C excavator model 2004 (Serial: CAT0330CCJAB00810) for earthmoving, demolition, and construction projects with CAT C9 engine 244 HP.'
                ],
                'image' => 'assets/img/service/servicess5.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 35.1 toneladas',
                        'Motor CAT C9 - 244 HP',
                        'Operadores experimentados'
                    ],
                    'en' => [
                        'Weight: 35.1 tons',
                        'CAT C9 Engine - 244 HP',
                        'Experienced operators'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Excavadora Caterpillar 330C modelo 2004 (Serie: CAT0330CCJAB00810) diseñada para los trabajos más exigentes de excavación, demolición y movimiento de tierra en proyectos de construcción e infraestructura.',
                        'features' => [
                            'Motor CAT C9 de 244 HP',
                            'Sistema hidráulico de 148 gal/min',
                            'Cabina ROPS/FOPS certificada',
                            'Peso operativo de 35.1 toneladas',
                            'Capacidad de combustible de 163 galones'
                        ],
                        'applications' => [
                            'Excavación y movimiento de tierra',
                            'Demolición controlada',
                            'Construcción de carreteras',
                            'Proyectos de urbanización'
                        ],
                        'technical_specs' => [
                            'Motor: CAT C9 - 244 HP',
                            'Peso operativo: 77,400 lb (35.1 ton)',
                            'Capacidad del cucharón: 2.3 yd³',
                            'Alcance máximo: 10.68 metros',
                            'Profundidad de excavación: 7.24 metros',
                            'Capacidad de combustible: 163 gal',
                            'Sistema hidráulico: 148 gal/min'
                        ]
                    ],
                    'en' => [
                        'description' => 'Caterpillar 330C excavator model 2004 (Serial: CAT0330CCJAB00810) designed for the most demanding excavation, demolition, and earthmoving jobs in construction and infrastructure projects.',
                        'features' => [
                            'CAT C9 engine 244 HP',
                            'Hydraulic system 148 gal/min',
                            'ROPS/FOPS certified cabin',
                            'Operating weight 35.1 tons',
                            'Fuel capacity 163 gallons'
                        ],
                        'applications' => [
                            'Excavation and earthmoving',
                            'Controlled demolition',
                            'Road construction',
                            'Urbanization projects'
                        ],
                        'technical_specs' => [
                            'Engine: CAT C9 - 244 HP',
                            'Operating weight: 77,400 lb (35.1 ton)',
                            'Bucket capacity: 2.3 yd³',
                            'Maximum reach: 10.68 meters',
                            'Digging depth: 7.24 meters',
                            'Fuel capacity: 163 gal',
                            'Hydraulic system: 148 gal/min'
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
                    'es' => 'Retroexcavadora Caterpillar 416D',
                    'en' => 'Caterpillar 416D Backhoe Loader'
                ],
                'description' => [
                    'es' => 'Retroexcavadora Caterpillar 416D Serie CAT0416DVBFP16809. Máquina versátil con motor diesel de 74 HP, ideal para excavación, carga y trabajos de construcción medianos.',
                    'en' => 'Caterpillar 416D Backhoe Loader Series CAT0416DVBFP16809. Versatile machine with 74 HP diesel engine, ideal for excavation, loading and medium construction work.'
                ],
                'image' => 'assets/img/equipos/cat-416d-hero.jpg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Motor: Caterpillar 3054C 74 HP',
                        'Peso: 15,180 lbs (6,900 kg)',
                        'Profundidad excavación: 10 ft 7 in'
                    ],
                    'en' => [
                        'Engine: Caterpillar 3054C 74 HP',
                        'Weight: 15,180 lbs (6,900 kg)',
                        'Digging depth: 10 ft 7 in'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'La Retroexcavadora Caterpillar 416D Serie CAT0416DVBFP16809 es una máquina robusta y confiable, fabricada entre 2000-2006. Combina la potencia de excavación trasera con la versatilidad de carga frontal, siendo ideal para proyectos de construcción medianos.',
                        'features' => [
                            'Motor Caterpillar 3054C de 4.4L turboalimentado',
                            'Transmisión power shuttle 4F/4R',
                            'Sistema hidráulico de 37 gpm a 3000 psi',
                            'Tracción 2WD/4WD disponible',
                            'Cabina ROPS/FOPS certificada'
                        ],
                        'applications' => [
                            'Excavación de zanjas y cimientos',
                            'Carga y descarga de materiales',
                            'Nivelación y preparación de terrenos',
                            'Trabajos de construcción urbana',
                            'Mantenimiento de carreteras'
                        ],
                        'technical_specs' => [
                            'Motor: Caterpillar 3054C 4 cilindros diesel',
                            'Potencia: 74 HP (55 kW) a 2200 rpm',
                            'Peso operativo: 15,180 lbs (6,900 kg)',
                            'Profundidad máxima excavación: 10 ft 7 in (3,219 mm)',
                            'Fuerza de excavación: 11,600 lbs',
                            'Capacidad tanque combustible: 34 galones (128L)',
                            'Sistema hidráulico: 37 gpm a 3000 psi'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Caterpillar 416D Backhoe Loader Series CAT0416DVBFP16809 is a robust and reliable machine, manufactured between 2000-2006. It combines rear excavation power with front loading versatility, being ideal for medium construction projects.',
                        'features' => [
                            'Caterpillar 3054C 4.4L turbocharged engine',
                            'Power shuttle transmission 4F/4R',
                            'Hydraulic system 37 gpm at 3000 psi',
                            '2WD/4WD traction available',
                            'ROPS/FOPS certified cabin'
                        ],
                        'applications' => [
                            'Trench and foundation excavation',
                            'Material loading and unloading',
                            'Land leveling and preparation',
                            'Urban construction work',
                            'Road maintenance'
                        ],
                        'technical_specs' => [
                            'Engine: Caterpillar 3054C 4-cylinder diesel',
                            'Power: 74 HP (55 kW) at 2200 rpm',
                            'Operating weight: 15,180 lbs (6,900 kg)',
                            'Maximum digging depth: 10 ft 7 in (3,219 mm)',
                            'Digging force: 11,600 lbs',
                            'Fuel tank capacity: 34 gallons (128L)',
                            'Hydraulic system: 37 gpm at 3000 psi'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/cat-416d-1.jpg',
                    'assets/img/equipos/cat-416d-2.jpg',
                    'assets/img/equipos/cat-416d-3.jpg'
                ]
            ],
            [
                'slug' => 'motoconformadora-570a',
                'name' => [
                    'es' => 'Motoconformadora John Deere 570A',
                    'en' => 'John Deere 570A Motor Grader'
                ],
                'description' => [
                    'es' => 'Motoconformadora John Deere 570A Serie 003311T para nivelación de terrenos y construcción de carreteras. Máquina especializada en trabajos de precisión.',
                    'en' => 'John Deere 570A Motor Grader Series 003311T for land leveling and road construction. Specialized machine for precision work.'
                ],
                'image' => 'assets/img/equipos/motoconformadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 21,703 lbs (9,845 kg)',
                        'Hoja de 12 pies',
                        'Serie: 003311T'
                    ],
                    'en' => [
                        'Weight: 21,703 lbs (9,845 kg)',
                        '12-foot blade',
                        'Series: 003311T'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Motoconformadora John Deere Modelo 570A Serie 003311T. Máquina especializada en nivelación de terrenos, construcción de carreteras y mantenimiento de caminos rurales con máxima precisión y eficiencia.',
                        'features' => [
                            'Hoja moldboard de 12 pies de ancho',
                            'Sistema de control hidráulico avanzado',
                            'Articulación central para maniobrabilidad',
                            'Cabina ROPS/FOPS certificada',
                            'Sistema de dirección asistida'
                        ],
                        'applications' => [
                            'Nivelación de terrenos',
                            'Construcción de carreteras',
                            'Mantenimiento de caminos rurales',
                            'Preparación de superficies',
                            'Conformación de taludes'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 21,703 lbs (9,845 kg)',
                            'Longitud total: 26 ft 9 in (8.15 m)',
                            'Ancho total: 8 ft 4 in (2.54 m)',
                            'Altura total: 10 ft 6 in (3.20 m)',
                            'Ancho de hoja: 12 ft (3.66 m)',
                            'Serie: 003311T'
                        ]
                    ],
                    'en' => [
                        'description' => 'John Deere Model 570A Motor Grader Series 003311T. Specialized machine for land leveling, road construction and rural road maintenance with maximum precision and efficiency.',
                        'features' => [
                            '12-foot wide moldboard blade',
                            'Advanced hydraulic control system',
                            'Center articulation for maneuverability',
                            'ROPS/FOPS certified cabin',
                            'Power steering system'
                        ],
                        'applications' => [
                            'Land leveling',
                            'Road construction',
                            'Rural road maintenance',
                            'Surface preparation',
                            'Slope shaping'
                        ],
                        'technical_specs' => [
                            'Operating weight: 21,703 lbs (9,845 kg)',
                            'Overall length: 26 ft 9 in (8.15 m)',
                            'Overall width: 8 ft 4 in (2.54 m)',
                            'Overall height: 10 ft 6 in (3.20 m)',
                            'Blade width: 12 ft (3.66 m)',
                            'Series: 003311T'
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
                'slug' => 'vibrocompactadora',
                'name' => [
                    'es' => 'Vibrocompactador Hugg & Hall SD 105F TF',
                    'en' => 'Hugg & Hall SD 105F TF Vibratory Compactor'
                ],
                'description' => [
                    'es' => 'Vibrocompactador Hugg & Hall modelo SD 105F TF Ingersoll Rand serie 186519 para compactación eficiente de suelos.',
                    'en' => 'Hugg & Hall SD 105F TF Ingersoll Rand vibratory compactor series 186519 for efficient soil compaction.'
                ],
                'image' => 'assets/img/equipos/vibrocompactadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Peso: 25,100 lbs (11,385 kg)',
                        'Motor: Cummins B3.9 TAA - 125 HP',
                        'Serie: 186519'
                    ],
                    'en' => [
                        'Weight: 25,100 lbs (11,385 kg)',
                        'Engine: Cummins B3.9 TAA - 125 HP',
                        'Series: 186519'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Vibrocompactador Hugg & Hall modelo SD 105F TF Ingersoll Rand serie 186519, diseñado para compactación eficiente de suelos en proyectos de construcción y pavimentación.',
                        'features' => [
                            'Motor Cummins B3.9 TAA Tier 2 turboalimentado',
                            'Tambor de 84 pulgadas de ancho',
                            'Diámetro del tambor de 59.02 pulgadas',
                            'Doble frecuencia de vibración (27.6 Hz y 33.8 Hz)',
                            'Fuerza centrífuga alta de 60,698 lbs',
                            'Capacidad de combustible de 68 galones'
                        ],
                        'applications' => [
                            'Compactación de suelos',
                            'Construcción de carreteras',
                            'Preparación de terrenos',
                            'Trabajos de pavimentación'
                        ],
                        'technical_specs' => [
                            'Modelo: SD 105F TF',
                            'Serie: 186519',
                            'Motor: Cummins B3.9 TAA Tier 2 - 125 HP',
                            'Peso operativo: 25,100 lbs (11,385 kg)',
                            'Longitud total: 19.34 ft (5.89 m)',
                            'Ancho: 7.5 ft (2.29 m)',
                            'Altura: 10.33 ft (3.15 m)',
                            'Ancho del tambor: 84 in (2.13 m)',
                            'Diámetro del tambor: 59.02 in (1.50 m)',
                            'Velocidad máxima: 6.5 mph (10.5 km/h)',
                            'Capacidad de combustible: 68 gal (257 L)',
                            'Frecuencias de vibración: 27.6 Hz y 33.8 Hz',
                            'Fuerza centrífuga: 60,698 lbs (27,533 kg)'
                        ]
                    ],
                    'en' => [
                        'description' => 'Hugg & Hall SD 105F TF Ingersoll Rand vibratory compactor series 186519, designed for efficient soil compaction in construction and paving projects.',
                        'features' => [
                            'Cummins B3.9 TAA Tier 2 turbocharged engine',
                            '84-inch wide drum',
                            '59.02-inch drum diameter',
                            'Dual vibration frequency (27.6 Hz and 33.8 Hz)',
                            'High centrifugal force of 60,698 lbs',
                            '68-gallon fuel capacity'
                        ],
                        'applications' => [
                            'Soil compaction',
                            'Road construction',
                            'Ground preparation',
                            'Paving work'
                        ],
                        'technical_specs' => [
                            'Model: SD 105F TF',
                            'Series: 186519',
                            'Engine: Cummins B3.9 TAA Tier 2 - 125 HP',
                            'Operating weight: 25,100 lbs (11,385 kg)',
                            'Overall length: 19.34 ft (5.89 m)',
                            'Width: 7.5 ft (2.29 m)',
                            'Height: 10.33 ft (3.15 m)',
                            'Drum width: 84 in (2.13 m)',
                            'Drum diameter: 59.02 in (1.50 m)',
                            'Maximum speed: 6.5 mph (10.5 km/h)',
                            'Fuel capacity: 68 gal (257 L)',
                            'Vibration frequencies: 27.6 Hz and 33.8 Hz',
                            'Centrifugal force: 60,698 lbs (27,533 kg)'
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
                'slug' => 'vibrocompactador-bross-spv730',
                'name' => [
                    'es' => 'Vibrocompactador Bross SPV-730',
                    'en' => 'Bross SPV-730 Vibratory Compactor'
                ],
                'description' => [
                    'es' => 'Vibrocompactador Bross Serie SPV-730 para compactación eficiente de suelos en proyectos de construcción y pavimentación.',
                    'en' => 'Bross SPV-730 Series vibratory compactor for efficient soil compaction in construction and paving projects.'
                ],
                'image' => 'assets/img/equipos/vibrocompactadora.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Motor: Diesel 80 HP',
                        'Peso operativo: 13,500 lbs',
                        'Tambor: 70 pulgadas de ancho'
                    ],
                    'en' => [
                        'Engine: 80 HP Diesel',
                        'Operating weight: 13,500 lbs',
                        'Drum: 70-inch wide'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Vibrocompactador Bross Serie SPV-730 diseñado para compactación eficiente de suelos en proyectos de construcción y pavimentación con máxima productividad.',
                        'features' => [
                            'Motor diesel de 80 HP de alta eficiencia',
                            'Tambor vibratorio de 70 pulgadas de ancho',
                            'Frecuencia de vibración de 28 Hz',
                            'Fuerza centrífuga de 40,000 lbs',
                            'Sistema de control hidráulico avanzado',
                            'Cabina ROPS/FOPS certificada'
                        ],
                        'applications' => [
                            'Compactación de suelos granulares',
                            'Construcción de carreteras',
                            'Preparación de bases y sub-bases',
                            'Compactación de rellenos',
                            'Trabajos de pavimentación',
                            'Mantenimiento de superficies'
                        ],
                        'technical_specs' => [
                            'Motor: Diesel 80 HP',
                            'Peso operativo: 13,500 lbs (6,124 kg)',
                            'Longitud total: 18 ft (5.49 m)',
                            'Ancho total: 8 ft (2.44 m)',
                            'Altura total: 10 ft (3.05 m)',
                            'Ancho del tambor: 70 in (1.78 m)',
                            'Diámetro del tambor: 50 in (1.27 m)',
                            'Velocidad máxima: 9 mph (14.5 km/h)',
                            'Capacidad de combustible: 45 gal (170 L)',
                            'Frecuencia de vibración: 28 Hz',
                            'Fuerza centrífuga: 40,000 lbs (18,144 kg)'
                        ]
                    ],
                    'en' => [
                        'description' => 'Bross SPV-730 Series vibratory compactor designed for efficient soil compaction in construction and paving projects with maximum productivity.',
                        'features' => [
                            'High-efficiency 80 HP diesel engine',
                            '70-inch wide vibratory drum',
                            '28 Hz vibration frequency',
                            '40,000 lbs centrifugal force',
                            'Advanced hydraulic control system',
                            'ROPS/FOPS certified cabin'
                        ],
                        'applications' => [
                            'Granular soil compaction',
                            'Road construction',
                            'Base and sub-base preparation',
                            'Fill compaction',
                            'Paving work',
                            'Surface maintenance'
                        ],
                        'technical_specs' => [
                            'Engine: 80 HP Diesel',
                            'Operating weight: 13,500 lbs (6,124 kg)',
                            'Overall length: 18 ft (5.49 m)',
                            'Overall width: 8 ft (2.44 m)',
                            'Overall height: 10 ft (3.05 m)',
                            'Drum width: 70 in (1.78 m)',
                            'Drum diameter: 50 in (1.27 m)',
                            'Maximum speed: 9 mph (14.5 km/h)',
                            'Fuel capacity: 45 gal (170 L)',
                            'Vibration frequency: 28 Hz',
                            'Centrifugal force: 40,000 lbs (18,144 kg)'
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
                'slug' => 'motoconformadora-galion-t600c',
                'name' => [
                    'es' => 'Motoconformadora Galion T600C',
                    'en' => 'Galion T600C Motor Grader'
                ],
                'description' => [
                    'es' => 'Motoconformadora Galion T600C Serie IC-03004 para nivelación, construcción de carreteras y mantenimiento vial.',
                    'en' => 'Galion T600C Motor Grader Series IC-03004 for grading, road construction and highway maintenance.'
                ],
                'image' => 'assets/img/equipos/motoconformadora-galion.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Motor: Detroit 6 cilindros diésel, 76 HP',
                        'Peso: 29,000 lbs (13,154 kg)',
                        'Hoja: 14 pies de ancho x 24 pulgadas'
                    ],
                    'en' => [
                        'Engine: Detroit 6-cylinder diesel, 76 HP',
                        'Weight: 29,000 lbs (13,154 kg)',
                        'Blade: 14 feet wide x 24 inches'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'La Motoconformadora Galion T600C Serie IC-03004 es una máquina robusta y confiable diseñada para trabajos de nivelación, construcción de carreteras y mantenimiento vial con máxima precisión y eficiencia.',
                        'features' => [
                            'Motor Detroit 6 cilindros diésel refrigerado por agua',
                            'Transmisión Powershift con 4 velocidades adelante y 4 atrás',
                            'Tracción 4WD con bloqueo diferencial',
                            'Cabina cerrada con calefacción',
                            'Frenos hidráulicos con sistema ABS'
                        ],
                        'applications' => [
                            'Construcción de carreteras',
                            'Mantenimiento de carreteras',
                            'Preparación de sitios',
                            'Operaciones de nivelación y conformación',
                            'Remoción de nieve'
                        ],
                        'technical_specs' => [
                            'Motor: Detroit 6 cilindros diésel, refrigerado por agua, 76 HP',
                            'Peso operativo: 29,000 lbs (13,154 kg)',
                            'Transmisión: Powershift, 4 adelante, 4 atrás',
                            'Distancia entre ejes: 312 pulgadas (7.9 m)',
                            'Hoja: 14 pies de ancho x 24 pulgadas de alto',
                            'Ancho total: 97 pulgadas (2.46 m)',
                            'Longitud: 27 pies 4 pulgadas (8.33 m)',
                            'Altura: 11 pies 2 pulgadas (3.4 m)',
                            'Neumáticos: 14.00-24 delanteros y traseros',
                            'Rango de ángulo de hoja: 360°'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Galion T600C Motor Grader Series IC-03004 is a robust and reliable machine designed for grading work, road construction and highway maintenance with maximum precision and efficiency.',
                        'features' => [
                            'Detroit 6-cylinder water-cooled diesel engine',
                            'Powershift transmission with 4 forward and 4 reverse speeds',
                            '4WD drive with differential lock',
                            'Enclosed cab with heating',
                            'Hydraulic brakes with ABS system'
                        ],
                        'applications' => [
                            'Road construction',
                            'Highway maintenance',
                            'Site preparation',
                            'Grading and leveling operations',
                            'Snow removal'
                        ],
                        'technical_specs' => [
                            'Engine: Detroit 6-cylinder diesel, water cooled, 76 HP',
                            'Operating weight: 29,000 lbs (13,154 kg)',
                            'Transmission: Powershift, 4 forward, 4 reverse',
                            'Wheelbase: 312 inches (7.9 m)',
                            'Blade: 14 feet wide x 24 inches tall',
                            'Overall width: 97 inches (2.46 m)',
                            'Length: 27 ft 4 in (8.33 m)',
                            'Height: 11 ft 2 in (3.4 m)',
                            'Tires: 14.00-24 front and rear',
                            'Blade angle range: 360°'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/motoconformadora-galion.svg',
                    'assets/img/gallery/grader1.jpg',
                    'assets/img/gallery/grader2.jpg'
                ]
            ],
            [
                'slug' => 'motoconformadora-cat-120b',
                'name' => [
                    'es' => 'Motoconformadora CAT 120B',
                    'en' => 'CAT 120B Motor Grader'
                ],
                'description' => [
                    'es' => 'Motoconformadora Caterpillar 120B Serie 64U5564 para nivelación de precisión, construcción de carreteras y mantenimiento vial.',
                    'en' => 'Caterpillar 120B Motor Grader Series 64U5564 for precision grading, road construction and highway maintenance.'
                ],
                'image' => 'assets/img/equipos/motoconformadora-cat.svg',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Motor: CAT 3306 6 cilindros diésel, 130-150 HP',
                        'Peso: 26,460 lbs (12,003 kg)',
                        'Hoja: 12 pies de ancho'
                    ],
                    'en' => [
                        'Engine: CAT 3306 6-cylinder diesel, 130-150 HP',
                        'Weight: 26,460 lbs (12,003 kg)',
                        'Blade: 12 feet wide'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'La Motoconformadora Caterpillar 120B Serie 64U5564 es una máquina de alta precisión diseñada para trabajos de nivelación, construcción de carreteras y mantenimiento vial con tecnología avanzada y máxima eficiencia.',
                        'features' => [
                            'Motor CAT 3306 6 cilindros diésel turboalimentado',
                            'Transmisión Powershift con múltiples velocidades',
                            'Tracción integral (AWD) disponible',
                            'Sistema hidráulico con controles integrados',
                            'Cabina cerrada con HVAC',
                            'Frenos hidráulicos con sistema ABS',
                            'Modo ECO para eficiencia de combustible'
                        ],
                        'applications' => [
                            'Construcción y mantenimiento de carreteras',
                            'Preparación de sitios',
                            'Nivelación fina',
                            'Remoción de nieve',
                            'Esparcimiento de materiales',
                            'Mantenimiento de zanjas'
                        ],
                        'technical_specs' => [
                            'Motor: CAT 3306 6 cilindros diésel turboalimentado, 130-150 HP (97-112 kW)',
                            'Peso operativo: 26,460 lbs (12,003 kg)',
                            'Longitud: 26 pies 0 pulgadas (7.92 m)',
                            'Ancho: 7 pies 9 pulgadas (2.36 m)',
                            'Altura: 10 pies 3 pulgadas (3.12 m)',
                            'Ancho de hoja: 12 pies (3.66 m)',
                            'Desplazamiento: 10.5 litros',
                            'Transmisión: Powershift',
                            'Capacidad de combustible: Aproximadamente 60 galones (227 litros)',
                            'Neumáticos: 14.00R24 estándar',
                            'Sistema hidráulico integrado'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Caterpillar 120B Motor Grader Series 64U5564 is a high-precision machine designed for grading work, road construction and highway maintenance with advanced technology and maximum efficiency.',
                        'features' => [
                            'CAT 3306 6-cylinder turbocharged diesel engine',
                            'Powershift transmission with multiple speeds',
                            'All-wheel drive (AWD) available',
                            'Hydraulic system with integrated controls',
                            'Enclosed cab with HVAC',
                            'Hydraulic brakes with ABS system',
                            'ECO mode for fuel efficiency'
                        ],
                        'applications' => [
                            'Road construction and maintenance',
                            'Site preparation',
                            'Fine grading',
                            'Snow removal',
                            'Material spreading',
                            'Ditch maintenance'
                        ],
                        'technical_specs' => [
                            'Engine: CAT 3306 6-cylinder turbocharged diesel, 130-150 HP (97-112 kW)',
                            'Operating weight: 26,460 lbs (12,003 kg)',
                            'Length: 26 ft 0 in (7.92 m)',
                            'Width: 7 ft 9 in (2.36 m)',
                            'Height: 10 ft 3 in (3.12 m)',
                            'Blade width: 12 ft (3.66 m)',
                            'Displacement: 10.5 liters',
                            'Transmission: Powershift',
                            'Fuel tank capacity: Approximately 60 gallons (227 liters)',
                            'Tires: 14.00R24 standard',
                            'Integrated hydraulic system'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/motoconformadora-cat.svg',
                    'assets/img/gallery/grader1.jpg',
                    'assets/img/gallery/grader2.jpg'
                ]
            ],
            
            // MOTOCONFORMADORA GALION MOD. 11809C SERIE: 118C
            [
                'slug' => 'motoconformadora-galion-118c',
                'name' => [
                    'es' => 'MOTOCONFORMADORA GALION MOD. 11809C',
                    'en' => 'GALION 11809C MOTOR GRADER'
                ],
                'description' => [
                    'es' => 'Motoconformadora Galion 11809C Serie 118C, máquina robusta y confiable para trabajos de nivelación, construcción de caminos y mantenimiento vial con motor Cummins.',
                    'en' => 'Galion 11809C Motor Grader Series 118C, robust and reliable machine for grading work, road construction and highway maintenance with Cummins engine.'
                ],
                'image' => 'assets/img/equipos/motoconformadora-galion.svg',
                'icon' => 'assets/img/icon/services4.svg',
                'specs' => [
                    'es' => [
                        'Motor Cummins NHC 4C de 4 cilindros',
                        'Peso operativo: 30,100 lbs (13,653 kg)',
                        'Hoja niveladora de 14 pies',
                        'Llantas 13.00-24',
                        'Controles hidráulicos'
                    ],
                    'en' => [
                        'Cummins NHC 4C 4-cylinder engine',
                        'Operating weight: 30,100 lbs (13,653 kg)',
                        '14-foot moldboard blade',
                        '13.00-24 tires',
                        'Hydraulic controls'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'La Motoconformadora Galion 11809C Serie 118C es una máquina de construcción robusta y confiable, diseñada para trabajos de nivelación de precisión, construcción de caminos y mantenimiento vial. Equipada con motor Cummins de alta eficiencia y controles hidráulicos avanzados.',
                        'features' => [
                            'Motor Cummins NHC 4C de 4 cilindros diésel',
                            'Sistema de controles hidráulicos',
                            'Hoja niveladora de 14 pies de ancho',
                            'Llantas 13.00-24 para tracción superior',
                            'Cabina cerrada con controles ergonómicos',
                            'Sistema de dirección hidráulica',
                            'Tanque de combustible de gran capacidad'
                        ],
                        'applications' => [
                            'Construcción y mantenimiento de caminos',
                            'Nivelación de terrenos',
                            'Preparación de sitios de construcción',
                            'Trabajos de acabado fino',
                            'Remoción de nieve',
                            'Mantenimiento de cunetas',
                            'Esparcimiento de materiales'
                        ],
                        'technical_specs' => [
                            'Motor: Cummins NHC 4C de 4 cilindros diésel',
                            'Peso operativo: 30,100 lbs (13,653 kg)',
                            'Longitud: 27 pies 8 pulgadas (8.43 m)',
                            'Ancho: 8 pies 0 pulgadas (2.44 m)',
                            'Altura: 10 pies 3 pulgadas (3.12 m)',
                            'Ancho de hoja: 14 pies (4.27 m)',
                            'Llantas: 13.00-24 estándar',
                            'Capacidad de tanque: Aproximadamente 45-50 galones (170-189 litros)',
                            'Sistema hidráulico integrado',
                            'Serie: 118C',
                            'Modelo: 11809C'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Galion 11809C Motor Grader Series 118C is a robust and reliable construction machine designed for precision grading work, road construction and highway maintenance. Equipped with high-efficiency Cummins engine and advanced hydraulic controls.',
                        'features' => [
                            'Cummins NHC 4C 4-cylinder diesel engine',
                            'Hydraulic control system',
                            '14-foot wide moldboard blade',
                            '13.00-24 tires for superior traction',
                            'Enclosed cab with ergonomic controls',
                            'Hydraulic steering system',
                            'Large capacity fuel tank'
                        ],
                        'applications' => [
                            'Road construction and maintenance',
                            'Land grading',
                            'Construction site preparation',
                            'Fine finishing work',
                            'Snow removal',
                            'Ditch maintenance',
                            'Material spreading'
                        ],
                        'technical_specs' => [
                            'Engine: Cummins NHC 4C 4-cylinder diesel',
                            'Operating weight: 30,100 lbs (13,653 kg)',
                            'Length: 27 ft 8 in (8.43 m)',
                            'Width: 8 ft 0 in (2.44 m)',
                            'Height: 10 ft 3 in (3.12 m)',
                            'Blade width: 14 ft (4.27 m)',
                            'Tires: 13.00-24 standard',
                            'Fuel tank capacity: Approximately 45-50 gallons (170-189 liters)',
                            'Integrated hydraulic system',
                            'Series: 118C',
                            'Model: 11809C'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/motoconformadora-galion.svg',
                    'assets/img/gallery/galion1.jpg',
                    'assets/img/gallery/galion2.jpg'
                ]
            ],
            
            'lowboy-rg35-t' => [
                'slug' => 'lowboy-rg35-t',
                'name' => [
                    'es' => 'LOW BOY RG35 T',
                    'en' => 'LOW BOY RG35 T'
                ],
                'description' => [
                    'es' => 'Remolque LOW BOY modelo RG35 T del año 2000, diseñado para el transporte de maquinaria pesada y equipos de construcción. Con capacidad de 35 toneladas y plataforma baja para facilitar la carga y descarga.',
                    'en' => 'LOW BOY trailer model RG35 T from year 2000, designed for transporting heavy machinery and construction equipment. With 35-ton capacity and low platform for easy loading and unloading.'
                ],
                'image' => 'assets/img/equipos/lowboy-rg35t.svg',
                'icon' => 'assets/img/icon/lowboy-icon.svg',
                'specs' => [
                    'es' => [
                        'Capacidad: 35 toneladas (70,000 lbs)',
                        'Longitud de plataforma: 22-24 pies',
                        'Altura de plataforma: 20-24 pulgadas',
                        'Suspensión neumática',
                        'Frenos de aire con ABS'
                    ],
                    'en' => [
                        'Capacity: 35 tons (70,000 lbs)',
                        'Deck length: 22-24 feet',
                        'Deck height: 20-24 inches',
                        'Air ride suspension',
                        'Air brakes with ABS'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'El remolque LOW BOY RG35 T del año 2000 es una solución confiable para el transporte de maquinaria pesada. Su diseño de plataforma baja facilita la carga y descarga de equipos, mientras que su construcción robusta garantiza seguridad en el transporte.',
                        'features' => [
                            'Plataforma baja de 20-24 pulgadas de altura',
                            'Capacidad de carga de 35 toneladas',
                            'Longitud de plataforma de 22-24 pies',
                            'Suspensión neumática para viaje suave',
                            'Sistema de frenos de aire con ABS',
                            'Llantas 255/70R22.5 o similares',
                            'Configuración de ejes tándem o tri-eje',
                            'Ancho estándar de 8.5 pies',
                            'Longitud total de 44-46 pies'
                        ],
                        'applications' => [
                            'Transporte de excavadoras',
                            'Transporte de maquinaria de construcción',
                            'Transporte de equipos industriales',
                            'Transporte de tractores y equipos agrícolas',
                            'Transporte de generadores grandes',
                            'Transporte de equipos de minería',
                            'Transporte de maquinaria especializada'
                        ],
                        'technical_specs' => [
                            'Modelo: RG35 T',
                            'Año: 2000',
                            'Serie: 1W8A11D25Y5000540',
                            'Capacidad: 35 toneladas (70,000 lbs)',
                            'Longitud de plataforma: 22-24 pies (6.7-7.3 m)',
                            'Altura de plataforma: 20-24 pulgadas (0.5-0.6 m)',
                            'Longitud total: 44-46 pies (13.4-14.0 m)',
                            'Ancho: 8.5 pies (2.6 m)',
                            'Ejes: Configuración tándem o tri-eje',
                            'Suspensión: Suspensión neumática',
                            'Llantas: 255/70R22.5 o similares',
                            'Frenos: Frenos de aire con sistema ABS',
                            'Peso del remolque: Aproximadamente 15,000-18,000 lbs'
                        ]
                    ],
                    'en' => [
                        'description' => 'The LOW BOY RG35 T trailer from year 2000 is a reliable solution for heavy machinery transport. Its low platform design facilitates equipment loading and unloading, while its robust construction ensures transport safety.',
                        'features' => [
                            'Low platform 20-24 inches height',
                            '35-ton load capacity',
                            '22-24 feet platform length',
                            'Air ride suspension for smooth travel',
                            'Air brake system with ABS',
                            '255/70R22.5 or similar tires',
                            'Tandem or tri-axle configuration',
                            'Standard 8.5 feet width',
                            'Overall length 44-46 feet'
                        ],
                        'applications' => [
                            'Excavator transport',
                            'Construction machinery transport',
                            'Industrial equipment transport',
                            'Tractor and agricultural equipment transport',
                            'Large generator transport',
                            'Mining equipment transport',
                            'Specialized machinery transport'
                        ],
                        'technical_specs' => [
                            'Model: RG35 T',
                            'Year: 2000',
                            'Serial: 1W8A11D25Y5000540',
                            'Capacity: 35 tons (70,000 lbs)',
                            'Deck length: 22-24 feet (6.7-7.3 m)',
                            'Deck height: 20-24 inches (0.5-0.6 m)',
                            'Overall length: 44-46 feet (13.4-14.0 m)',
                            'Width: 8.5 feet (2.6 m)',
                            'Axles: Tandem or tri-axle configuration',
                            'Suspension: Air ride suspension',
                            'Tires: 255/70R22.5 or similar',
                            'Brakes: Air brakes with ABS system',
                            'Trailer weight: Approximately 15,000-18,000 lbs'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/lowboy-rg35t.svg',
                    'assets/img/gallery/lowboy1.jpg',
                    'assets/img/gallery/lowboy2.jpg'
                ]
            ],
            
            'lowboy-2002' => [
                'slug' => 'lowboy-2002',
                'name' => [
                    'es' => 'LOW BOY 2002',
                    'en' => 'LOW BOY 2002'
                ],
                'description' => [
                    'es' => 'Remolque LOW BOY del año 2002, diseñado para el transporte de maquinaria pesada y equipos de construcción. Con capacidad de 40-50 toneladas y plataforma baja para facilitar la carga y descarga de equipos pesados.',
                    'en' => 'LOW BOY trailer from year 2002, designed for transporting heavy machinery and construction equipment. With 40-50 ton capacity and low platform for easy loading and unloading of heavy equipment.'
                ],
                'image' => 'assets/img/equipos/lowboy-2002.svg',
                'icon' => 'assets/img/icon/lowboy-icon.svg',
                'specs' => [
                    'es' => [
                        'Capacidad: 40-50 toneladas (80,000-100,000 lbs)',
                        'Longitud de plataforma: 24-29 pies',
                        'Altura de plataforma: 18-24 pulgadas',
                        'Suspensión neumática',
                        'Frenos de aire con ABS'
                    ],
                    'en' => [
                        'Capacity: 40-50 tons (80,000-100,000 lbs)',
                        'Deck length: 24-29 feet',
                        'Deck height: 18-24 inches',
                        'Air ride suspension',
                        'Air brakes with ABS'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'El remolque LOW BOY del año 2002 es una solución robusta y confiable para el transporte de maquinaria pesada. Su diseño de plataforma baja y alta capacidad de carga lo hacen ideal para transportar equipos de construcción y maquinaria industrial de gran tamaño.',
                        'features' => [
                            'Plataforma baja de 18-24 pulgadas de altura',
                            'Capacidad de carga de 40-50 toneladas',
                            'Longitud de plataforma de 24-29 pies',
                            'Suspensión neumática para viaje suave',
                            'Sistema de frenos de aire con ABS',
                            'Llantas 255/70R22.5 o 11R22.5',
                            'Configuración de ejes tándem o tri-eje',
                            'Ancho estándar de 8.5 pies',
                            'Longitud total de 48-53 pies',
                            'Construcción de acero de alta resistencia'
                        ],
                        'applications' => [
                            'Transporte de excavadoras grandes',
                            'Transporte de bulldozers',
                            'Transporte de maquinaria de construcción pesada',
                            'Transporte de equipos industriales',
                            'Transporte de generadores industriales',
                            'Transporte de equipos de minería',
                            'Transporte de maquinaria especializada',
                            'Transporte de equipos agrícolas pesados'
                        ],
                        'technical_specs' => [
                            'Año: 2002',
                            'Serie: 13ND5340423514722',
                            'Capacidad: 40-50 toneladas (80,000-100,000 lbs)',
                            'Longitud de plataforma: 24-29 pies (7.3-8.8 m)',
                            'Altura de plataforma: 18-24 pulgadas (0.46-0.61 m)',
                            'Longitud total: 48-53 pies (14.6-16.2 m)',
                            'Ancho: 8.5 pies (2.6 m)',
                            'Ejes: Configuración tándem o tri-eje',
                            'Suspensión: Suspensión neumática',
                            'Llantas: 255/70R22.5 o 11R22.5',
                            'Frenos: Frenos de aire con sistema ABS',
                            'Peso del remolque: Aproximadamente 18,000-22,000 lbs',
                            'Material: Construcción de acero de alta resistencia'
                        ]
                    ],
                    'en' => [
                        'description' => 'The LOW BOY trailer from year 2002 is a robust and reliable solution for heavy machinery transport. Its low platform design and high load capacity make it ideal for transporting large construction equipment and industrial machinery.',
                        'features' => [
                            'Low platform 18-24 inches height',
                            '40-50 ton load capacity',
                            '24-29 feet platform length',
                            'Air ride suspension for smooth travel',
                            'Air brake system with ABS',
                            '255/70R22.5 or 11R22.5 tires',
                            'Tandem or tri-axle configuration',
                            'Standard 8.5 feet width',
                            'Overall length 48-53 feet',
                            'High-strength steel construction'
                        ],
                        'applications' => [
                            'Large excavator transport',
                            'Bulldozer transport',
                            'Heavy construction machinery transport',
                            'Industrial equipment transport',
                            'Industrial generator transport',
                            'Mining equipment transport',
                            'Specialized machinery transport',
                            'Heavy agricultural equipment transport'
                        ],
                        'technical_specs' => [
                            'Year: 2002',
                            'Serial: 13ND5340423514722',
                            'Capacity: 40-50 tons (80,000-100,000 lbs)',
                            'Deck length: 24-29 feet (7.3-8.8 m)',
                            'Deck height: 18-24 inches (0.46-0.61 m)',
                            'Overall length: 48-53 feet (14.6-16.2 m)',
                            'Width: 8.5 feet (2.6 m)',
                            'Axles: Tandem or tri-axle configuration',
                            'Suspension: Air ride suspension',
                            'Tires: 255/70R22.5 or 11R22.5',
                            'Brakes: Air brakes with ABS system',
                            'Trailer weight: Approximately 18,000-22,000 lbs',
                            'Material: High-strength steel construction'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/lowboy-2002.svg',
                    'assets/img/gallery/lowboy3.jpg',
                    'assets/img/gallery/lowboy4.jpg'
                ]
            ],
            
            'lowboy-2005' => [
                'slug' => 'lowboy-2005',
                'name' => [
                    'es' => 'LOW BOY 2005',
                    'en' => 'LOW BOY 2005'
                ],
                'description' => [
                    'es' => 'Remolque LOW BOY del año 2005 con número de serie 1L9GA72A65L033420, diseñado para el transporte de maquinaria pesada y equipos de construcción. Con capacidad de 40-55 toneladas y plataforma baja para facilitar la carga y descarga.',
                    'en' => 'LOW BOY trailer from year 2005 with serial number 1L9GA72A65L033420, designed for transporting heavy machinery and construction equipment. With 40-55 ton capacity and low platform for easy loading and unloading.'
                ],
                'image' => 'assets/img/equipos/lowboy-2005.svg',
                'icon' => 'assets/img/icon/lowboy-icon.svg',
                'specs' => [
                    'es' => [
                        'Capacidad: 40-55 toneladas (80,000-110,000 lbs)',
                        'Longitud de plataforma: 24-29 pies',
                        'Altura de plataforma: 18-24 pulgadas',
                        'Suspensión neumática',
                        'Frenos de aire con ABS'
                    ],
                    'en' => [
                        'Capacity: 40-55 tons (80,000-110,000 lbs)',
                        'Deck length: 24-29 feet',
                        'Deck height: 18-24 inches',
                        'Air ride suspension',
                        'Air brakes with ABS'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'El remolque LOW BOY del año 2005 con número de serie 1L9GA72A65L033420 es una solución robusta y confiable para el transporte de maquinaria pesada. Su diseño de plataforma baja y alta capacidad de carga lo hacen ideal para transportar equipos de construcción y maquinaria industrial de gran tamaño.',
                        'features' => [
                            'Plataforma baja de 18-24 pulgadas de altura',
                            'Capacidad de carga de 40-55 toneladas',
                            'Longitud de plataforma de 24-29 pies',
                            'Suspensión neumática para viaje suave',
                            'Sistema de frenos de aire con ABS',
                            'Llantas 255/70R22.5 o 11R22.5',
                            'Configuración de ejes tándem o tri-eje',
                            'Ancho estándar de 8.5 pies',
                            'Longitud total de 48-53 pies',
                            'Cuello de ganso desmontable (RGN)'
                        ],
                        'applications' => [
                            'Transporte de maquinaria pesada',
                            'Transporte de equipo de construcción',
                            'Transporte de excavadoras',
                            'Transporte de bulldozers',
                            'Transporte de grúas',
                            'Transporte de equipos industriales',
                            'Transporte de maquinaria especializada'
                        ],
                        'technical_specs' => [
                            'Año: 2005',
                            'Número de serie: 1L9GA72A65L033420',
                            'Capacidad: 40-55 toneladas (80,000-110,000 lbs)',
                            'Longitud de plataforma: 24-29 pies (7.3-8.8 m)',
                            'Altura de plataforma: 18-24 pulgadas (0.46-0.61 m)',
                            'Longitud total: 48-53 pies (14.6-16.2 m)',
                            'Ancho: 8.5 pies (2.6 m)',
                            'Ejes: Configuración tándem/tri-eje',
                            'Suspensión: Suspensión neumática',
                            'Llantas: 255/70R22.5 o 11R22.5',
                            'Frenos: Frenos de aire con ABS',
                            'Cuello de ganso: Desmontable (RGN)'
                        ]
                    ],
                    'en' => [
                        'description' => 'The LOW BOY trailer from year 2005 with serial number 1L9GA72A65L033420 is a robust and reliable solution for heavy machinery transport. Its low platform design and high load capacity make it ideal for transporting large construction equipment and industrial machinery.',
                        'features' => [
                            'Low platform 18-24 inches height',
                            '40-55 ton load capacity',
                            '24-29 feet platform length',
                            'Air ride suspension for smooth travel',
                            'Air brake system with ABS',
                            '255/70R22.5 or 11R22.5 tires',
                            'Tandem or tri-axle configuration',
                            'Standard 8.5 feet width',
                            'Overall length 48-53 feet',
                            'Removable gooseneck (RGN)'
                        ],
                        'applications' => [
                            'Heavy machinery transport',
                            'Construction equipment transport',
                            'Excavator transport',
                            'Bulldozer transport',
                            'Crane transport',
                            'Industrial equipment transport',
                            'Specialized machinery transport'
                        ],
                        'technical_specs' => [
                            'Year: 2005',
                            'Serial number: 1L9GA72A65L033420',
                            'Capacity: 40-55 tons (80,000-110,000 lbs)',
                            'Deck length: 24-29 feet (7.3-8.8 m)',
                            'Deck height: 18-24 inches (0.46-0.61 m)',
                            'Overall length: 48-53 feet (14.6-16.2 m)',
                            'Width: 8.5 feet (2.6 m)',
                            'Axles: Tandem/tri-axle configuration',
                            'Suspension: Air ride suspension',
                            'Tires: 255/70R22.5 or 11R22.5',
                            'Brakes: Air brakes with ABS',
                            'Gooseneck: Removable (RGN)'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/lowboy-2005.svg',
                    'assets/img/gallery/lowboy5.jpg',
                    'assets/img/gallery/lowboy6.jpg'
                ]
            ],
            [
                'slug' => 'lowboy-1996',
                'name' => [
                    'es' => 'LOW BOY 1996',
                    'en' => 'LOW BOY 1996'
                ],
                'description' => [
                    'es' => 'Remolque Low Boy año 1996, Serie: 1LH17AUH2T1007759, capacidad 40-50 toneladas para transporte de maquinaria pesada y equipos de construcción.',
                    'en' => 'Low Boy trailer year 1996, Serial: 1LH17AUH2T1007759, 40-50 ton capacity for heavy machinery and construction equipment transport.'
                ],
                'image' => 'assets/img/equipos/lowboy-1996.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 40-50 toneladas',
                        'Plataforma baja: 18-24 pulgadas',
                        'Configuración: Tándem/Tri-eje'
                    ],
                    'en' => [
                        'Capacity: 40-50 tons',
                        'Low platform: 18-24 inches',
                        'Configuration: Tandem/Tri-axle'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestro remolque Low Boy del año 1996 (Serie: 1LH17AUH2T1007759) es una solución confiable y robusta para el transporte de maquinaria pesada. Su diseño de plataforma baja facilita la carga y descarga de equipos de gran tamaño, siendo ideal para proyectos de construcción e infraestructura.',
                        'features' => [
                            'Número de serie: 1LH17AUH2T1007759',
                            'Capacidad de carga: 40-50 toneladas',
                            'Configuración de ejes: Tándem/Tri-eje',
                            'Suspensión: Neumática/Resortes',
                            'Cuello desmontable hidráulico/mecánico',
                            'Neumáticos: 11R22.5 o 255/70R22.5',
                            'Frenos neumáticos con ABS'
                        ],
                        'applications' => [
                            'Transporte de maquinaria pesada',
                            'Equipos de construcción',
                            'Vehículos industriales',
                            'Excavadoras y bulldozers',
                            'Grúas y equipos industriales',
                            'Maquinaria agrícola de gran tamaño'
                        ],
                        'technical_specs' => [
                            'Año: 1996',
                            'Número de serie: 1LH17AUH2T1007759',
                            'Capacidad de carga: 40-50 toneladas',
                            'Longitud de plataforma: 24-29 pies',
                            'Altura de plataforma: 18-24 pulgadas',
                            'Longitud total: 48-53 pies',
                            'Ancho: 8.5 pies',
                            'Configuración: Tándem/Tri-eje',
                            'Suspensión: Neumática/Resortes',
                            'Frenos: Neumáticos con ABS'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our Low Boy trailer from year 1996 (Serial: 1LH17AUH2T1007759) is a reliable and robust solution for heavy machinery transport. Its low platform design facilitates loading and unloading of large equipment, making it ideal for construction and infrastructure projects.',
                        'features' => [
                            'Serial number: 1LH17AUH2T1007759',
                            'Load capacity: 40-50 tons',
                            'Axle configuration: Tandem/Tri-axle',
                            'Suspension: Air/Spring',
                            'Detachable hydraulic/mechanical neck',
                            'Tires: 11R22.5 or 255/70R22.5',
                            'Air brakes with ABS'
                        ],
                        'applications' => [
                            'Heavy machinery transport',
                            'Construction equipment',
                            'Industrial vehicles',
                            'Excavators and bulldozers',
                            'Cranes and industrial equipment',
                            'Large agricultural machinery'
                        ],
                        'technical_specs' => [
                            'Year: 1996',
                            'Serial number: 1LH17AUH2T1007759',
                            'Load capacity: 40-50 tons',
                            'Deck length: 24-29 ft',
                            'Deck height: 18-24 in',
                            'Overall length: 48-53 ft',
                            'Width: 8.5 ft',
                            'Configuration: Tandem/Tri-axle',
                            'Suspension: Air/Spring',
                            'Brakes: Air brakes with ABS'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/lowboy-1996.png',
                    'assets/img/gallery/lowboy1.jpg',
                    'assets/img/gallery/lowboy2.jpg'
                ]
            ],
            [
                'slug' => 'plataforma-plana-1990',
                'name' => [
                    'es' => 'PLATAFORMA PLANA 1990',
                    'en' => 'FLATBED PLATFORM 1990'
                ],
                'description' => [
                    'es' => 'Plataforma plana año 1990, VIN: 1S12FF450MB332380, capacidad 48,000-80,000 lbs para transporte de carga general, materiales de construcción y maquinaria.',
                    'en' => 'Flatbed platform year 1990, VIN: 1S12FF450MB332380, 48,000-80,000 lbs capacity for general cargo transport, construction materials and machinery.'
                ],
                'image' => 'assets/img/equipos/plataforma-plana-1990.png',
                'icon' => 'assets/img/icon/services_icon1.png',
                'specs' => [
                    'es' => [
                        'Capacidad: 48,000-80,000 lbs',
                        'Longitud: 48-53 pies',
                        'Configuración: Tándem (2 ejes)'
                    ],
                    'en' => [
                        'Capacity: 48,000-80,000 lbs',
                        'Length: 48-53 ft',
                        'Configuration: Tandem (2 axles)'
                    ]
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestra plataforma plana del año 1990 (VIN: 1S12FF450MB332380) es una solución versátil y confiable para el transporte de carga general. Su diseño de plataforma abierta permite transportar una amplia variedad de materiales y equipos, siendo ideal para proyectos de construcción y logística industrial.',
                        'features' => [
                            'VIN: 1S12FF450MB332380',
                            'Capacidad de carga: 48,000-80,000 lbs',
                            'Longitud: 48-53 pies',
                            'Ancho: 102 pulgadas (8.5 pies)',
                            'Altura de plataforma: 60 pulgadas',
                            'Configuración de ejes: Tándem (2 ejes)',
                            'Suspensión: Resortes de acero',
                            'Neumáticos: 11R22.5',
                            'Frenos: Neumáticos',
                            'Material: Acero con plataforma antideslizante'
                        ],
                        'applications' => [
                            'Transporte de carga general',
                            'Materiales de construcción',
                            'Maquinaria industrial',
                            'Contenedores',
                            'Equipos de construcción',
                            'Materiales de acero',
                            'Productos manufacturados',
                            'Equipos agrícolas'
                        ],
                        'technical_specs' => [
                            'Año: 1990',
                            'VIN: 1S12FF450MB332380',
                            'Capacidad de carga: 48,000-80,000 lbs',
                            'Peso en vacío: 12,000-15,000 lbs',
                            'Longitud: 48-53 pies',
                            'Ancho: 102 pulgadas (8.5 pies)',
                            'Altura de plataforma: 60 pulgadas',
                            'Configuración de ejes: Tándem (2 ejes)',
                            'Suspensión: Resortes de acero',
                            'Neumáticos: 11R22.5',
                            'Frenos: Neumáticos',
                            'Material: Acero con superficie antideslizante'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our flatbed platform from year 1990 (VIN: 1S12FF450MB332380) is a versatile and reliable solution for general cargo transport. Its open platform design allows transporting a wide variety of materials and equipment, making it ideal for construction projects and industrial logistics.',
                        'features' => [
                            'VIN: 1S12FF450MB332380',
                            'Load capacity: 48,000-80,000 lbs',
                            'Length: 48-53 ft',
                            'Width: 102 in (8.5 ft)',
                            'Deck height: 60 in',
                            'Axle configuration: Tandem (2 axles)',
                            'Suspension: Steel springs',
                            'Tires: 11R22.5',
                            'Brakes: Air brakes',
                            'Material: Steel with anti-slip deck'
                        ],
                        'applications' => [
                            'General cargo transport',
                            'Construction materials',
                            'Industrial machinery',
                            'Containers',
                            'Construction equipment',
                            'Steel materials',
                            'Manufactured products',
                            'Agricultural equipment'
                        ],
                        'technical_specs' => [
                            'Year: 1990',
                            'VIN: 1S12FF450MB332380',
                            'Load capacity: 48,000-80,000 lbs',
                            'Empty weight: 12,000-15,000 lbs',
                            'Length: 48-53 ft',
                            'Width: 102 in (8.5 ft)',
                            'Deck height: 60 in',
                            'Axle configuration: Tandem (2 axles)',
                            'Suspension: Steel springs',
                            'Tires: 11R22.5',
                            'Brakes: Air brakes',
                            'Material: Steel with anti-slip surface'
                        ]
                    ]
                ],
                'gallery' => [
                    'assets/img/equipos/plataforma-plana-1990.png',
                    'assets/img/gallery/flatbed1.jpg',
                    'assets/img/gallery/flatbed2.jpg'
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
                    <img src="/assets/img/gallery/safe_in.png" alt="">
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