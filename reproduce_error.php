<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    // Crear una solicitud a la página de logs sin autenticación primero
    $request = Illuminate\Http\Request::create('/logs', 'GET');
    
    // Establecer headers para simular una solicitud web
    $request->headers->set('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
    $request->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    // Manejar la solicitud
    $response = $kernel->handle($request);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    
    $content = $response->getContent();
    
    // Verificar si hay un error de json_decode en el contenido
    if (strpos($content, 'json_decode') !== false) {
        echo "¡Posible error de json_decode encontrado!\n";
        
        // Buscar patrones de error comunes
        if (preg_match('/TypeError.*json_decode/i', $content)) {
            echo "Error TypeError con json_decode confirmado\n";
        }
        
        // Extraer líneas que contienen json_decode
        $lines = explode("\n", $content);
        foreach ($lines as $lineNum => $line) {
            if (strpos($line, 'json_decode') !== false) {
                echo "Línea " . ($lineNum + 1) . ": " . trim($line) . "\n";
            }
        }
    }
    
    // Si es una redirección, seguirla
    if ($response->getStatusCode() == 302) {
        $location = $response->headers->get('Location');
        echo "Redirigido a: " . $location . "\n";
        
        // Si es redirección a login, intentar acceder directamente a los logs con una sesión simulada
        if (strpos($location, 'login') !== false) {
            echo "Intentando acceso directo a logs...\n";
            
            // Crear una nueva solicitud con datos de sesión simulados
            $request2 = Illuminate\Http\Request::create('/logs', 'GET');
            $request2->headers->set('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
            
            // Simular que el usuario está autenticado agregando datos de sesión
            $session = app('session.store');
            $session->put('_token', 'test-token');
            $session->put('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', 1); // Simular ID de usuario
            $request2->setSession($session);
            
            try {
                $response2 = $kernel->handle($request2);
                echo "Segunda respuesta status: " . $response2->getStatusCode() . "\n";
                
                $content2 = $response2->getContent();
                if (strpos($content2, 'json_decode') !== false) {
                    echo "¡Error de json_decode encontrado en segunda solicitud!\n";
                    
                    // Extraer líneas que contienen json_decode
                    $lines2 = explode("\n", $content2);
                    foreach ($lines2 as $lineNum => $line) {
                        if (strpos($line, 'json_decode') !== false || strpos($line, 'TypeError') !== false) {
                            echo "Línea " . ($lineNum + 1) . ": " . trim($line) . "\n";
                        }
                    }
                }
            } catch (Exception $e2) {
                echo "Error en segunda solicitud: " . $e2->getMessage() . "\n";
                echo "Archivo: " . $e2->getFile() . "\n";
                echo "Línea: " . $e2->getLine() . "\n";
                
                // Verificar si el error contiene json_decode
                if (strpos($e2->getMessage(), 'json_decode') !== false) {
                    echo "¡ERROR DE JSON_DECODE ENCONTRADO!\n";
                    echo "Stack trace completo:\n" . $e2->getTraceAsString() . "\n";
                }
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error principal: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    
    // Verificar si el error contiene json_decode
    if (strpos($e->getMessage(), 'json_decode') !== false) {
        echo "¡ERROR DE JSON_DECODE ENCONTRADO!\n";
        echo "Stack trace completo:\n" . $e->getTraceAsString() . "\n";
    }
}

// Terminar la aplicación
$kernel->terminate($request, $response ?? null);