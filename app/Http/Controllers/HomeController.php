<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio
     */
    public function index(Request $request)
    {
        // Detectar idioma preferido
        $language = $this->detectLanguage($request);
        
        // Guardar idioma en sesión
        Session::put('language', $language);
        
        return view('welcome', compact('language'));
    }
    
    /**
     * Mostrar página acerca de nosotros
     */
    public function about(Request $request)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        return view('about', compact('language'));
    }
    
    /**
     * Mostrar página de contacto
     */
    public function contact(Request $request)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        return view('contact', compact('language'));
    }
    
    /**
     * Mostrar página de servicios
     */
    public function services(Request $request)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        return view('services', compact('language'));
    }
    
    /**
     * Mostrar página de detalles de servicios
     */
    public function servicesDetails(Request $request, $service = null)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        // Datos específicos para cada servicio
        $serviceData = $this->getServiceData($service, $language);
        
        return view('services_details', compact('language', 'serviceData'));
    }
    
    /**
     * Mostrar página de equipos
     */
    public function equipos(Request $request)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        return view('equipos', compact('language'));
    }
    
    /**
     * Métodos específicos para español
     */
    public function indexEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('welcome', compact('language'));
    }
    
    public function aboutEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('about', compact('language'));
    }
    
    public function contactEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('contact', compact('language'));
    }
    
    public function servicesEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('services', compact('language'));
    }
    
    public function servicesDetailsEs(Request $request, $service = null)
    {
        $language = 'es';
        Session::put('language', $language);
        
        // Datos específicos para cada servicio
        $serviceData = $this->getServiceData($service, $language);
        
        return view('services_details', compact('language', 'serviceData'));
    }
    
    public function equiposEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('equipos', compact('language'));
    }
    
    public function equiposDetailEs(Request $request, $slug)
    {
        $language = 'es';
        Session::put('language', $language);
        
        $equipment = $this->getEquipmentBySlug($slug, $language);
        
        if (!$equipment) {
            abort(404);
        }
        
        return view('equipos-detalle', compact('language', 'equipment'));
    }
    
    /**
     * Métodos específicos para inglés
     */
    public function indexEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('welcome', compact('language'));
    }
    
    public function aboutEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('about', compact('language'));
    }
    
    public function contactEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('contact', compact('language'));
    }
    
    public function servicesEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('services', compact('language'));
    }
    
    public function servicesDetailsEn(Request $request, $service = null)
    {
        $language = 'en';
        Session::put('language', $language);
        
        // Datos específicos para cada servicio
        $serviceData = $this->getServiceData($service, $language);
        
        return view('services_details', compact('language', 'serviceData'));
    }
    
    public function equiposEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('equipos', compact('language'));
    }
    
    public function equiposDetailEn(Request $request, $slug)
    {
        $language = 'en';
        Session::put('language', $language);
        
        $equipment = $this->getEquipmentBySlug($slug, $language);
        
        if (!$equipment) {
            abort(404);
        }
        
        return view('equipos-detalle', compact('language', 'equipment'));
    }
    
    public function equiposDetail(Request $request, $slug)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        $equipment = $this->getEquipmentBySlug($slug, $language);
        
        if (!$equipment) {
            abort(404);
        }
        
        return view('equipos-detalle', compact('language', 'equipment'));
    }
    
    /**
     * Cambiar idioma y recargar página
     */
    public function changeLanguage(Request $request, $language)
    {
        // Validar idioma
        if (!in_array($language, ['es', 'en'])) {
            $language = 'es';
        }
        
        // Guardar en sesión y cookie
        Session::put('language', $language);
        Cookie::queue('vilba_language', $language, 60 * 24 * 30); // 30 días
        
        // Obtener la URL actual desde el parámetro o el referer como fallback
        $currentUrl = $request->input('current_url') ?? $request->header('referer');
        $currentView = 'home'; // Vista por defecto
        
        // Debug: Log para verificar la URL actual
        \Log::info('Language Change Debug', [
            'current_url' => $currentUrl,
            'target_language' => $language,
            'method' => $request->method()
        ]);
        
        // Variables para detectar páginas de detalle de equipos
        $equipmentSlug = null;
        
        // Detectar la vista actual basándose en la URL actual
        if ($currentUrl) {
            // Normalizar la URL removiendo el dominio y parámetros
            $path = parse_url($currentUrl, PHP_URL_PATH);
            
            // Detectar vista basándose en el path
            if (strpos($path, '/acerca') !== false || strpos($path, '/about') !== false || 
                strpos($path, '/ES/acerca') !== false || strpos($path, '/EN/about') !== false) {
                $currentView = 'about';
            } elseif (strpos($path, '/contacto') !== false || strpos($path, '/contact') !== false ||
                     strpos($path, '/ES/contacto') !== false || strpos($path, '/EN/contact') !== false) {
                $currentView = 'contact';
            } elseif (strpos($path, '/detalle-servicio') !== false || 
                     strpos($path, '/ES/detalle-servicio') !== false || strpos($path, '/EN/detalle-servicio') !== false) {
                $currentView = 'services-detail';
            } elseif (preg_match('/\/(ES\/)?equipos\/([^\/?]+)/', $path, $matches) || 
                     preg_match('/\/(EN\/)?equipment\/([^\/?]+)/', $path, $matches)) {
                // Detectar página de detalle de equipos y extraer slug
                $currentView = 'equipos-detail';
                $equipmentSlug = end($matches); // Obtener el último match que es el slug
            } elseif (strpos($path, '/equipos') !== false || strpos($path, '/equipment') !== false ||
                     strpos($path, '/ES/equipos') !== false || strpos($path, '/EN/equipment') !== false) {
                $currentView = 'equipos';
            } elseif (strpos($path, '/servicios') !== false || strpos($path, '/services') !== false ||
                     strpos($path, '/ES/servicios') !== false || strpos($path, '/EN/services') !== false) {
                $currentView = 'services';
            }
        }
        
        // Log del resultado de detección
        \Log::info('View Detection Result', [
            'detected_view' => $currentView,
            'equipment_slug' => $equipmentSlug,
            'path' => $path ?? 'no_path'
        ]);
        
        // Manejar redirección especial para páginas de detalle de equipos
        if ($currentView === 'equipos-detail' && $equipmentSlug) {
            $targetRoute = $language === 'en' ? 'equipos.detail.EN' : 'equipos.detail.ES';
            
            \Log::info('Equipment Detail Redirect', [
                'target_route' => $targetRoute,
                'slug' => $equipmentSlug
            ]);
            
            return redirect()->route($targetRoute, ['slug' => $equipmentSlug]);
        }
        
        // Redirigir a la vista actual en el idioma seleccionado
        $routeMap = [
            'home' => $language === 'en' ? 'home.EN' : 'home.ES',
            'about' => $language === 'en' ? 'about.EN' : 'about.ES',
            'contact' => $language === 'en' ? 'contact.EN' : 'contact.ES',
            'services' => $language === 'en' ? 'services.EN' : 'services.ES',
            'equipos' => $language === 'en' ? 'equipos.EN' : 'equipos.ES',
            'services-detail' => $language === 'en' ? 'services-detail.EN' : 'services-detail.ES'
        ];
        
        $targetRoute = $routeMap[$currentView] ?? ($language === 'en' ? 'home.EN' : 'home.ES');
        
        \Log::info('Final Redirect', [
            'target_route' => $targetRoute
        ]);
        
        return redirect()->route($targetRoute);
    }
    
    /**
     * Detectar idioma preferido del usuario
     */
    private function detectLanguage(Request $request)
    {
        // 1. Verificar parámetro de URL
        if ($request->has('lang') && in_array($request->get('lang'), ['es', 'en'])) {
            return $request->get('lang');
        }
        
        // 2. Verificar sesión
        if (Session::has('language')) {
            return Session::get('language');
        }
        
        // 3. Verificar cookie
        if ($request->hasCookie('vilba_language')) {
            $cookieLang = $request->cookie('vilba_language');
            if (in_array($cookieLang, ['es', 'en'])) {
                return $cookieLang;
            }
        }
        
        // 4. Detectar desde headers del navegador
        $acceptLanguage = $request->header('Accept-Language');
        if ($acceptLanguage) {
            if (strpos($acceptLanguage, 'en') !== false) {
                return 'en';
            }
        }
        
        // 5. Detectar por IP geográfica (opcional)
        try {
            $userIP = $request->ip();
            // Solo intentar detección geográfica si no es IP local
            if ($userIP !== '127.0.0.1' && $userIP !== '::1') {
                $geoData = @file_get_contents("http://ip-api.com/json/{$userIP}");
                if ($geoData) {
                    $geo = json_decode($geoData, true);
                    if (isset($geo['countryCode']) && $geo['countryCode'] === 'MX') {
                        return 'es';
                    } elseif (isset($geo['countryCode']) && in_array($geo['countryCode'], ['US', 'CA', 'GB', 'AU'])) {
                        return 'en';
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignorar errores de detección geográfica
        }
        
        // 6. Idioma por defecto
        return 'es';
    }
    
    /**
     * Obtener datos del equipo por slug
     */
    private function getEquipmentBySlug($slug, $language = 'es')
    {
        $equipments = [
            'retroexcavadora-414E' => [
                'slug' => 'retroexcavadora-414E',
                'name' => [
                    'es' => 'Retroexcavadora 414E',
                    'en' => 'Backhoe Loader 414E'
                ],
                'description' => [
                    'es' => 'Retroexcavadora Caterpillar 414E versátil para excavación y carga de materiales.',
                    'en' => 'Versatile Caterpillar 414E backhoe loader for excavation and material loading.'
                ],
                'hero_image' => 'assets/img/gallery/services1.jpg',
                'gallery' => [
                    'assets/img/gallery/services1.jpg',
                    'assets/img/gallery/services2.jpg',
                    'assets/img/gallery/services3.jpg'
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'La retroexcavadora Caterpillar 414E combina potencia y versatilidad para trabajos de excavación, carga y manipulación de materiales con máxima eficiencia.',
                        'features' => [
                            'Motor Cat C4.4 ACERT de 97 HP',
                            'Transmisión powershift de 4 velocidades',
                            'Brazo excavador con alcance de 5.49m',
                            'Cargador frontal con capacidad de 1.0 m³',
                            'Cabina ROPS/FOPS con aire acondicionado'
                        ],
                        'applications' => [
                            'Excavación de zanjas y cimientos',
                            'Carga y descarga de materiales',
                            'Trabajos de paisajismo',
                            'Mantenimiento de servicios públicos'
                        ],
                        'technical_specs' => [
                            'Potencia del motor: 97 HP (72 kW)',
                            'Peso operativo: 8,165 kg',
                            'Profundidad de excavación: 4.27m',
                            'Capacidad del cucharón: 0.24 m³',
                            'Altura de descarga: 2.59m'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Caterpillar 414E backhoe loader combines power and versatility for excavation, loading and material handling work with maximum efficiency.',
                        'features' => [
                            'Cat C4.4 ACERT engine 97 HP',
                            '4-speed powershift transmission',
                            'Excavator arm with 5.49m reach',
                            'Front loader with 1.0 m³ capacity',
                            'ROPS/FOPS cabin with air conditioning'
                        ],
                        'applications' => [
                            'Trench and foundation excavation',
                            'Material loading and unloading',
                            'Landscaping work',
                            'Utility maintenance'
                        ],
                        'technical_specs' => [
                            'Engine power: 97 HP (72 kW)',
                            'Operating weight: 8,165 kg',
                            'Digging depth: 4.27m',
                            'Bucket capacity: 0.24 m³',
                            'Dump height: 2.59m'
                        ]
                    ]
                ]
            ],
            'tower-cranes' => [
                'slug' => 'tower-cranes',
                'name' => [
                    'es' => 'Grúas Torre',
                    'en' => 'Tower Cranes'
                ],
                'description' => [
                    'es' => 'Grúas torre de alta capacidad para proyectos de construcción de todos los tamaños.',
                    'en' => 'High-capacity tower cranes for construction projects of all sizes.'
                ],
                'hero_image' => 'assets/img/gallery/services1.jpg',
                'gallery' => [
                    'assets/img/gallery/services1.jpg',
                    'assets/img/gallery/services2.jpg',
                    'assets/img/gallery/services3.jpg'
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras grúas torre ofrecen soluciones de elevación confiables y eficientes para proyectos de construcción de gran envergadura. Con tecnología de punta y operadores certificados.',
                        'features' => [
                            'Capacidad de carga hasta 25 toneladas',
                            'Altura máxima de 80 metros',
                            'Alcance horizontal hasta 70 metros',
                            'Sistema de control computarizado',
                            'Operadores certificados incluidos'
                        ],
                        'applications' => [
                            'Construcción de edificios altos',
                            'Proyectos residenciales',
                            'Construcción comercial',
                            'Infraestructura urbana'
                        ],
                        'technical_specs' => [
                            'Carga máxima: 25 toneladas',
                            'Altura bajo gancho: 80m',
                            'Alcance máximo: 70m',
                            'Velocidad de elevación: 120 m/min',
                            'Rotación: 360° continua'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our tower cranes offer reliable and efficient lifting solutions for large-scale construction projects. Featuring cutting-edge technology and certified operators.',
                        'features' => [
                            'Load capacity up to 25 tons',
                            'Maximum height of 80 meters',
                            'Horizontal reach up to 70 meters',
                            'Computerized control system',
                            'Certified operators included'
                        ],
                        'applications' => [
                            'High-rise building construction',
                            'Residential projects',
                            'Commercial construction',
                            'Urban infrastructure'
                        ],
                        'technical_specs' => [
                            'Maximum load: 25 tons',
                            'Hook height: 80m',
                            'Maximum reach: 70m',
                            'Lifting speed: 120 m/min',
                            'Rotation: 360° continuous'
                        ]
                    ]
                ]
            ],
            'camion-kenworth' => [
                'slug' => 'camion-kenworth',
                'name' => [
                    'es' => 'Camión Kenworth',
                    'en' => 'Kenworth Truck'
                ],
                'description' => [
                    'es' => 'Camión Kenworth T880 de trabajo pesado para transporte y construcción.',
                    'en' => 'Heavy-duty Kenworth T880 truck for transport and construction.'
                ],
                'hero_image' => 'assets/img/equipos/camion-kenworth-cover.png',
                'gallery' => [
                    'assets/img/gallery/services2.jpg',
                    'assets/img/gallery/services1.jpg',
                    'assets/img/gallery/services4.jpg'
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'El Kenworth T880 es un camión de trabajo pesado diseñado para las aplicaciones más exigentes con durabilidad excepcional y rendimiento superior.',
                        'features' => [
                            'Motor PACCAR MX-13 de 12.9L',
                            'Transmisión Eaton Fuller 18 velocidades',
                            'Chasis reforzado para trabajo pesado',
                            'Cabina con suspensión neumática',
                            'Sistema de frenos con ABS y control de estabilidad'
                        ],
                        'applications' => [
                            'Transporte de materiales de construcción',
                            'Operaciones de minería y canteras',
                            'Transporte de carga pesada',
                            'Aplicaciones de volteo y construcción'
                        ],
                        'technical_specs' => [
                            'Motor: PACCAR MX-13 12.9L',
                            'Potencia: 510 HP @ 1,700 rpm',
                            'Torque: 1,850 lb-ft @ 1,000 rpm',
                            'GVWR: hasta 80,000 lbs (36,287 kg)',
                            'Transmisión: Eaton Fuller 18 velocidades'
                        ]
                    ],
                    'en' => [
                        'description' => 'The Kenworth T880 is a heavy-duty truck designed for the most demanding applications with exceptional durability and superior performance.',
                        'features' => [
                            'PACCAR MX-13 12.9L engine',
                            'Eaton Fuller 18-speed transmission',
                            'Heavy-duty reinforced chassis',
                            'Air-suspended cab',
                            'ABS brake system with stability control'
                        ],
                        'applications' => [
                            'Construction material transport',
                            'Mining and quarry operations',
                            'Heavy haul transport',
                            'Dump and construction applications'
                        ],
                        'technical_specs' => [
                            'Engine: PACCAR MX-13 12.9L',
                            'Power: 510 HP @ 1,700 rpm',
                            'Torque: 1,850 lb-ft @ 1,000 rpm',
                            'GVWR: up to 80,000 lbs (36,287 kg)',
                            'Transmission: Eaton Fuller 18-speed'
                        ]
                    ]
                ]
            ],
            'mobile-cranes' => [
                'slug' => 'mobile-cranes',
                'name' => [
                    'es' => 'Grúas Móviles',
                    'en' => 'Mobile Cranes'
                ],
                'description' => [
                    'es' => 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible.',
                    'en' => 'Versatile mobile cranes for quick setup and flexible positioning.'
                ],
                'hero_image' => 'assets/img/gallery/services2.jpg',
                'gallery' => [
                    'assets/img/gallery/services2.jpg',
                    'assets/img/gallery/services1.jpg',
                    'assets/img/gallery/services4.jpg'
                ],
                'detailed_info' => [
                    'es' => [
                        'description' => 'Nuestras grúas móviles proporcionan la flexibilidad necesaria para proyectos que requieren movilidad y configuración rápida. Ideales para trabajos en múltiples ubicaciones.',
                        'features' => [
                            'Capacidad de carga hasta 50 toneladas',
                            'Longitud de pluma hasta 60 metros',
                            'Movilidad todo terreno',
                            'Configuración rápida en sitio',
                            'Operación hidráulica suave'
                        ],
                        'applications' => [
                            'Montaje de estructuras prefabricadas',
                            'Trabajos de mantenimiento industrial',
                            'Construcción en espacios reducidos',
                            'Proyectos temporales'
                        ],
                        'technical_specs' => [
                            'Carga máxima: 50 toneladas',
                            'Longitud de pluma: 60m',
                            'Radio de trabajo: 48m',
                            'Velocidad de traslado: 80 km/h',
                            'Estabilizadores: Hidráulicos'
                        ]
                    ],
                    'en' => [
                        'description' => 'Our mobile cranes provide the flexibility needed for projects requiring mobility and quick setup. Ideal for work at multiple locations.',
                        'features' => [
                            'Load capacity up to 50 tons',
                            'Boom length up to 60 meters',
                            'All-terrain mobility',
                            'Quick on-site setup',
                            'Smooth hydraulic operation'
                        ],
                        'applications' => [
                            'Prefabricated structure assembly',
                            'Industrial maintenance work',
                            'Construction in confined spaces',
                            'Temporary projects'
                        ],
                        'technical_specs' => [
                            'Maximum load: 50 tons',
                            'Boom length: 60m',
                            'Working radius: 48m',
                            'Travel speed: 80 km/h',
                            'Outriggers: Hydraulic'
                        ]
                    ]
                 ]
             ],
             'Retroexcavadora 416F' => [
                 'slug' => 'retroexcavadora-416F',
                 'name' => [
                     'es' => 'Retroexcavadora 416F',
                     'en' => 'Backhoe Loader 416F'
                 ],
                 'description' => [
                     'es' => 'Retroexcavadora 416F de alto rendimiento para excavación y carga.',
                     'en' => 'High-performance 416F backhoe loader for excavation and loading.'
                 ],
                 'hero_image' => 'assets/img/gallery/services3.jpg',
                 'gallery' => [
                     'assets/img/equipos/Retro-416F.png',
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services5.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'La retroexcavadora Caterpillar 416F combina potencia y versatilidad para realizar tareas de excavación, carga y movimiento de tierra con máxima eficiencia y productividad.',
                         'features' => [
                             'Motor Cat C4.4 ACERT de 4.4L turboalimentado',
                             'Transmisión powershift de 4 velocidades',
                             'Brazo excavador con alcance de 5.49m',
                             'Cargador frontal con capacidad de 1.0 m³',
                             'Sistema hidráulico de caudal variable'
                         ],
                         'applications' => [
                             'Excavación de zanjas y cimientos',
                             'Carga y descarga de materiales',
                             'Trabajos de paisajismo y jardinería',
                             'Mantenimiento de carreteras y servicios'
                         ],
                         'technical_specs' => [
                             'Motor: Cat C4.4 ACERT 4.4L',
                             'Potencia: 109 HP @ 2,200 rpm',
                             'Peso operativo: 8,846 kg',
                             'Alcance máximo excavación: 5.49m',
                             'Profundidad de excavación: 4.27m'
                         ]
                     ],
                     'en' => [
                         'description' => 'The Caterpillar 416F backhoe loader combines power and versatility to perform excavation, loading, and earthmoving tasks with maximum efficiency and productivity.',
                         'features' => [
                             'Cat C4.4 ACERT 4.4L turbocharged engine',
                             '4-speed powershift transmission',
                             'Excavator arm with 5.49m reach',
                             'Front loader with 1.0 m³ capacity',
                             'Variable flow hydraulic system'
                         ],
                         'applications' => [
                             'Trench and foundation excavation',
                             'Material loading and unloading',
                             'Landscaping and gardening work',
                             'Road maintenance and utilities'
                         ],
                         'technical_specs' => [
                             'Engine: Cat C4.4 ACERT 4.4L',
                             'Power: 109 HP @ 2,200 rpm',
                             'Operating weight: 8,846 kg',
                             'Maximum dig reach: 5.49m',
                             'Dig depth: 4.27m'
                         ]
                     ]
                 ]
             ],
             'forklifts' => [
                 'slug' => 'forklifts',
                 'name' => [
                     'es' => 'Montacargas',
                     'en' => 'Forklifts'
                 ],
                 'description' => [
                     'es' => 'Montacargas de servicio pesado para manejo de materiales y operaciones de almacén.',
                     'en' => 'Heavy-duty forklifts for material handling and warehouse operations.'
                 ],
                 'hero_image' => 'assets/img/gallery/services3.jpg',
                 'gallery' => [
                     'assets/img/gallery/services3.jpg',
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services5.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestros montacargas ofrecen soluciones eficientes para el manejo de materiales en almacenes, fábricas y sitios de construcción. Disponibles en versiones eléctricas y diésel.',
                         'features' => [
                             'Capacidad de carga hasta 10 toneladas',
                             'Altura de elevación hasta 8 metros',
                             'Opciones eléctricas y diésel',
                             'Cabina ergonómica con visibilidad 360°',
                             'Sistema hidráulico de alta eficiencia'
                         ],
                         'applications' => [
                             'Manejo de materiales en almacenes',
                             'Carga y descarga de camiones',
                             'Operaciones en fábricas',
                             'Construcción y obras civiles'
                         ],
                         'technical_specs' => [
                             'Carga máxima: 10 toneladas',
                             'Altura de elevación: 8m',
                             'Tipo de combustible: Eléctrico/Diésel',
                             'Velocidad de elevación: 0.5 m/s',
                             'Radio de giro: 2.8m'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our forklifts offer efficient solutions for material handling in warehouses, factories, and construction sites. Available in electric and diesel versions.',
                         'features' => [
                             'Load capacity up to 10 tons',
                             'Lift height up to 8 meters',
                             'Electric and diesel options',
                             'Ergonomic cabin with 360° visibility',
                             'High-efficiency hydraulic system'
                         ],
                         'applications' => [
                             'Warehouse material handling',
                             'Truck loading and unloading',
                             'Factory operations',
                             'Construction and civil works'
                         ],
                         'technical_specs' => [
                             'Maximum load: 10 tons',
                             'Lift height: 8m',
                             'Fuel type: Electric/Diesel',
                             'Lifting speed: 0.5 m/s',
                             'Turning radius: 2.8m'
                         ]
                     ]
                 ]
             ],
             'lowboy-2005' => [
                 'slug' => 'lowboy-2005',
                 'name' => [
                     'es' => 'LOW BOY 2005',
                     'en' => 'LOW BOY 2005'
                 ],
                 'description' => [
                     'es' => 'Remolque LOW BOY 2005 para transporte de maquinaria pesada y equipo de construcción.',
                     'en' => 'LOW BOY 2005 trailer for heavy machinery and construction equipment transport.'
                 ],
                 'hero_image' => 'assets/img/gallery/services1.jpg',
                 'gallery' => [
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'El remolque LOW BOY 2005 con número de serie 1L9GA72A65L033420 es una solución especializada para el transporte de maquinaria pesada y equipo de construcción. Diseñado con una plataforma baja para facilitar la carga y descarga de equipos de gran tamaño.',
                         'features' => [
                             'Número de serie: 1L9GA72A65L033420',
                             'Capacidad de carga: 40-55 toneladas',
                             'Configuración de ejes: Tándem/Tri-axle',
                             'Suspensión neumática (Air Ride)',
                             'Cuello de ganso desmontable (RGN)',
                             'Frenos de aire con sistema ABS',
                             'Llantas 255/70R22.5 o 11R22.5'
                         ],
                         'applications' => [
                             'Transporte de maquinaria pesada',
                             'Equipo de construcción',
                             'Excavadoras y bulldozers',
                             'Grúas y equipos industriales',
                             'Maquinaria agrícola de gran tamaño'
                         ],
                         'technical_specs' => [
                             'Año: 2005',
                             'Número de serie: 1L9GA72A65L033420',
                             'Capacidad de carga: 40-55 toneladas',
                             'Longitud de plataforma: 24-29 pies',
                             'Altura de plataforma: 18-24 pulgadas',
                             'Longitud total: 48-53 pies',
                             'Ancho: 8.5 pies',
                             'Configuración: Tándem/Tri-axle',
                             'Suspensión: Neumática',
                             'Frenos: Aire con ABS'
                         ]
                     ],
                     'en' => [
                         'description' => 'The LOW BOY 2005 trailer with serial number 1L9GA72A65L033420 is a specialized solution for transporting heavy machinery and construction equipment. Designed with a low platform to facilitate loading and unloading of large equipment.',
                         'features' => [
                             'Serial number: 1L9GA72A65L033420',
                             'Load capacity: 40-55 tons',
                             'Axle configuration: Tandem/Tri-axle',
                             'Air ride suspension',
                             'Removable gooseneck (RGN)',
                             'Air brakes with ABS system',
                             '255/70R22.5 or 11R22.5 tires'
                         ],
                         'applications' => [
                             'Heavy machinery transport',
                             'Construction equipment',
                             'Excavators and bulldozers',
                             'Cranes and industrial equipment',
                             'Large agricultural machinery'
                         ],
                         'technical_specs' => [
                             'Year: 2005',
                             'Serial number: 1L9GA72A65L033420',
                             'Load capacity: 40-55 tons',
                             'Deck length: 24-29 feet',
                             'Deck height: 18-24 inches',
                             'Overall length: 48-53 feet',
                             'Width: 8.5 feet',
                             'Configuration: Tandem/Tri-axle',
                             'Suspension: Air ride',
                             'Brakes: Air with ABS'
                         ]
                     ]
                 ]
             ],
             'plataformas-aereas' => [
                 'slug' => 'plataformas-aereas',
                 'name' => [
                     'es' => 'Plataformas Aéreas',
                     'en' => 'Aerial Platforms'
                 ],
                 'description' => [
                     'es' => 'Plataformas de trabajo aéreas seguras y confiables para tareas en altura.',
                     'en' => 'Safe and reliable aerial work platforms for high-altitude tasks.'
                 ],
                 'hero_image' => 'assets/img/gallery/services4.jpg',
                 'gallery' => [
                     'assets/img/gallery/services4.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services1.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestras plataformas aéreas proporcionan acceso seguro a trabajos en altura, ideales para mantenimiento, instalación y construcción en espacios elevados.',
                         'features' => [
                             'Altura máxima de 45 metros',
                             'Carga de plataforma hasta 500kg',
                             'Tipos tijera y articulada disponibles',
                             'Controles de seguridad avanzados',
                             'Estabilización automática'
                         ],
                         'applications' => [
                             'Mantenimiento de edificios',
                             'Instalación de sistemas eléctricos',
                             'Trabajos de pintura en altura',
                             'Limpieza de fachadas'
                         ],
                         'technical_specs' => [
                             'Altura máxima: 45m',
                             'Carga de plataforma: 500kg',
                             'Alcance horizontal: 25m',
                             'Velocidad de elevación: 0.8 m/s',
                             'Tipo: Tijera/Articulada'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our aerial platforms provide safe access to high-altitude work, ideal for maintenance, installation, and construction in elevated spaces.',
                         'features' => [
                             'Maximum height of 45 meters',
                             'Platform load up to 500kg',
                             'Scissor and boom types available',
                             'Advanced safety controls',
                             'Automatic stabilization'
                         ],
                         'applications' => [
                             'Building maintenance',
                             'Electrical system installation',
                             'High-altitude painting work',
                             'Facade cleaning'
                         ],
                         'technical_specs' => [
                             'Maximum height: 45m',
                             'Platform load: 500kg',
                             'Horizontal reach: 25m',
                             'Lifting speed: 0.8 m/s',
                             'Type: Scissor/Boom'
                         ]
                     ]
                 ]
             ],
             'aerial-platforms' => [
                 'slug' => 'aerial-platforms',
                 'name' => [
                     'es' => 'Plataformas Aéreas',
                     'en' => 'Aerial Platforms'
                 ],
                 'description' => [
                     'es' => 'Plataformas de trabajo aéreas seguras y confiables para tareas en altura.',
                     'en' => 'Safe and reliable aerial work platforms for high-altitude tasks.'
                 ],
                 'hero_image' => 'assets/img/gallery/services4.jpg',
                 'gallery' => [
                     'assets/img/gallery/services4.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services1.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestras plataformas aéreas proporcionan acceso seguro a trabajos en altura, ideales para mantenimiento, instalación y construcción en espacios elevados.',
                         'features' => [
                             'Altura máxima de 45 metros',
                             'Carga de plataforma hasta 500kg',
                             'Tipos tijera y articulada disponibles',
                             'Controles de seguridad avanzados',
                             'Estabilización automática'
                         ],
                         'applications' => [
                             'Mantenimiento de edificios',
                             'Instalación de sistemas eléctricos',
                             'Trabajos de pintura en altura',
                             'Limpieza de fachadas'
                         ],
                         'technical_specs' => [
                             'Altura máxima: 45m',
                             'Carga de plataforma: 500kg',
                             'Alcance horizontal: 25m',
                             'Velocidad de elevación: 0.8 m/s',
                             'Tipo: Tijera/Articulada'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our aerial platforms provide safe access to high-altitude work, ideal for maintenance, installation, and construction in elevated spaces.',
                         'features' => [
                             'Maximum height of 45 meters',
                             'Platform load up to 500kg',
                             'Scissor and boom types available',
                             'Advanced safety controls',
                             'Automatic stabilization'
                         ],
                         'applications' => [
                             'Building maintenance',
                             'Electrical system installation',
                             'High-altitude painting work',
                             'Facade cleaning'
                         ],
                         'technical_specs' => [
                             'Maximum height: 45m',
                             'Platform load: 500kg',
                             'Horizontal reach: 25m',
                             'Lifting speed: 0.8 m/s',
                             'Type: Scissor/Boom'
                         ]
                     ]
                 ]
             ],
             'excavadoras' => [
                 'slug' => 'excavadoras',
                 'name' => [
                     'es' => 'Excavadora Caterpillar 330C',
                     'en' => 'Caterpillar 330C Excavator'
                 ],
                 'description' => [
                     'es' => 'Excavadora Caterpillar 330C 2004 con motor CAT C9 de 244 HP para trabajos de excavación y movimiento de tierra.',
                     'en' => 'Caterpillar 330C 2004 excavator with CAT C9 engine 244 HP for excavation and earthmoving work.'
                 ],
                 'hero_image' => 'assets/img/gallery/services5.jpg',
                 'gallery' => [
                     'assets/img/gallery/services5.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestra excavadora Caterpillar 330C modelo 2004 (Serie: CAT0330CCJAB00810) está diseñada para trabajos pesados de excavación, demolición y movimiento de tierra en proyectos de construcción e infraestructura.',
                         'features' => [
                             'Motor CAT C9 de 244 HP',
                             'Sistema hidráulico de 148 gal/min',
                             'Cabina con suspensión y aire acondicionado',
                             'Brazo de excavación de alta resistencia',
                             'Sistema de control electrónico avanzado'
                         ],
                         'applications' => [
                             'Excavación de cimientos',
                             'Movimiento de tierra',
                             'Demolición controlada',
                             'Construcción de carreteras',
                             'Proyectos de infraestructura'
                         ],
                         'technical_specs' => [
                             'Peso operativo: 35.1 toneladas (77,400 lb)',
                             'Capacidad de cucharón: 2.3 yd³',
                             'Profundidad de excavación: 7.24 metros',
                             'Alcance máximo: 10.68 metros',
                             'Capacidad de combustible: 163 galones'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Caterpillar 330C excavator model 2004 (Serial: CAT0330CCJAB00810) is designed for heavy excavation, demolition, and earthmoving work in construction and infrastructure projects.',
                         'features' => [
                             'CAT C9 engine 244 HP',
                             'Hydraulic system 148 gal/min',
                             'Suspended cab with air conditioning',
                             'High-strength excavation arm',
                             'Advanced electronic control system'
                         ],
                         'applications' => [
                             'Foundation excavation',
                             'Earthmoving',
                             'Controlled demolition',
                             'Road construction',
                             'Infrastructure projects'
                         ],
                         'technical_specs' => [
                             'Operating weight: 35.1 tons (77,400 lb)',
                             'Bucket capacity: 2.3 yd³',
                             'Excavation depth: 7.24 meters',
                             'Maximum reach: 10.68 meters',
                             'Fuel capacity: 163 gallons'
                         ]
                     ]
                 ]
             ],
             'excavators' => [
                 'slug' => 'excavators',
                 'name' => [
                     'es' => 'Excavadora Caterpillar 330C',
                     'en' => 'Caterpillar 330C Excavator'
                 ],
                 'description' => [
                     'es' => 'Excavadora Caterpillar 330C 2004 con motor CAT C9 de 244 HP para trabajos de excavación y movimiento de tierra.',
                     'en' => 'Caterpillar 330C 2004 excavator with CAT C9 engine 244 HP for excavation and earthmoving work.'
                 ],
                 'hero_image' => 'assets/img/gallery/services5.jpg',
                 'gallery' => [
                     'assets/img/gallery/services5.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Excavadora Caterpillar 330C modelo 2004 (Serie: CAT0330CCJAB00810) diseñada para trabajos pesados de excavación, demolición y movimiento de tierra en proyectos de construcción e infraestructura.',
                         'features' => [
                             'Motor CAT C9 de 244 HP',
                             'Peso operativo de 35.1 toneladas',
                             'Alcance máximo de 10.68 metros',
                             'Cabina con aire acondicionado',
                             'Sistema hidráulico de 148 gal/min'
                         ],
                         'applications' => [
                             'Excavación de cimientos',
                             'Demolición de estructuras',
                             'Movimiento de tierra',
                             'Construcción de carreteras'
                         ],
                         'technical_specs' => [
                             'Motor: CAT C9 - 244 HP',
                             'Peso operativo: 77,400 lb (35.1 ton)',
                             'Alcance máximo: 10.68 m',
                             'Profundidad de excavación: 7.24 m',
                             'Capacidad del cucharón: 2.3 yd³',
                             'Capacidad de combustible: 163 gal',
                             'Sistema hidráulico: 148 gal/min'
                         ]
                     ],
                     'en' => [
                         'description' => 'Caterpillar 330C excavator model 2004 (Serial: CAT0330CCJAB00810) designed for heavy excavation, demolition, and earthmoving work in construction and infrastructure projects.',
                         'features' => [
                             'CAT C9 engine 244 HP',
                             'Operating weight 35.1 tons',
                             'Maximum reach 10.68 meters',
                             'Air-conditioned cabin',
                             'Hydraulic system 148 gal/min'
                         ],
                         'applications' => [
                             'Foundation excavation',
                             'Structure demolition',
                             'Earthmoving',
                             'Road construction'
                         ],
                         'technical_specs' => [
                             'Engine: CAT C9 - 244 HP',
                             'Operating weight: 77,400 lb (35.1 ton)',
                             'Maximum reach: 10.68 m',
                             'Digging depth: 7.24 m',
                             'Bucket capacity: 2.3 yd³',
                             'Fuel capacity: 163 gal',
                             'Hydraulic system: 148 gal/min'
                         ]
                     ]
                 ]
             ],
             'equipos-especializados' => [
                 'slug' => 'equipos-especializados',
                 'name' => [
                     'es' => 'Retroexcavadora Caterpillar 416D',
                     'en' => 'Caterpillar 416D Backhoe Loader'
                 ],
                 'description' => [
                     'es' => 'Retroexcavadora Caterpillar 416D Serie CAT0416DVBFP16809 con motor diesel 3054C de 74 HP y peso operativo de 15,180 lbs.',
                     'en' => 'Caterpillar 416D Backhoe Loader Series CAT0416DVBFP16809 with 3054C diesel engine 74 HP and operating weight 15,180 lbs.'
                 ],
                 'hero_image' => 'assets/img/equipos/Retro-416.png',
                 'gallery' => [
                     'assets/img/equipos/Retro-416.png',
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services4.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Retroexcavadora Caterpillar 416D fabricada entre 2000-2006, Serie CAT0416DVBFP16809. Equipo versátil que combina cargador frontal y brazo excavador trasero para máxima productividad en proyectos de construcción.',
                         'features' => [
                             'Motor Caterpillar 3054C de 4.4L (268 cu·in)',
                             'Potencia: 74 HP (55 kW) a 2200 rpm',
                             'Transmisión Power Shuttle 4F/4R',
                             'Sistema hidráulico de centro cerrado',
                             'Cabina ROPS o estructura de protección',
                             'Dirección hidrostática'
                         ],
                         'applications' => [
                             'Excavación de zanjas y cimientos',
                             'Carga y descarga de materiales',
                             'Nivelación y preparación de terrenos',
                             'Trabajos de construcción urbana',
                             'Proyectos de infraestructura'
                         ],
                         'technical_specs' => [
                             'Peso operativo: 15,180 lbs (6,900 kg)',
                             'Profundidad máxima de excavación: 10 ft 7 in (3,219 mm)',
                             'Fuerza de excavación: 11,600 lbs (cilindro del cucharón)',
                             'Capacidad tanque combustible: 34 galones (128L)',
                             'Sistema hidráulico: 37 gpm a 3000 psi',
                             'Tracción: 2WD/4WD disponible'
                         ]
                     ],
                     'en' => [
                         'description' => 'Caterpillar 416D Backhoe Loader manufactured between 2000-2006, Series CAT0416DVBFP16809. Versatile equipment that combines front loader and rear excavator arm for maximum productivity in construction projects.',
                         'features' => [
                             'Caterpillar 3054C engine 4.4L (268 cu·in)',
                             'Power: 74 HP (55 kW) at 2200 rpm',
                             'Power Shuttle transmission 4F/4R',
                             'Closed center hydraulic system',
                             'ROPS cabin or protection structure',
                             'Hydrostatic steering'
                         ],
                         'applications' => [
                             'Trench and foundation excavation',
                             'Material loading and unloading',
                             'Land leveling and preparation',
                             'Urban construction work',
                             'Infrastructure projects'
                         ],
                         'technical_specs' => [
                             'Operating weight: 15,180 lbs (6,900 kg)',
                             'Maximum digging depth: 10 ft 7 in (3,219 mm)',
                             'Digging force: 11,600 lbs (bucket cylinder)',
                             'Fuel tank capacity: 34 gallons (128L)',
                             'Hydraulic system: 37 gpm at 3000 psi',
                             'Drive: 2WD/4WD available'
                         ]
                     ]
                 ]
             ],
             'specialized-equipment' => [
                 'slug' => 'specialized-equipment',
                 'name' => [
                     'es' => 'Equipos Especializados',
                     'en' => 'Specialized Equipment'
                 ],
                 'description' => [
                     'es' => 'Equipos especializados para aplicaciones específicas en construcción e industria.',
                     'en' => 'Specialized equipment for specific applications in construction and industry.'
                 ],
                 'hero_image' => 'assets/img/gallery/services1.jpg',
                 'gallery' => [
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services4.jpg',
                     'assets/img/gallery/services5.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Contamos con una amplia gama de equipos especializados diseñados para aplicaciones específicas en diversos sectores industriales y de construcción.',
                         'features' => [
                             'Equipos de última tecnología',
                             'Adaptables a necesidades específicas',
                             'Operadores especializados disponibles',
                             'Mantenimiento especializado',
                             'Soporte técnico 24/7'
                         ],
                         'applications' => [
                             'Proyectos industriales especiales',
                             'Instalaciones complejas',
                             'Trabajos de precisión',
                             'Aplicaciones personalizadas'
                         ],
                         'technical_specs' => [
                             'Variedad de especificaciones',
                             'Configuraciones personalizadas',
                             'Tecnología avanzada',
                             'Certificaciones internacionales',
                             'Soporte técnico especializado'
                         ]
                     ],
                     'en' => [
                         'description' => 'We have a wide range of specialized equipment designed for specific applications in various industrial and construction sectors.',
                         'features' => [
                             'Latest technology equipment',
                             'Adaptable to specific needs',
                             'Specialized operators available',
                             'Specialized maintenance',
                             '24/7 technical support'
                         ],
                         'applications' => [
                             'Special industrial projects',
                             'Complex installations',
                             'Precision work',
                             'Custom applications'
                         ],
                         'technical_specs' => [
                             'Variety of specifications',
                             'Custom configurations',
                             'Advanced technology',
                             'International certifications',
                             'Specialized technical support'
                         ]
                     ]
                 ]
             ],
            'motoconformadora-570a' => [
                'slug' => 'motoconformadora-570a',
                'name' => [
                    'es' => 'Motoconformadora John Deere 570A',
                    'en' => 'John Deere 570A Motor Grader'
                ],
                'description' => [
                    'es' => 'Motoconformadora John Deere 570A Serie 003311T para nivelación de terrenos y construcción de carreteras.',
                    'en' => 'John Deere 570A Motor Grader Series 003311T for land leveling and road construction.'
                ],
                'hero_image' => 'assets/img/equipos/motoconformadora.svg',
                'gallery' => [
                    'assets/img/equipos/motoconformadora.svg',
                    'assets/img/gallery/grader1.jpg',
                    'assets/img/gallery/grader2.jpg'
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
                ]
            ],
            'vibrocompactadora' => [
                'slug' => 'vibrocompactadora',
                'name' => [
                    'es' => 'Vibrocompactador Hugg & Hall SD 105F TF',
                    'en' => 'Hugg & Hall SD 105F TF Vibratory Compactor'
                ],
                'description' => [
                    'es' => 'Vibrocompactador Hugg & Hall modelo SD 105F TF Ingersoll Rand para compactación de suelos.',
                    'en' => 'Hugg & Hall SD 105F TF Ingersoll Rand vibratory compactor for soil compaction.'
                ],
                'hero_image' => 'assets/img/equipos/vibrocompactadora.svg',
                'gallery' => [
                    'assets/img/equipos/vibrocompactadora.svg',
                    'assets/img/gallery/roller1.jpg',
                    'assets/img/gallery/roller2.jpg'
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
                 ]
             ],
             'vibrocompactador-bross-spv730' => [
                 'slug' => 'vibrocompactador-bross-spv730',
                 'name' => [
                     'es' => 'Vibrocompactador Bross SPV-730',
                     'en' => 'Bross SPV-730 Vibratory Compactor'
                 ],
                 'description' => [
                     'es' => 'Vibrocompactador Bross SPV-730 para compactación eficiente de suelos y materiales granulares.',
                     'en' => 'Bross SPV-730 vibratory compactor for efficient soil and granular material compaction.'
                 ],
                 'hero_image' => 'assets/img/equipos/motoconformadora.svg',
                 'gallery' => [
                     'assets/img/equipos/motoconformadora.svg',
                     'assets/img/gallery/grader1.jpg',
                     'assets/img/gallery/grader2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'El Vibrocompactador Bross SPV-730 es una máquina robusta diseñada para la compactación eficiente de suelos, asfalto y materiales granulares en proyectos de construcción vial.',
                         'features' => [
                             'Motor diesel de alta potencia 80 HP',
                             'Sistema de vibración de doble amplitud',
                             'Tambor de acero reforzado de 70 pulgadas',
                             'Sistema hidráulico de control preciso',
                             'Cabina con sistema de amortiguación ROPS/FOPS'
                         ],
                         'applications' => [
                             'Compactación de suelos',
                             'Construcción de carreteras',
                             'Preparación de terrenos',
                             'Compactación de materiales granulares',
                             'Trabajos de pavimentación'
                         ],
                         'technical_specs' => [
                             'Modelo: SPV-730',
                             'Serie: SPV-730',
                             'Motor: Diesel 80 HP',
                             'Peso operativo: 13,500 lbs (6,123 kg)',
                             'Ancho del tambor: 70 in (1.78 m)',
                             'Diámetro del tambor: 51 in (1.30 m)',
                             'Velocidad máxima: 9 mph (14.5 km/h)',
                             'Capacidad de combustible: 45 gal (170 L)',
                             'Frecuencia de vibración: 28 Hz',
                             'Fuerza centrífuga: 40,000 lbs (18,144 kg)'
                         ]
                     ],
                     'en' => [
                         'description' => 'The Bross SPV-730 Vibratory Compactor is a robust machine designed for efficient compaction of soils, asphalt, and granular materials in road construction projects.',
                         'features' => [
                             'High-power 80 HP diesel engine',
                             'Double amplitude vibration system',
                             '70-inch reinforced steel drum',
                             'Precise hydraulic control system',
                             'ROPS/FOPS cabin with damping system'
                         ],
                         'applications' => [
                             'Soil compaction',
                             'Road construction',
                             'Ground preparation',
                             'Granular material compaction',
                             'Paving work'
                         ],
                         'technical_specs' => [
                             'Model: SPV-730',
                             'Series: SPV-730',
                             'Engine: 80 HP Diesel',
                             'Operating weight: 13,500 lbs (6,123 kg)',
                             'Drum width: 70 in (1.78 m)',
                             'Drum diameter: 51 in (1.30 m)',
                             'Maximum speed: 9 mph (14.5 km/h)',
                             'Fuel capacity: 45 gal (170 L)',
                             'Vibration frequency: 28 Hz',
                             'Centrifugal force: 40,000 lbs (18,144 kg)'
                         ]
                     ]
                 ]
             ],
             'motoconformadora-galion-t600c' => [
                 'slug' => 'motoconformadora-galion-t600c',
                 'name' => [
                     'es' => 'Motoconformadora Galion T600C',
                     'en' => 'Galion T600C Motor Grader'
                 ],
                 'description' => [
                     'es' => 'Motoconformadora Galion T600C Serie IC-03004 para nivelación, construcción de carreteras y mantenimiento vial.',
                     'en' => 'Galion T600C Motor Grader Series IC-03004 for grading, road construction and highway maintenance.'
                 ],
                 'hero_image' => 'assets/img/equipos/motoconformadora-galion.svg',
                 'gallery' => [
                     'assets/img/equipos/motoconformadora-galion.svg',
                     'assets/img/gallery/grader1.jpg',
                     'assets/img/gallery/grader2.jpg'
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
                 ]
             ],
             'camion-ford' => [
                 'slug' => 'camion-ford',
                 'name' => [
                     'es' => 'Camión Ford F-750',
                     'en' => 'Ford F-750 Truck'
                 ],
                 'description' => [
                     'es' => 'Camión Ford F-750 robusto para trabajos pesados y transporte comercial.',
                     'en' => 'Robust Ford F-750 truck for heavy-duty work and commercial transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/camion-cover.png',
                 'gallery' => [
                     'assets/img/equipos/camion.png',
                     'assets/img/gallery/dumptruck1.jpg',
                     'assets/img/gallery/dumptruck2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'El Ford F-750 es un camión comercial de trabajo pesado diseñado para aplicaciones exigentes con máxima confiabilidad y durabilidad.',
                         'features' => [
                             'Motor Power Stroke V8 6.7L turbodiésel',
                             'Transmisión automática TorqShift de 6 velocidades',
                             'Chasis reforzado para trabajo pesado',
                             'Cabina SuperCab con asientos cómodos',
                             'Sistema de frenos hidráulicos con ABS'
                         ],
                         'applications' => [
                             'Transporte de materiales de construcción',
                             'Servicios de entrega comercial',
                             'Trabajos municipales y de servicios',
                             'Aplicaciones de volteo y carga'
                         ],
                         'technical_specs' => [
                             'Motor: 6.7L Power Stroke V8 Turbodiésel',
                             'Potencia: 270 HP @ 2,600 rpm',
                             'Torque: 675 lb-ft @ 1,600 rpm',
                             'GVWR: hasta 26,000 lbs (11,793 kg)',
                             'Capacidad de remolque: hasta 22,000 lbs'
                         ]
                     ],
                     'en' => [
                         'description' => 'The Ford F-750 is a heavy-duty commercial truck designed for demanding applications with maximum reliability and durability.',
                         'features' => [
                             '6.7L Power Stroke V8 turbodiesel engine',
                             '6-speed TorqShift automatic transmission',
                             'Heavy-duty reinforced chassis',
                             'SuperCab cabin with comfortable seating',
                             'Hydraulic brake system with ABS'
                         ],
                         'applications' => [
                             'Construction material transport',
                             'Commercial delivery services',
                             'Municipal and utility work',
                             'Dump and loading applications'
                         ],
                         'technical_specs' => [
                             'Engine: 6.7L Power Stroke V8 Turbodiesel',
                             'Power: 270 HP @ 2,600 rpm',
                             'Torque: 675 lb-ft @ 1,600 rpm',
                             'GVWR: up to 26,000 lbs (11,793 kg)',
                             'Towing capacity: up to 22,000 lbs'
                         ]
                     ]
                 ]
                         ],
             'camion-volvo' => [
                 'slug' => 'camion-volvo',
                 'name' => [
                     'es' => 'Camión Volvo FH',
                     'en' => 'Volvo FH Truck'
                 ],
                 'description' => [
                     'es' => 'Camión Volvo FH de alta potencia para transporte pesado y construcción.',
                     'en' => 'High-power Volvo FH truck for heavy transport and construction.'
                 ],
                 'hero_image' => 'assets/img/equipos/camion-cover.png',
                 'gallery' => [
                     'assets/img/equipos/camion-cover.png',
                     'assets/img/gallery/services1.jpg',
                     'assets/img/gallery/services2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'El Camión Volvo FH representa la excelencia en transporte pesado, combinando potencia, eficiencia y tecnología avanzada para proyectos de construcción e infraestructura.',
                         'features' => [
                             'Motor D13K de 13 litros turboalimentado',
                             'Potencia de 460-540 HP',
                             'Transmisión I-Shift automatizada',
                             'Cabina con suspensión neumática',
                             'Tecnología de seguridad avanzada'
                         ],
                         'applications' => [
                             'Transporte de materiales de construcción',
                             'Proyectos de infraestructura',
                             'Transporte pesado de larga distancia',
                             'Operaciones en sitios de construcción'
                         ],
                         'technical_specs' => [
                             'Potencia: 460-540 HP',
                             'Capacidad de carga: hasta 40 toneladas',
                             'Motor: D13K de 13 litros',
                             'Transmisión: I-Shift automatizada',
                             'Suspensión: Neumática en cabina'
                         ]
                     ],
                     'en' => [
                         'description' => 'The Volvo FH Truck represents excellence in heavy transport, combining power, efficiency and advanced technology for construction and infrastructure projects.',
                         'features' => [
                             '13-liter turbocharged D13K engine',
                             'Power output 460-540 HP',
                             'I-Shift automated transmission',
                             'Air-suspended cabin',
                             'Advanced safety technology'
                         ],
                         'applications' => [
                             'Construction material transport',
                             'Infrastructure projects',
                             'Long-distance heavy transport',
                             'Construction site operations'
                         ],
                         'technical_specs' => [
                             'Power: 460-540 HP',
                             'Load capacity: up to 40 tons',
                             'Engine: 13-liter D13K',
                             'Transmission: I-Shift automated',
                             'Suspension: Air-suspended cabin'
                         ]
                     ]
                 ]
             ],
             'excavadora' => [
                 'slug' => 'excavadora',
                 'name' => [
                     'es' => 'Excavadora Caterpillar 330C',
                     'en' => 'Caterpillar 330C Excavator'
                 ],
                 'description' => [
                     'es' => 'Excavadora Caterpillar 330C 2004 con motor CAT C9 de 244 HP para trabajos de excavación y movimiento de tierra.',
                     'en' => 'Caterpillar 330C 2004 excavator with CAT C9 engine 244 HP for excavation and earthmoving work.'
                 ],
                 'hero_image' => 'assets/img/equipos/excavadora-cover.png',
                 'gallery' => [
                     'assets/img/equipos/excavadora.png',
                     'assets/img/gallery/dumptruck1.jpg',
                     'assets/img/gallery/dumptruck2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestra excavadora Caterpillar 330C modelo 2004 (Serie: CAT0330CCJAB00810) ofrece potencia y versatilidad excepcionales para proyectos de construcción e infraestructura de gran escala.',
                         'features' => [
                             'Motor CAT C9 de 244 HP',
                             'Sistema hidráulico de 148 gal/min',
                             'Cabina con suspensión y aire acondicionado',
                             'Brazo de excavación de alta resistencia',
                             'Sistema de control electrónico avanzado'
                         ],
                         'applications' => [
                             'Excavación de cimientos',
                             'Movimiento de tierra',
                             'Demolición controlada',
                             'Construcción de carreteras',
                             'Proyectos de infraestructura'
                         ],
                         'technical_specs' => [
                             'Peso operativo: 35.1 toneladas (77,400 lb)',
                             'Capacidad de cucharón: 2.3 yd³',
                             'Profundidad de excavación: 7.24 metros',
                             'Alcance máximo: 10.68 metros',
                             'Capacidad de combustible: 163 galones'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Caterpillar 330C excavator model 2004 (Serial: CAT0330CCJAB00810) offers exceptional power and versatility for large-scale construction and infrastructure projects.',
                         'features' => [
                             'CAT C9 engine 244 HP',
                             'Hydraulic system 148 gal/min',
                             'Suspended cab with air conditioning',
                             'High-strength excavation arm',
                             'Advanced electronic control system'
                         ],
                         'applications' => [
                             'Foundation excavation',
                             'Earthmoving',
                             'Controlled demolition',
                             'Road construction',
                             'Infrastructure projects'
                         ],
                         'technical_specs' => [
                             'Operating weight: 35.1 tons (77,400 lb)',
                             'Bucket capacity: 2.3 yd³',
                             'Excavation depth: 7.24 meters',
                             'Maximum reach: 10.68 meters',
                             'Fuel capacity: 163 gallons'
                         ]
                     ]
                 ]
             ],
             'motoconformadora-galion-118c' => [
                 'slug' => 'motoconformadora-galion-118c',
                 'name' => [
                     'es' => 'MOTOCONFORMADORA GALION MOD. 11809C',
                     'en' => 'GALION 11809C MOTOR GRADER'
                 ],
                 'description' => [
                     'es' => 'Motoconformadora Galion 11809C Serie 118C, máquina robusta y confiable para trabajos de nivelación, construcción de caminos y mantenimiento vial con motor Cummins.',
                     'en' => 'Galion 11809C Motor Grader Series 118C, robust and reliable machine for grading work, road construction and highway maintenance with Cummins engine.'
                 ],
                 'hero_image' => 'assets/img/equipos/motoconformadora-galion.svg',
                 'gallery' => [
                     'assets/img/equipos/motoconformadora-galion.svg',
                     'assets/img/gallery/galion1.jpg',
                     'assets/img/gallery/galion2.jpg'
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
                 ]
             ],
             'lowboy-rg35-t' => [
                 'slug' => 'lowboy-rg35-t',
                 'name' => [
                     'es' => 'LOW BOY RG35 T',
                     'en' => 'LOW BOY RG35 T'
                 ],
                 'description' => [
                     'es' => 'Remolque Low Boy RG35 T año 2000, capacidad 35 toneladas para transporte de maquinaria pesada y equipos de construcción.',
                     'en' => 'Low Boy RG35 T trailer year 2000, 35-ton capacity for heavy machinery and construction equipment transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/lowboy-rg35t-cover.png',
                 'gallery' => [
                     'assets/img/equipos/lowboy-rg35t.png',
                     'assets/img/gallery/lowboy1.jpg',
                     'assets/img/gallery/lowboy2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestro remolque Low Boy RG35 T modelo 2000 (Serie: 1W8A11D25Y5000540) es la solución ideal para el transporte seguro y eficiente de maquinaria pesada y equipos de construcción de gran tamaño.',
                         'features' => [
                             'Capacidad de carga de 35 toneladas (70,000 lbs)',
                             'Plataforma de carga baja para fácil acceso',
                             'Suspensión neumática para transporte suave',
                             'Sistema de frenos de aire con ABS',
                             'Configuración de ejes tándem o tri-eje',
                             'Rampas hidráulicas desmontables',
                             'Estructura reforzada de acero de alta resistencia'
                         ],
                         'applications' => [
                             'Transporte de excavadoras y bulldozers',
                             'Traslado de motoconformadoras',
                             'Transporte de equipos industriales',
                             'Movilización de maquinaria de construcción',
                             'Transporte de equipos especializados',
                             'Logística de proyectos de infraestructura'
                         ],
                         'technical_specs' => [
                             'Capacidad: 35 toneladas (70,000 lbs)',
                             'Longitud de plataforma: 22-24 pies (6.7-7.3 m)',
                             'Altura de plataforma: 20-24 pulgadas (0.5-0.6 m)',
                             'Longitud total: 44-46 pies (13.4-14.0 m)',
                             'Ancho: 8.5 pies (2.6 m)',
                             'Llantas: 255/70R22.5 o similar',
                             'Suspensión: Neumática',
                             'Frenos: Aire con sistema ABS',
                             'Año: 2000',
                             'Modelo: RG35 T',
                             'Serie: 1W8A11D25Y5000540'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Low Boy RG35 T trailer model 2000 (Serial: 1W8A11D25Y5000540) is the ideal solution for safe and efficient transport of heavy machinery and large construction equipment.',
                         'features' => [
                             '35-ton loading capacity (70,000 lbs)',
                             'Low-profile deck for easy access',
                             'Air ride suspension for smooth transport',
                             'Air brake system with ABS',
                             'Tandem or tri-axle configuration',
                             'Removable hydraulic ramps',
                             'Reinforced high-strength steel structure'
                         ],
                         'applications' => [
                             'Excavator and bulldozer transport',
                             'Motor grader hauling',
                             'Industrial equipment transport',
                             'Construction machinery mobilization',
                             'Specialized equipment transport',
                             'Infrastructure project logistics'
                         ],
                         'technical_specs' => [
                             'Capacity: 35 tons (70,000 lbs)',
                             'Deck length: 22-24 feet (6.7-7.3 m)',
                             'Deck height: 20-24 inches (0.5-0.6 m)',
                             'Overall length: 44-46 feet (13.4-14.0 m)',
                             'Width: 8.5 feet (2.6 m)',
                             'Tires: 255/70R22.5 or similar',
                             'Suspension: Air ride suspension',
                             'Brakes: Air brakes with ABS',
                             'Year: 2000',
                             'Model: RG35 T',
                             'Serial: 1W8A11D25Y5000540'
                         ]
                     ]
                 ]
             ],
             'lowboy-2002' => [
                 'slug' => 'lowboy-2002',
                 'name' => [
                     'es' => 'LOW BOY 2002',
                     'en' => 'LOW BOY 2002'
                 ],
                 'description' => [
                     'es' => 'Remolque Low Boy año 2002, capacidad 40-50 toneladas para transporte de maquinaria pesada y equipos de construcción de gran envergadura.',
                     'en' => 'Low Boy trailer year 2002, 40-50 ton capacity for heavy machinery and large-scale construction equipment transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/lowboy-2002-cover.png',
                 'gallery' => [
                     'assets/img/equipos/lowboy-2002.png',
                     'assets/img/gallery/lowboy3.jpg',
                     'assets/img/gallery/lowboy4.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestro remolque Low Boy del año 2002 (Serie: 13ND5340423514722) es una solución robusta y confiable para el transporte de maquinaria pesada. Su diseño de plataforma baja y alta capacidad de carga lo hacen ideal para transportar equipos de construcción y maquinaria industrial de gran tamaño.',
                         'features' => [
                             'Capacidad de carga de 40-50 toneladas (80,000-100,000 lbs)',
                             'Plataforma de carga baja de 18-24 pulgadas',
                             'Suspensión neumática para transporte suave',
                             'Sistema de frenos de aire con ABS',
                             'Configuración de ejes tándem o tri-eje',
                             'Llantas 255/70R22.5 o 11R22.5',
                             'Construcción de acero de alta resistencia',
                             'Longitud total de 48-53 pies'
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
                             'Capacidad: 40-50 toneladas (80,000-100,000 lbs)',
                             'Longitud de plataforma: 24-29 pies (7.3-8.8 m)',
                             'Altura de plataforma: 18-24 pulgadas (0.46-0.61 m)',
                             'Longitud total: 48-53 pies (14.6-16.2 m)',
                             'Ancho: 8.5 pies (2.6 m)',
                             'Llantas: 255/70R22.5 o 11R22.5',
                             'Suspensión: Neumática',
                             'Frenos: Aire con sistema ABS',
                             'Año: 2002',
                             'Serie: 13ND5340423514722',
                             'Peso del remolque: Aproximadamente 18,000-22,000 lbs',
                             'Material: Construcción de acero de alta resistencia'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Low Boy trailer from year 2002 (Serial: 13ND5340423514722) is a robust and reliable solution for heavy machinery transport. Its low platform design and high load capacity make it ideal for transporting large construction equipment and industrial machinery.',
                         'features' => [
                             '40-50 ton loading capacity (80,000-100,000 lbs)',
                             'Low-profile deck 18-24 inches height',
                             'Air ride suspension for smooth transport',
                             'Air brake system with ABS',
                             'Tandem or tri-axle configuration',
                             '255/70R22.5 or 11R22.5 tires',
                             'High-strength steel construction',
                             'Overall length 48-53 feet'
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
                             'Capacity: 40-50 tons (80,000-100,000 lbs)',
                             'Deck length: 24-29 feet (7.3-8.8 m)',
                             'Deck height: 18-24 inches (0.46-0.61 m)',
                             'Overall length: 48-53 feet (14.6-16.2 m)',
                             'Width: 8.5 feet (2.6 m)',
                             'Tires: 255/70R22.5 or 11R22.5',
                             'Suspension: Air ride suspension',
                             'Brakes: Air brakes with ABS',
                             'Year: 2002',
                             'Serial: 13ND5340423514722',
                             'Trailer weight: Approximately 18,000-22,000 lbs',
                             'Material: High-strength steel construction'
                         ]
                     ]
                 ]
             ],
             'lowboy-1996' => [
                 'slug' => 'lowboy-1996',
                 'name' => [
                     'es' => 'LOW BOY 1996',
                     'en' => 'LOW BOY 1996'
                 ],
                 'description' => [
                     'es' => 'Remolque Low Boy año 1996, Serie: 1LH17AUH2T1007759, capacidad 40-50 toneladas para transporte de maquinaria pesada y equipos de construcción.',
                     'en' => 'Low Boy trailer year 1996, Serial: 1LH17AUH2T1007759, 40-50 ton capacity for heavy machinery and construction equipment transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/lowboy-1996-cover.png',
                 'gallery' => [
                     'assets/img/equipos/lowboy-1996.png',
                     'assets/img/gallery/lowboy1.jpg',
                     'assets/img/gallery/lowboy2.jpg'
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
                 ]
             ],
             'plataforma-plana-1990' => [
                 'slug' => 'plataforma-plana-1990',
                 'name' => [
                     'es' => 'PLATAFORMA PLANA 1990',
                     'en' => 'FLATBED PLATFORM 1990'
                 ],
                 'description' => [
                     'es' => 'Plataforma plana año 1990, VIN: 1S12FF450MB332380, capacidad 48,000-80,000 lbs para transporte de carga general y materiales de construcción.',
                     'en' => 'Flatbed platform year 1990, VIN: 1S12FF450MB332380, capacity 48,000-80,000 lbs for general cargo and construction materials transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/plataforma-plana-1990-cover.png',
                 'gallery' => [
                     'assets/img/equipos/plataforma-plana-1990.png',
                     'assets/img/gallery/flatbed1.jpg',
                     'assets/img/gallery/flatbed2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestra plataforma plana del año 1990 (VIN: 1S12FF450MB332380) es una solución versátil y confiable para el transporte de carga general, materiales de construcción y maquinaria. Su diseño de plataforma abierta permite fácil carga y descarga desde cualquier ángulo.',
                         'features' => [
                             'VIN: 1S12FF450MB332380',
                             'Capacidad de carga: 48,000-80,000 lbs',
                             'Plataforma de acero antideslizante',
                             'Configuración de ejes tándem (2 ejes)',
                             'Suspensión de resortes de acero',
                             'Frenos neumáticos',
                             'Puntos de amarre múltiples para asegurar carga'
                         ],
                         'applications' => [
                             'Transporte de carga general',
                             'Materiales de construcción',
                             'Maquinaria y equipos',
                             'Contenedores',
                             'Productos siderúrgicos',
                             'Materiales de gran longitud',
                             'Equipos industriales'
                         ],
                         'technical_specs' => [
                             'Año: 1990',
                             'VIN: 1S12FF450MB332380',
                             'Longitud: 48-53 pies (14.6-16.2 m)',
                             'Ancho: 102 pulgadas (8.5 pies / 2.6 m)',
                             'Capacidad de carga: 48,000-80,000 lbs (21,772-36,287 kg)',
                             'Peso en vacío: 12,000-15,000 lbs (5,443-6,804 kg)',
                             'Altura de plataforma: 60 pulgadas (1.52 m)',
                             'Configuración de ejes: Tándem (2 ejes)',
                             'Suspensión: Resortes de acero',
                             'Neumáticos: 11R22.5',
                             'Frenos: Neumáticos',
                             'Material: Acero con superficie antideslizante'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our flatbed platform from year 1990 (VIN: 1S12FF450MB332380) is a versatile and reliable solution for general cargo transport, construction materials, and machinery. Its open platform design allows easy loading and unloading from any angle.',
                         'features' => [
                             'VIN: 1S12FF450MB332380',
                             'Load capacity: 48,000-80,000 lbs',
                             'Anti-slip steel platform',
                             'Tandem axle configuration (2 axles)',
                             'Steel spring suspension',
                             'Air brakes',
                             'Multiple tie-down points for cargo securing'
                         ],
                         'applications' => [
                             'General cargo transport',
                             'Construction materials',
                             'Machinery and equipment',
                             'Containers',
                             'Steel products',
                             'Long-length materials',
                             'Industrial equipment'
                         ],
                         'technical_specs' => [
                             'Year: 1990',
                             'VIN: 1S12FF450MB332380',
                             'Length: 48-53 ft (14.6-16.2 m)',
                             'Width: 102 in (8.5 ft / 2.6 m)',
                             'Load Capacity: 48,000-80,000 lbs (21,772-36,287 kg)',
                             'Empty Weight: 12,000-15,000 lbs (5,443-6,804 kg)',
                             'Deck Height: 60 in (1.52 m)',
                             'Axle Configuration: Tandem (2 axles)',
                             'Suspension: Steel springs',
                             'Tires: 11R22.5',
                             'Brakes: Air brakes',
                             'Material: Steel with anti-slip deck'
                         ]
                     ]
                 ]
             ],
             'plataforma-plana-1990-vin-19203134' => [
                 'slug' => 'plataforma-plana-1990-vin-19203134',
                 'name' => [
                     'es' => 'PLATAFORMA PLANA 1990 - VIN 19203134',
                     'en' => 'FLATBED PLATFORM 1990 - VIN 19203134'
                 ],
                 'description' => [
                     'es' => 'Plataforma plana año 1990, VIN: 19203134, capacidad 40,000-50,000 lbs para transporte de carga general y materiales de construcción.',
                     'en' => 'Flatbed platform year 1990, VIN: 19203134, capacity 40,000-50,000 lbs for general cargo and construction materials transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/plataforma-plana-1990-2-cover.png',
                 'gallery' => [
                     'assets/img/equipos/plataforma-plana-1990-2.png',
                     'assets/img/gallery/flatbed3.jpg',
                     'assets/img/gallery/flatbed4.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestra segunda plataforma plana del año 1990 (VIN: 19203134) es una solución confiable y versátil para el transporte de carga general, materiales de construcción y maquinaria ligera. Su diseño robusto permite una operación eficiente en diversas condiciones.',
                         'features' => [
                             'VIN: 19203134',
                             'Capacidad de carga: 40,000-50,000 lbs',
                             'Plataforma de acero resistente',
                             'Configuración de ejes tándem (2 ejes)',
                             'Suspensión mecánica de resortes',
                             'Sistema de frenos neumáticos',
                             'Múltiples puntos de amarre para carga'
                         ],
                         'applications' => [
                             'Transporte de carga general',
                             'Materiales de construcción ligeros',
                             'Maquinaria de tamaño medio',
                             'Equipos industriales',
                             'Productos manufacturados',
                             'Materiales de longitud estándar'
                         ],
                         'technical_specs' => [
                             'Año: 1990',
                             'VIN: 19203134',
                             'Longitud: 48 pies (14.6 m)',
                             'Ancho: 102 pulgadas (8.5 pies / 2.6 m)',
                             'Capacidad de carga: 40,000-50,000 lbs (18,144-22,680 kg)',
                             'Peso en vacío: 10,000-12,000 lbs (4,536-5,443 kg)',
                             'Altura de plataforma: 60 pulgadas (1.52 m)',
                             'Configuración de ejes: Tándem (2 ejes)',
                             'Suspensión: Mecánica de resortes',
                             'Neumáticos: 11R22.5',
                             'Frenos: Sistema neumático',
                             'Material: Acero estructural resistente'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our second flatbed platform from year 1990 (VIN: 19203134) is a reliable and versatile solution for general cargo transport, construction materials, and light machinery. Its robust design allows efficient operation in various conditions.',
                         'features' => [
                             'VIN: 19203134',
                             'Load capacity: 40,000-50,000 lbs',
                             'Durable steel platform',
                             'Tandem axle configuration (2 axles)',
                             'Mechanical spring suspension',
                             'Air brake system',
                             'Multiple tie-down points for cargo'
                         ],
                         'applications' => [
                             'General cargo transport',
                             'Light construction materials',
                             'Medium-sized machinery',
                             'Industrial equipment',
                             'Manufactured products',
                             'Standard length materials'
                         ],
                         'technical_specs' => [
                             'Year: 1990',
                             'VIN: 19203134',
                             'Length: 48 ft (14.6 m)',
                             'Width: 102 in (8.5 ft / 2.6 m)',
                             'Load Capacity: 40,000-50,000 lbs (18,144-22,680 kg)',
                             'Empty Weight: 10,000-12,000 lbs (4,536-5,443 kg)',
                             'Deck Height: 60 in (1.52 m)',
                             'Axle Configuration: Tandem (2 axles)',
                             'Suspension: Mechanical springs',
                             'Tires: 11R22.5',
                             'Brakes: Air brake system',
                             'Material: Structural steel'
                         ]
                     ]
                 ]
             ],
             'cama-baja-2014-vin-2m512146471114308' => [
                 'slug' => 'cama-baja-2014-vin-2m512146471114308',
                 'name' => [
                     'es' => 'CAMA BAJA O PLANA AÑO 2014, VIN: 2M512146471114308',
                     'en' => 'LOWBOY OR FLATBED YEAR 2014, VIN: 2M512146471114308'
                 ],
                 'description' => [
                     'es' => 'Remolque cama baja o plana año 2014, VIN: 2M512146471114308, capacidad 40-55 toneladas para transporte de maquinaria pesada y equipos de construcción de gran envergadura.',
                     'en' => 'Lowboy or flatbed trailer year 2014, VIN: 2M512146471114308, capacity 40-55 tons for heavy machinery and large-scale construction equipment transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/cama-baja-2014-cover.png',
                 'gallery' => [
                     'assets/img/equipos/cama-baja-2014.png',
                     'assets/img/gallery/lowboy-2014-1.jpg',
                     'assets/img/gallery/lowboy-2014-2.jpg',
                     'assets/img/gallery/lowboy-2014-3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestro remolque cama baja o plana del año 2014 (VIN: 2M512146471114308) representa la última tecnología en transporte de maquinaria pesada. Su diseño moderno y construcción robusta lo hacen ideal para el transporte seguro y eficiente de equipos de construcción, maquinaria industrial y cargas especializadas de gran tamaño.',
                         'features' => [
                             'VIN: 2M512146471114308',
                             'Capacidad de carga: 40-55 toneladas (80,000-110,000 lbs)',
                             'Plataforma de carga baja de 18-24 pulgadas',
                             'Longitud de plataforma: 48-53 pies',
                             'Ancho estándar: 102 pulgadas (8.5 pies)',
                             'Configuración de ejes: 3 ejes tándem',
                             'Suspensión neumática con sistema de elevación',
                             'Sistema de frenos de aire con ABS',
                             'Cuello desmontable hidráulico',
                             'Plataforma de madera tratada',
                             'Rampas frontales plegables',
                             'Neumáticos 275/70R22.5',
                             'Construcción de acero de alta resistencia'
                         ],
                         'applications' => [
                             'Transporte de excavadoras grandes (30-50 toneladas)',
                             'Transporte de bulldozers y motoconformadoras',
                             'Transporte de grúas móviles',
                             'Transporte de equipos industriales pesados',
                             'Transporte de generadores industriales',
                             'Transporte de equipos de minería',
                             'Transporte de maquinaria especializada',
                             'Transporte de equipos agrícolas pesados',
                             'Transporte de transformadores eléctricos',
                             'Transporte de estructuras prefabricadas'
                         ],
                         'technical_specs' => [
                             'Año: 2014',
                             'VIN: 2M512146471114308',
                             'Tipo: Cama baja/Plana (Lowboy/Flatbed)',
                             'Capacidad de carga: 40-55 toneladas (80,000-110,000 lbs)',
                             'Longitud de plataforma: 48-53 pies (14.6-16.2 m)',
                             'Altura de plataforma: 18-24 pulgadas (0.46-0.61 m)',
                             'Longitud total: 53-58 pies (16.2-17.7 m)',
                             'Ancho: 102 pulgadas (8.5 pies / 2.6 m)',
                             'Configuración de ejes: 3 ejes tándem',
                             'Suspensión: Neumática con sistema de elevación',
                             'Frenos: Aire con sistema ABS',
                             'Neumáticos: 275/70R22.5',
                             'Peso del remolque: Aproximadamente 20,000-25,000 lbs',
                             'Material: Construcción de acero de alta resistencia',
                             'Cuello: Desmontable hidráulico',
                             'Plataforma: Madera tratada antideslizante',
                             'Rampas: Frontales plegables hidráulicas'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our lowboy or flatbed trailer from year 2014 (VIN: 2M512146471114308) represents the latest technology in heavy machinery transport. Its modern design and robust construction make it ideal for safe and efficient transport of construction equipment, industrial machinery, and large specialized loads.',
                         'features' => [
                             'VIN: 2M512146471114308',
                             'Load capacity: 40-55 tons (80,000-110,000 lbs)',
                             'Low-profile deck 18-24 inches height',
                             'Deck length: 48-53 feet',
                             'Standard width: 102 inches (8.5 feet)',
                             'Axle configuration: 3-axle tandem',
                             'Air suspension with lifting system',
                             'Air brake system with ABS',
                             'Hydraulic detachable gooseneck',
                             'Treated wood platform',
                             'Folding front ramps',
                             '275/70R22.5 tires',
                             'High-strength steel construction'
                         ],
                         'applications' => [
                             'Large excavator transport (30-50 tons)',
                             'Bulldozer and motor grader transport',
                             'Mobile crane transport',
                             'Heavy industrial equipment transport',
                             'Industrial generator transport',
                             'Mining equipment transport',
                             'Specialized machinery transport',
                             'Heavy agricultural equipment transport',
                             'Electrical transformer transport',
                             'Prefabricated structure transport'
                         ],
                         'technical_specs' => [
                             'Year: 2014',
                             'VIN: 2M512146471114308',
                             'Type: Lowboy/Flatbed',
                             'Load capacity: 40-55 tons (80,000-110,000 lbs)',
                             'Deck length: 48-53 ft (14.6-16.2 m)',
                             'Deck height: 18-24 in (0.46-0.61 m)',
                             'Overall length: 53-58 ft (16.2-17.7 m)',
                             'Width: 102 in (8.5 ft / 2.6 m)',
                             'Axle configuration: 3-axle tandem',
                             'Suspension: Air suspension with lifting system',
                             'Brakes: Air brakes with ABS',
                             'Tires: 275/70R22.5',
                             'Trailer weight: Approximately 20,000-25,000 lbs',
                             'Material: High-strength steel construction',
                             'Gooseneck: Hydraulic detachable',
                             'Platform: Treated anti-slip wood',
                             'Ramps: Hydraulic folding front ramps'
                         ]
                     ]
                 ]
             ],
             'plataforma-plana-2002-vin-1a9cj1a142m362081' => [
                 'slug' => 'plataforma-plana-2002-vin-1a9cj1a142m362081',
                 'name' => [
                     'es' => 'PLATAFORMA PLANA AÑO 2002, VIN: 1A9CJ1A142M362081',
                     'en' => '2002 FLATBED TRAILER, VIN: 1A9CJ1A142M362081'
                 ],
                 'description' => [
                     'es' => 'Plataforma plana año 2002, VIN: 1A9CJ1A142M362081, capacidad 48,000 lbs (80,000 lbs distribuidos) para transporte de carga general y materiales de construcción.',
                     'en' => 'Flatbed trailer year 2002, VIN: 1A9CJ1A142M362081, capacity 48,000 lbs (80,000 lbs distributed) for general cargo and construction materials transport.'
                 ],
                 'hero_image' => 'assets/img/equipos/plataforma-plana-2002-cover.png',
                 'gallery' => [
                     'assets/img/equipos/plataforma-plana-2002.png',
                     'assets/img/gallery/flatbed-2002-1.jpg',
                     'assets/img/gallery/flatbed-2002-2.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestra plataforma plana del año 2002 (VIN: 1A9CJ1A142M362081) es una solución confiable y versátil para el transporte de carga general, materiales de construcción y maquinaria. Su diseño robusto de plataforma abierta permite fácil carga y descarga desde cualquier ángulo, siendo ideal para proyectos de construcción e infraestructura.',
                         'features' => [
                             'VIN: 1A9CJ1A142M362081',
                             'Capacidad de carga: 48,000 lbs (80,000 lbs distribuidos)',
                             'Dimensiones: 48 pies de largo x 102 pulgadas de ancho',
                             'Altura de plataforma: 60 pulgadas desde el suelo',
                             'Configuración de ejes: 2 ejes tándem',
                             'Sistema de frenos: Frenos de aire',
                             'Suspensión: Suspensión mecánica de resortes',
                             'Plataforma: Cubierta de madera tratada',
                             'Sistema de amarres con anillos en D',
                             'Neumáticos: 11R22.5',
                             'Chasis de acero al carbono'
                         ],
                         'applications' => [
                             'Transporte de carga general',
                             'Materiales de construcción',
                             'Maquinaria y equipos industriales',
                             'Contenedores y productos manufacturados',
                             'Materiales de gran longitud',
                             'Equipos de construcción ligeros',
                             'Productos siderúrgicos'
                         ],
                         'technical_specs' => [
                             'Año: 2002',
                             'VIN: 1A9CJ1A142M362081',
                             'Tipo: Plataforma Plana (Flatbed)',
                             'Capacidad de carga: 48,000 lbs (21,772 kg)',
                             'Capacidad distribuida: 80,000 lbs (36,287 kg)',
                             'Longitud: 48 pies (14.6 m)',
                             'Ancho: 102 pulgadas (8.5 pies / 2.6 m)',
                             'Altura de plataforma: 60 pulgadas (1.52 m)',
                             'Peso en vacío: Aproximadamente 12,000 lbs (5,443 kg)',
                             'Configuración de ejes: 2 ejes tándem',
                             'Suspensión: Mecánica de resortes',
                             'Frenos: Sistema de frenos de aire',
                             'Neumáticos: 11R22.5',
                             'Plataforma: Cubierta de madera tratada',
                             'Amarres: Sistema de anillos en D',
                             'Chasis: Acero al carbono'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our flatbed trailer from year 2002 (VIN: 1A9CJ1A142M362081) is a reliable and versatile solution for general cargo transport, construction materials, and machinery. Its robust open platform design allows easy loading and unloading from any angle, making it ideal for construction and infrastructure projects.',
                         'features' => [
                             'VIN: 1A9CJ1A142M362081',
                             'Load capacity: 48,000 lbs (80,000 lbs distributed)',
                             'Dimensions: 48 ft length x 102 in width',
                             'Platform height: 60 inches from ground',
                             'Axle configuration: 2-axle tandem',
                             'Brake system: Air brakes',
                             'Suspension: Mechanical spring suspension',
                             'Platform: Treated wood deck',
                             'D-ring tie-down system',
                             'Tires: 11R22.5',
                             'Carbon steel chassis'
                         ],
                         'applications' => [
                             'General cargo transport',
                             'Construction materials',
                             'Machinery and industrial equipment',
                             'Containers and manufactured products',
                             'Long-length materials',
                             'Light construction equipment',
                             'Steel products'
                         ],
                         'technical_specs' => [
                             'Year: 2002',
                             'VIN: 1A9CJ1A142M362081',
                             'Type: Flatbed Trailer',
                             'Load capacity: 48,000 lbs (21,772 kg)',
                             'Distributed capacity: 80,000 lbs (36,287 kg)',
                             'Length: 48 ft (14.6 m)',
                             'Width: 102 in (8.5 ft / 2.6 m)',
                             'Platform height: 60 in (1.52 m)',
                             'Empty weight: Approximately 12,000 lbs (5,443 kg)',
                             'Axle configuration: 2-axle tandem',
                             'Suspension: Mechanical spring suspension',
                             'Brakes: Air brake system',
                             'Tires: 11R22.5',
                             'Platform: Treated wood deck',
                             'Tie-downs: D-ring system',
                             'Chassis: Carbon steel'
                         ]
                     ]
                 ]
             ],
             'camion-volteo-ford-1996-vin-1fdyl90e2tva30436' => [
                 'slug' => 'camion-volteo-ford-1996-vin-1fdyl90e2tva30436',
                 'name' => [
                     'es' => 'Camión Volteo Ford 7m³ 1996',
                     'en' => 'Ford 7m³ Dump Truck 1996'
                 ],
                 'description' => [
                     'es' => 'Camión volteo Ford F-350 año 1996, VIN: 1FDYL90E2TVA30436, capacidad 7 metros cúbicos, motor 7.5L V8, transmisión manual 5 velocidades.',
                     'en' => 'Ford F-350 dump truck year 1996, VIN: 1FDYL90E2TVA30436, 7 cubic meters capacity, 7.5L V8 engine, 5-speed manual transmission.'
                 ],
                 'hero_image' => 'assets/img/equipos/camion-volteo-ford-1996-cover.png',
                 'gallery' => [
                     'assets/img/equipos/camion-volteo-ford-1996.png',
                     'assets/img/gallery/ford-dump-1996-1.jpg',
                     'assets/img/gallery/ford-dump-1996-2.jpg',
                     'assets/img/gallery/ford-dump-1996-3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestro camión volteo Ford F-350 del año 1996 (VIN: 1FDYL90E2TVA30436) es una solución confiable y robusta para el transporte y descarga de materiales de construcción. Con su motor 7.5L V8 y transmisión manual de 5 velocidades, ofrece la potencia y control necesarios para trabajos exigentes en obras de construcción e infraestructura.',
                         'features' => [
                             'VIN: 1FDYL90E2TVA30436',
                             'Motor 7.5L V8 (460 cu in, 245 HP @ 4,000 rpm)',
                             'Transmisión manual de 5 velocidades',
                             'Capacidad de carga: 7 metros cúbicos',
                             'Peso bruto vehicular: 11,000 lbs (4,990 kg)',
                             'Configuración de ejes: 4x2 (dos ejes)',
                             'Sistema hidráulico PTO con bomba hidráulica',
                             'Frenos de disco delanteros con ABS',
                             'Suspensión de ballestas delanteras y traseras',
                             'Dirección asistida hidráulicamente',
                             'Tanque de gasolina de 19 galones',
                             'Llantas 235/85R16'
                         ],
                         'applications' => [
                             'Transporte de arena y grava',
                             'Transporte de materiales de construcción',
                             'Trabajos de excavación y movimiento de tierra',
                             'Proyectos de pavimentación',
                             'Construcción de carreteras',
                             'Obras de infraestructura urbana',
                             'Proyectos residenciales y comerciales',
                             'Limpieza y mantenimiento de sitios'
                         ],
                         'technical_specs' => [
                             'Año: 1996',
                             'VIN: 1FDYL90E2TVA30436',
                             'Marca: Ford',
                             'Modelo: F-350 (Novena Generación)',
                             'Tipo: Camión de Volteo',
                             'Motor: 7.5L V8 (460 cu in, 245 HP @ 4,000 rpm)',
                             'Torque: 400 lb-ft @ 2,200 rpm',
                             'Transmisión: Manual de 5 velocidades',
                             'Capacidad de carga: 7 metros cúbicos',
                             'Peso bruto vehicular: 11,000 lbs (4,990 kg)',
                             'Peso vacío: aproximadamente 7,500 lbs (3,402 kg)',
                             'Configuración de ejes: 4x2 (dos ejes)',
                             'Sistema hidráulico: PTO con bomba hidráulica',
                             'Frenos: Frenos de disco delanteros con ABS',
                             'Suspensión: Ballestas delanteras y traseras',
                             'Llantas: 235/85R16',
                             'Dirección: Dirección asistida hidráulicamente',
                             'Combustible: Tanque de gasolina de 19 galones',
                             'Dimensiones: Largo 6.7m x Ancho 2.4m x Alto 3.0m'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Ford F-350 dump truck from year 1996 (VIN: 1FDYL90E2TVA30436) is a reliable and robust solution for transporting and unloading construction materials. With its 7.5L V8 engine and 5-speed manual transmission, it offers the power and control needed for demanding work in construction and infrastructure projects.',
                         'features' => [
                             'VIN: 1FDYL90E2TVA30436',
                             '7.5L V8 engine (460 cu in, 245 HP @ 4,000 rpm)',
                             '5-speed manual transmission',
                             'Load capacity: 7 cubic meters',
                             'GVWR: 11,000 lbs (4,990 kg)',
                             'Axle configuration: 4x2 (two axles)',
                             'PTO hydraulic system with hydraulic pump',
                             'Front disc brakes with ABS',
                             'Leaf springs front and rear suspension',
                             'Hydraulically assisted power steering',
                             '19-gallon gasoline tank',
                             '235/85R16 tires'
                         ],
                         'applications' => [
                             'Sand and gravel transport',
                             'Construction materials transport',
                             'Excavation and earthmoving work',
                             'Paving projects',
                             'Road construction',
                             'Urban infrastructure works',
                             'Residential and commercial projects',
                             'Site cleanup and maintenance'
                         ],
                         'technical_specs' => [
                             'Year: 1996',
                             'VIN: 1FDYL90E2TVA30436',
                             'Brand: Ford',
                             'Model: F-350 (Ninth Generation)',
                             'Type: Dump Truck',
                             'Engine: 7.5L V8 (460 cu in, 245 HP @ 4,000 rpm)',
                             'Torque: 400 lb-ft @ 2,200 rpm',
                             'Transmission: 5-speed manual',
                             'Load Capacity: 7 cubic meters',
                             'GVWR: 11,000 lbs (4,990 kg)',
                             'Empty Weight: approximately 7,500 lbs (3,402 kg)',
                             'Axle Configuration: 4x2 (two axles)',
                             'Hydraulic System: PTO with hydraulic pump',
                             'Brakes: Front disc brakes with ABS',
                             'Suspension: Leaf springs front and rear',
                             'Tires: 235/85R16',
                             'Steering: Hydraulically assisted power steering',
                             'Fuel: 19-gallon gasoline tank',
                             'Dimensions: Length 6.7m x Width 2.4m x Height 3.0m'
                         ]
                     ]
                 ]
             ],
             'camion-volteo-ford-1997-serie-y559537nm559537' => [
                 'slug' => 'camion-volteo-ford-1997-serie-y559537nm559537',
                 'name' => [
                     'es' => 'Camión Volteo Ford F700 1997 - 7m³',
                     'en' => 'Ford F700 1997 Dump Truck - 7m³'
                 ],
                 'description' => [
                     'es' => 'Camión volteo Ford F700 año 1997, Serie: Y559537NM559537, capacidad 7 metros cúbicos, motor 7.0L V8 (429), transmisión manual 5 velocidades.',
                     'en' => 'Ford F700 dump truck year 1997, Series: Y559537NM559537, 7 cubic meters capacity, 7.0L V8 (429) engine, 5-speed manual transmission.'
                 ],
                 'hero_image' => 'assets/img/equipos/camion-volteo-ford-1997-cover.png',
                 'gallery' => [
                     'assets/img/equipos/camion-volteo-ford-1997.png',
                     'assets/img/gallery/ford-dump-1997-1.jpg',
                     'assets/img/gallery/ford-dump-1997-2.jpg',
                     'assets/img/gallery/ford-dump-1997-3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestro camión volteo Ford F700 del año 1997 (Serie: Y559537NM559537) es una solución confiable y robusta para el transporte y descarga de materiales de construcción. Con su motor 7.0L V8 (429) y transmisión manual de 5 velocidades con diferencial de 2 velocidades, ofrece la potencia y control necesarios para trabajos exigentes en obras de construcción e infraestructura.',
                         'features' => [
                             'Serie: Y559537NM559537',
                             'Motor Ford 7.0L V8 (429 cu in, 236 HP @ 3,600 rpm)',
                             'Transmisión manual de 5 velocidades + 2 velocidades diferencial',
                             'Capacidad de carga: 7 metros cúbicos',
                             'Peso bruto vehicular: 26,000 lbs (11,793 kg)',
                             'Configuración de ejes: 4x2 (sencillo)',
                             'Sistema hidráulico PTO para volcado',
                             'Frenos hidráulicos (Lucas Girling)',
                             'Suspensión de ballestas delanteras y traseras',
                             'Dirección hidráulica asistida',
                             'Tanque de gasolina de 60 galones (227 litros)',
                             'Llantas 10R22.5',
                             'Distancia entre ejes: 153 pulgadas'
                         ],
                         'applications' => [
                             'Transporte de arena y grava',
                             'Transporte de materiales de construcción',
                             'Trabajos de excavación y movimiento de tierra',
                             'Proyectos de pavimentación',
                             'Construcción de carreteras',
                             'Obras de infraestructura urbana',
                             'Proyectos residenciales y comerciales',
                             'Limpieza y mantenimiento de sitios'
                         ],
                         'technical_specs' => [
                             'Año: 1997',
                             'Serie: Y559537NM559537',
                             'Marca: Ford',
                             'Modelo: F700',
                             'Tipo: Camión de Volteo Rabón',
                             'Motor: Ford 7.0L V8 (429 cu in, 236 HP @ 3,600 rpm)',
                             'Torque: 358 lb-ft @ 2,800 rpm',
                             'Relación de compresión: 8.0:1',
                             'Transmisión: Manual 5 velocidades + 2 velocidades diferencial',
                             'Capacidad de carga: 7 metros cúbicos',
                             'Peso bruto vehicular: 26,000 lbs (11,793 kg)',
                             'Eje delantero: 9,000 lbs',
                             'Eje trasero: 17,000 lbs',
                             'Configuración de ejes: 4x2 (sencillo)',
                             'Sistema hidráulico: PTO para volcado',
                             'Frenos: Hidráulicos (Lucas Girling)',
                             'Suspensión: Ballestas delanteras y traseras',
                             'Llantas: 10R22.5',
                             'Dirección: Hidráulica asistida',
                             'Combustible: Tanque de gasolina 60 galones (227 litros)',
                             'Capacidad de aceite: 8 cuartos (7.6 litros)',
                             'Distancia entre ejes: 153 pulgadas',
                             'Voltaje: 12V'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our Ford F700 dump truck from year 1997 (Series: Y559537NM559537) is a reliable and robust solution for transporting and unloading construction materials. With its 7.0L V8 (429) engine and 5-speed manual transmission with 2-speed differential, it offers the power and control needed for demanding work in construction and infrastructure projects.',
                         'features' => [
                             'Series: Y559537NM559537',
                             'Ford 7.0L V8 engine (429 cu in, 236 HP @ 3,600 rpm)',
                             '5-speed manual transmission + 2-speed differential',
                             'Load capacity: 7 cubic meters',
                             'GVWR: 26,000 lbs (11,793 kg)',
                             'Axle configuration: 4x2 (single)',
                             'PTO hydraulic system for dumping',
                             'Hydraulic brakes (Lucas Girling)',
                             'Leaf springs front and rear suspension',
                             'Power-assisted hydraulic steering',
                             '60-gallon gasoline tank (227 liters)',
                             '10R22.5 tires',
                             'Wheelbase: 153 inches'
                         ],
                         'applications' => [
                             'Sand and gravel transport',
                             'Construction materials transport',
                             'Excavation and earthmoving work',
                             'Paving projects',
                             'Road construction',
                             'Urban infrastructure works',
                             'Residential and commercial projects',
                             'Site cleanup and maintenance'
                         ],
                         'technical_specs' => [
                             'Year: 1997',
                             'Series: Y559537NM559537',
                             'Brand: Ford',
                             'Model: F700',
                             'Type: Rabón Dump Truck',
                             'Engine: Ford 7.0L V8 (429 cu in, 236 HP @ 3,600 rpm)',
                             'Torque: 358 lb-ft @ 2,800 rpm',
                             'Compression Ratio: 8.0:1',
                             'Transmission: 5-speed manual + 2-speed differential',
                             'Load Capacity: 7 cubic meters',
                             'GVWR: 26,000 lbs (11,793 kg)',
                             'Front Axle: 9,000 lbs',
                             'Rear Axle: 17,000 lbs',
                             'Axle Configuration: 4x2 (single)',
                             'Hydraulic System: PTO for dumping',
                             'Brakes: Hydraulic (Lucas Girling)',
                             'Suspension: Front and rear leaf springs',
                             'Tires: 10R22.5',
                             'Steering: Power-assisted hydraulic',
                             'Fuel: 60-gallon gasoline tank (227 liters)',
                             'Oil Capacity: 8 quarts (7.6 liters)',
                             'Wheelbase: 153 inches',
                             'Voltage: 12V'
                         ]
                     ]
                 ]
             ],
             'camion-volteo-volvo-2013-vin-4v4m19gg96n407479' => [
                 'slug' => 'camion-volteo-volvo-2013-vin-4v4m19gg96n407479',
                 'name' => [
                     'es' => 'Camión de Volteo Volvo VHD 2013 - 7m³',
                     'en' => 'Volvo VHD 2013 Dump Truck - 7m³'
                 ],
                 'description' => [
                     'es' => 'Camión de volteo Volvo VHD 2013 con capacidad de 7 metros cúbicos, ideal para transporte de materiales de construcción y movimiento de tierras.',
                     'en' => 'Volvo VHD 2013 dump truck with 7 cubic meter capacity, ideal for construction material transport and earthmoving operations.'
                 ],
                 'hero_image' => '/images/equipos/camion-volteo-volvo-2013.jpg',
                 'gallery' => [
                     '/images/equipos/camion-volteo-volvo-2013-1.jpg',
                     '/images/equipos/camion-volteo-volvo-2013-2.jpg',
                     '/images/equipos/camion-volteo-volvo-2013-3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'El Camión de Volteo Volvo VHD 2013 es un vehículo robusto y confiable diseñado para aplicaciones de construcción pesada. Con su motor Volvo D13 y transmisión I-Shift automática, ofrece un rendimiento excepcional y eficiencia operativa. Su capacidad de 7 metros cúbicos lo convierte en la opción ideal para proyectos de mediana escala.',
                         'features' => [
                             'Motor Volvo D13 de 425 HP con tecnología avanzada',
                             'Transmisión automática I-Shift de 12 velocidades',
                             'Sistema hidráulico PTO para volcado eficiente',
                             'Configuración de ejes 6x4 para máxima tracción',
                             'Frenos de aire con sistema ABS para seguridad',
                             'Cabina ergonómica con controles intuitivos',
                             'Sistema de suspensión con ballestas reforzadas',
                             'Dirección hidráulica asistida para maniobrabilidad'
                         ],
                         'applications' => [
                             'Transporte de materiales de construcción',
                             'Movimiento de tierras y excavaciones',
                             'Obras de infraestructura vial',
                             'Proyectos de urbanización',
                             'Transporte de agregados y arena',
                             'Limpieza y mantenimiento urbano'
                         ],
                         'technical_specs' => [
                             'Motor: Volvo D13 - 425 HP (317 kW) @ 1,800 rpm',
                             'Torque: 1,650 lb-ft (2,237 Nm) @ 1,000 rpm',
                             'Transmisión: I-Shift automática de 12 velocidades',
                             'Capacidad de carga: 7 metros cúbicos',
                             'GVWR: 26,000 kg (57,320 lbs)',
                             'Configuración de ejes: 6x4',
                             'Sistema hidráulico: PTO para volcado',
                             'Frenos: Aire con ABS',
                             'Suspensión: Ballestas delanteras y traseras',
                             'Llantas: 11R22.5',
                             'Tanque de combustible: 300 litros',
                             'Dirección: Hidráulica asistida',
                             'Voltaje: 24V',
                             'Alternador: 150 amperios',
                             'VIN: 4V4M19GG96N407479'
                         ]
                     ],
                     'en' => [
                         'description' => 'The Volvo VHD 2013 Dump Truck is a robust and reliable vehicle designed for heavy construction applications. With its Volvo D13 engine and I-Shift automatic transmission, it offers exceptional performance and operational efficiency. Its 7 cubic meter capacity makes it the ideal choice for medium-scale projects.',
                         'features' => [
                             'Volvo D13 425 HP engine with advanced technology',
                             'I-Shift 12-speed automatic transmission',
                             'PTO hydraulic system for efficient dumping',
                             '6x4 axle configuration for maximum traction',
                             'Air brakes with ABS system for safety',
                             'Ergonomic cab with intuitive controls',
                             'Suspension system with reinforced leaf springs',
                             'Power-assisted hydraulic steering for maneuverability'
                         ],
                         'applications' => [
                             'Construction material transport',
                             'Earthmoving and excavation work',
                             'Road infrastructure projects',
                             'Urbanization projects',
                             'Aggregate and sand transport',
                             'Urban cleaning and maintenance'
                         ],
                         'technical_specs' => [
                             'Engine: Volvo D13 - 425 HP (317 kW) @ 1,800 rpm',
                             'Torque: 1,650 lb-ft (2,237 Nm) @ 1,000 rpm',
                             'Transmission: I-Shift 12-speed automatic',
                             'Load Capacity: 7 cubic meters',
                             'GVWR: 26,000 kg (57,320 lbs)',
                             'Axle Configuration: 6x4',
                             'Hydraulic System: PTO for dumping',
                             'Brakes: Air with ABS',
                             'Suspension: Front and rear leaf springs',
                             'Tires: 11R22.5',
                             'Fuel Tank: 300 liters',
                             'Steering: Power-assisted hydraulic',
                             'Voltage: 24V',
                             'Alternator: 150 amps',
                             'VIN: 4V4M19GG96N407479'
                         ]
                     ]
                 ]
             ]
         ];
 
         return $equipments[$slug] ?? null;
    }

    /**
     * Mostrar detalles de la Motoconformadora CAT 120B
     */
    public function motoconformadoraCat120b()
    {
        $language = session('language', 'es');
        $equipment = $this->getEquipmentData('motoconformadora-cat-120b');
        
        if (!$equipment) {
            abort(404);
        }
        
        return view('equipos-detalle', compact('equipment', 'language'));
    }

    /**
     * Mostrar detalles de la Motoconformadora GALION 118C
     */
    public function motoconformadoraGalion118c()
    {
        $language = session('language', 'es');
        $equipment = $this->getEquipmentData('motoconformadora-galion-118c');
        
        if (!$equipment) {
            abort(404);
        }
        
        return view('equipos-detalle', compact('equipment', 'language'));
    }

    /**
     * Obtener datos específicos para cada servicio
     */
    private function getServiceData($service, $language)
    {
        $services = [
            'concrete' => [
                'title' => [
                    'es' => 'Venta de Concreto y Materiales de Construcción',
                    'en' => 'Concrete and Construction Materials Sales'
                ],
                'description' => [
                    'es' => 'Ofrecemos concreto premezclado de alta calidad y materiales de construcción para proyectos de cualquier escala.',
                    'en' => 'We offer high-quality ready-mix concrete and construction materials for projects of any scale.'
                ],
                'features' => [
                    'es' => [
                        'Concreto premezclado de diferentes resistencias',
                        'Materiales certificados y de calidad',
                        'Entrega puntual en obra',
                        'Asesoría técnica especializada',
                        'Control de calidad riguroso'
                    ],
                    'en' => [
                        'Ready-mix concrete of different strengths',
                        'Certified and quality materials',
                        'Timely delivery to site',
                        'Specialized technical advice',
                        'Rigorous quality control'
                    ]
                ]
            ],
            'platforms' => [
                'title' => [
                    'es' => 'Alquiler de Plataformas Aéreas',
                    'en' => 'Aerial Platform Rental'
                ],
                'description' => [
                    'es' => 'Alquiler de plataformas aéreas para trabajos en altura con los más altos estándares de seguridad.',
                    'en' => 'Aerial platform rental for work at height with the highest safety standards.'
                ],
                'features' => [
                    'es' => [
                        'Plataformas de diferentes alturas',
                        'Equipos certificados y mantenidos',
                        'Operadores capacitados disponibles',
                        'Seguro de responsabilidad civil',
                        'Soporte técnico 24/7'
                    ],
                    'en' => [
                        'Platforms of different heights',
                        'Certified and maintained equipment',
                        'Trained operators available',
                        'Civil liability insurance',
                        '24/7 technical support'
                    ]
                ]
            ],
            'building' => [
                'title' => [
                    'es' => 'Servicios de Construcción',
                    'en' => 'Construction Services'
                ],
                'description' => [
                    'es' => 'Servicios integrales de construcción para proyectos residenciales, comerciales e industriales.',
                    'en' => 'Comprehensive construction services for residential, commercial and industrial projects.'
                ],
                'features' => [
                    'es' => [
                        'Construcción de estructuras',
                        'Acabados de alta calidad',
                        'Gestión integral de proyectos',
                        'Cumplimiento de normativas',
                        'Garantía en todos los trabajos'
                    ],
                    'en' => [
                        'Structure construction',
                        'High quality finishes',
                        'Comprehensive project management',
                        'Regulatory compliance',
                        'Warranty on all work'
                    ]
                ]
            ],
            'electrification' => [
                'title' => [
                    'es' => 'Servicios de Electrificación',
                    'en' => 'Electrification Services'
                ],
                'description' => [
                    'es' => 'Instalaciones eléctricas profesionales para proyectos residenciales, comerciales e industriales.',
                    'en' => 'Professional electrical installations for residential, commercial and industrial projects.'
                ],
                'features' => [
                    'es' => [
                        'Instalaciones eléctricas completas',
                        'Sistemas de iluminación LED',
                        'Tableros y automatización',
                        'Certificaciones eléctricas',
                        'Mantenimiento preventivo'
                    ],
                    'en' => [
                        'Complete electrical installations',
                        'LED lighting systems',
                        'Panels and automation',
                        'Electrical certifications',
                        'Preventive maintenance'
                    ]
                ]
            ],
            'drainage' => [
                'title' => [
                    'es' => 'Sistemas de Drenaje',
                    'en' => 'Drainage Systems'
                ],
                'description' => [
                    'es' => 'Diseño e instalación de sistemas de drenaje eficientes para control de aguas pluviales.',
                    'en' => 'Design and installation of efficient drainage systems for stormwater control.'
                ],
                'features' => [
                    'es' => [
                        'Diseño hidráulico especializado',
                        'Instalación de tuberías',
                        'Sistemas de captación',
                        'Mantenimiento de drenajes',
                        'Soluciones sustentables'
                    ],
                    'en' => [
                        'Specialized hydraulic design',
                        'Pipe installation',
                        'Collection systems',
                        'Drainage maintenance',
                        'Sustainable solutions'
                    ]
                ]
            ],
            'topographic' => [
                'title' => [
                    'es' => 'Levantamientos Topográficos',
                    'en' => 'Topographic Surveys'
                ],
                'description' => [
                    'es' => 'Levantamientos topográficos precisos utilizando tecnología de última generación.',
                    'en' => 'Precise topographic surveys using state-of-the-art technology.'
                ],
                'features' => [
                    'es' => [
                        'Levantamientos con drones',
                        'Tecnología GPS de precisión',
                        'Planos digitales detallados',
                        'Análisis de terreno',
                        'Certificación profesional'
                    ],
                    'en' => [
                        'Drone surveys',
                        'Precision GPS technology',
                        'Detailed digital plans',
                        'Terrain analysis',
                        'Professional certification'
                    ]
                ]
            ]
        ];

        // Si no se especifica servicio, usar el primero (concrete)
        $serviceKey = $service ?? 'concrete';
        
        return $services[$serviceKey] ?? $services['concrete'];
    }
}