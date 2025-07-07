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
    public function servicesDetails(Request $request)
    {
        $language = $this->detectLanguage($request);
        Session::put('language', $language);
        
        return view('services_details', compact('language'));
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
    
    public function servicesDetailsEs(Request $request)
    {
        $language = 'es';
        Session::put('language', $language);
        return view('services_details', compact('language'));
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
    
    public function servicesDetailsEn(Request $request)
    {
        $language = 'en';
        Session::put('language', $language);
        return view('services_details', compact('language'));
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
                    'es' => 'Grúas móviles versátiles para montaje rápido y posicionamiento flexible.',
                    'en' => 'Versatile mobile cranes for quick setup and flexible positioning.'
                ],
                'hero_image' => 'assets/img/equipos/camion-kenworth-cover.png',
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
             'montacargas' => [
                 'slug' => 'montacargas',
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
                     'es' => 'Excavadoras',
                     'en' => 'Excavators'
                 ],
                 'description' => [
                     'es' => 'Excavadoras de alta potencia para trabajos de excavación y movimiento de tierra.',
                     'en' => 'High-power excavators for excavation and earthmoving work.'
                 ],
                 'hero_image' => 'assets/img/gallery/services5.jpg',
                 'gallery' => [
                     'assets/img/gallery/services5.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestras excavadoras están diseñadas para trabajos pesados de excavación, demolición y movimiento de tierra en proyectos de construcción e infraestructura.',
                         'features' => [
                             'Potencia del motor hasta 400 HP',
                             'Peso operativo hasta 50 toneladas',
                             'Alcance de excavación hasta 12 metros',
                             'Cabina con aire acondicionado',
                             'Sistema hidráulico de alta presión'
                         ],
                         'applications' => [
                             'Excavación de cimientos',
                             'Demolición de estructuras',
                             'Movimiento de tierra',
                             'Construcción de carreteras'
                         ],
                         'technical_specs' => [
                             'Potencia: 400 HP',
                             'Peso operativo: 50 toneladas',
                             'Alcance máximo: 12m',
                             'Profundidad de excavación: 8m',
                             'Capacidad del cucharón: 3.5 m³'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our excavators are designed for heavy excavation, demolition, and earthmoving work in construction and infrastructure projects.',
                         'features' => [
                             'Engine power up to 400 HP',
                             'Operating weight up to 50 tons',
                             'Excavation reach up to 12 meters',
                             'Air-conditioned cabin',
                             'High-pressure hydraulic system'
                         ],
                         'applications' => [
                             'Foundation excavation',
                             'Structure demolition',
                             'Earthmoving',
                             'Road construction'
                         ],
                         'technical_specs' => [
                             'Power: 400 HP',
                             'Operating weight: 50 tons',
                             'Maximum reach: 12m',
                             'Digging depth: 8m',
                             'Bucket capacity: 3.5 m³'
                         ]
                     ]
                 ]
             ],
             'excavators' => [
                 'slug' => 'excavators',
                 'name' => [
                     'es' => 'Excavadoras',
                     'en' => 'Excavators'
                 ],
                 'description' => [
                     'es' => 'Excavadoras de alta potencia para trabajos de excavación y movimiento de tierra.',
                     'en' => 'High-power excavators for excavation and earthmoving work.'
                 ],
                 'hero_image' => 'assets/img/gallery/services5.jpg',
                 'gallery' => [
                     'assets/img/gallery/services5.jpg',
                     'assets/img/gallery/services2.jpg',
                     'assets/img/gallery/services3.jpg'
                 ],
                 'detailed_info' => [
                     'es' => [
                         'description' => 'Nuestras excavadoras están diseñadas para trabajos pesados de excavación, demolición y movimiento de tierra en proyectos de construcción e infraestructura.',
                         'features' => [
                             'Potencia del motor hasta 400 HP',
                             'Peso operativo hasta 50 toneladas',
                             'Alcance de excavación hasta 12 metros',
                             'Cabina con aire acondicionado',
                             'Sistema hidráulico de alta presión'
                         ],
                         'applications' => [
                             'Excavación de cimientos',
                             'Demolición de estructuras',
                             'Movimiento de tierra',
                             'Construcción de carreteras'
                         ],
                         'technical_specs' => [
                             'Potencia: 400 HP',
                             'Peso operativo: 50 toneladas',
                             'Alcance máximo: 12m',
                             'Profundidad de excavación: 8m',
                             'Capacidad del cucharón: 3.5 m³'
                         ]
                     ],
                     'en' => [
                         'description' => 'Our excavators are designed for heavy excavation, demolition, and earthmoving work in construction and infrastructure projects.',
                         'features' => [
                             'Engine power up to 400 HP',
                             'Operating weight up to 50 tons',
                             'Excavation reach up to 12 meters',
                             'Air-conditioned cabin',
                             'High-pressure hydraulic system'
                         ],
                         'applications' => [
                             'Foundation excavation',
                             'Structure demolition',
                             'Earthmoving',
                             'Road construction'
                         ],
                         'technical_specs' => [
                             'Power: 400 HP',
                             'Operating weight: 50 tons',
                             'Maximum reach: 12m',
                             'Digging depth: 8m',
                             'Bucket capacity: 3.5 m³'
                         ]
                     ]
                 ]
             ],
             'equipos-especializados' => [
                 'slug' => 'equipos-especializados',
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
                     'es' => 'Camión de Volteo Ford',
                     'en' => 'Dump Truck'
                 ],
                 'description' => [
                     'es' => 'Camiones de volteo para transporte y descarga de materiales.',
                     'en' => 'Dump trucks for material transport and unloading.'
                 ],
                 'hero_image' => 'assets/img/equipos/camion-cover.png',
                 'gallery' => [
                     'assets/img/equipos/camion.png',
                     'assets/img/gallery/dumptruck1.jpg',
                     'assets/img/gallery/dumptruck2.jpg'
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
                 ]
                         ],
             'excavadora' => [
                 'slug' => 'excavadora',
                 'name' => [
                     'es' => 'Excavadora',
                     'en' => 'Dump Truck'
                 ],
                 'description' => [
                     'es' => 'Camiones de volteo para transporte y descarga de materiales.',
                     'en' => 'Dump trucks for material transport and unloading.'
                 ],
                 'hero_image' => 'assets/img/equipos/excavadora-cover.png',
                 'gallery' => [
                     'assets/img/equipos/excavadora.png',
                     'assets/img/gallery/dumptruck1.jpg',
                     'assets/img/gallery/dumptruck2.jpg'
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
                 ]
             ]
         ];
 
         return $equipments[$slug] ?? null;
     }
 }