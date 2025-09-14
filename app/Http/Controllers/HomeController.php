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
            'retroexcavadora' => [
                'slug' => 'retroexcavadora',
                'name' => [
                    'es' => 'Retroexcavadora',
                    'en' => 'Backhoe Loader'
                ],
                'description' => [
                    'es' => 'Retroexcavadoras versátiles para excavación, carga y múltiples tareas de construcción.',
                    'en' => 'Versatile backhoe loaders for excavation, loading, and multiple construction tasks.'
                ],
                'hero_image' => 'assets/img/equipos/retroexcavadora.svg',
                'gallery' => [
                    'assets/img/equipos/retroexcavadora.svg',
                    'assets/img/gallery/backhoe1.jpg',
                    'assets/img/gallery/backhoe2.jpg'
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
                ]
            ],
            'vibrocompactadora' => [
                'slug' => 'vibrocompactadora',
                'name' => [
                    'es' => 'Vibrocompactadora',
                    'en' => 'Vibratory Roller'
                ],
                'description' => [
                    'es' => 'Vibrocompactadoras para compactación de suelos y asfalto.',
                    'en' => 'Vibratory rollers for soil and asphalt compaction.'
                ],
                'hero_image' => 'assets/img/equipos/vibrocompactadora.svg',
                'gallery' => [
                    'assets/img/equipos/vibrocompactadora.svg',
                    'assets/img/gallery/roller1.jpg',
                    'assets/img/gallery/roller2.jpg'
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
                            'Trabajos de pavimentación'
                        ],
                        'technical_specs' => [
                            'Peso operativo: 3-15 toneladas',
                            'Ancho de compactación: 1.2-2.1 metros',
                            'Frecuencia de vibración: 2800-4200 vpm',
                            'Amplitud: 0.35-0.85 mm',
                            'Velocidad de trabajo: 0-12 km/h'
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
                            'Paving work'
                        ],
                        'technical_specs' => [
                            'Operating weight: 3-15 tons',
                            'Compaction width: 1.2-2.1 meters',
                            'Vibration frequency: 2800-4200 vpm',
                            'Amplitude: 0.35-0.85 mm',
                            'Working speed: 0-12 km/h'
                        ]
                    ]
                 ]
             ],
             'motoconformadora' => [
                 'slug' => 'motoconformadora',
                 'name' => [
                     'es' => 'Motoconformadora',
                     'en' => 'Motor Grader'
                 ],
                 'description' => [
                     'es' => 'Motoconformadoras para nivelación y conformación de terrenos.',
                     'en' => 'Motor graders for land leveling and shaping.'
                 ],
                 'hero_image' => 'assets/img/equipos/motoconformadora.svg',
                 'gallery' => [
                     'assets/img/equipos/motoconformadora.svg',
                     'assets/img/gallery/grader1.jpg',
                     'assets/img/gallery/grader2.jpg'
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
                 ]
             ],
             'pipa-agua' => [
                 'slug' => 'pipa-agua',
                 'name' => [
                     'es' => 'Pipa de Agua',
                     'en' => 'Water Truck'
                 ],
                 'description' => [
                     'es' => 'Pipas de agua para control de polvo, compactación y riego.',
                     'en' => 'Water trucks for dust control, compaction, and irrigation.'
                 ],
                 'hero_image' => 'assets/img/equipos/pipa-agua.svg',
                 'gallery' => [
                     'assets/img/equipos/pipa-agua.svg',
                     'assets/img/gallery/watertruck1.jpg',
                     'assets/img/gallery/watertruck2.jpg'
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
             ]
         ];
 
         return $equipments[$slug] ?? null;
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