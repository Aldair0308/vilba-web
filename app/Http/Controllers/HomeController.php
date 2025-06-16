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
        
        // Redirigir a la ruta específica del idioma
        if ($language === 'en') {
            return redirect()->route('home.EN');
        } else {
            return redirect()->route('home.ES');
        }
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