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
            'path' => $path ?? 'no_path'
        ]);
        
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
}