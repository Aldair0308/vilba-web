<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

echo "Buscando el problema de json_decode...\n\n";

// Buscar en el modelo Log por cualquier uso problemático de json_decode
echo "1. Verificando el modelo Log...\n";

// Simular datos que podrían causar el problema
$testData = [
    'string_json' => '{"key": "value"}',
    'array_data' => ['key' => 'value'],
    'null_data' => null,
    'empty_string' => '',
    'invalid_json' => 'NOT SET'
];

foreach ($testData as $type => $data) {
    echo "\nProbando con $type: ";
    var_dump($data);
    
    try {
        // Simular lo que hace Laravel cuando castea a array
        if (is_string($data)) {
            $result = json_decode($data, true);
            echo "json_decode resultado: ";
            var_dump($result);
        } else {
            echo "No es string, no se puede hacer json_decode\n";
        }
        
        // Simular el cast de Laravel
        if (is_string($data)) {
            $casted = json_decode($data, true) ?: [];
        } elseif (is_array($data)) {
            $casted = $data;
        } else {
            $casted = [];
        }
        
        echo "Resultado del cast: ";
        var_dump($casted);
        
        // Ahora simular si alguien intenta hacer json_decode en el resultado casteado
        if (is_array($casted)) {
            echo "PROBLEMA: Si alguien intenta json_decode en el array casteado...\n";
            try {
                $problematic = json_decode($casted, true); // Esto causaría el error
                echo "Resultado problemático: ";
                var_dump($problematic);
            } catch (TypeError $e) {
                echo "¡ERROR ENCONTRADO! " . $e->getMessage() . "\n";
            }
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat('-', 50) . "\n";
}

echo "\n2. Verificando si hay algún código que haga json_decode en datos ya casteados...\n";

// Buscar en archivos específicos
$filesToCheck = [
    'app/Models/Log.php',
    'resources/views/logs/index.blade.php',
    'resources/views/logs/show.blade.php',
    'app/Http/Controllers/LogController.php'
];

foreach ($filesToCheck as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\nVerificando $file...\n";
        
        // Buscar patrones problemáticos
        $patterns = [
            '/json_decode\s*\(\s*\$[^,)]*(?:previousData|newData)/',
            '/json_decode\s*\(\s*\$log->(?:previousData|newData)/',
            '/json_decode\s*\(.*(?:previousData|newData).*\)/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
                echo "¡PATRÓN PROBLEMÁTICO ENCONTRADO!\n";
                foreach ($matches[0] as $match) {
                    $line = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                    echo "Línea $line: " . trim($match[0]) . "\n";
                }
            }
        }
    } else {
        echo "Archivo $file no encontrado\n";
    }
}

echo "\n3. Verificando si el problema está en las vistas Blade...\n";

// Verificar si hay algún helper o función personalizada que use json_decode
$bladeFiles = glob('resources/views/**/*.blade.php');
foreach ($bladeFiles as $bladeFile) {
    $content = file_get_contents($bladeFile);
    if (strpos($content, 'json_decode') !== false) {
        echo "json_decode encontrado en: $bladeFile\n";
        $lines = explode("\n", $content);
        foreach ($lines as $lineNum => $line) {
            if (strpos($line, 'json_decode') !== false) {
                echo "  Línea " . ($lineNum + 1) . ": " . trim($line) . "\n";
            }
        }
    }
}

echo "\nBúsqueda completada.\n";