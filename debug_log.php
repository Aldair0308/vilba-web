<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG LOG DATA ===\n";

// Get all logs to find ones with data
$logs = App\Models\Log::limit(10)->get();

echo "Total logs found: " . $logs->count() . "\n\n";

foreach ($logs as $index => $log) {
    echo "=== LOG #" . ($index + 1) . " (ID: {$log->id}) ===\n";
    
    // Check raw attributes first
    $rawAttrs = $log->getAttributes();
    echo "Raw previousData: ";
    var_dump($rawAttrs['previousData'] ?? 'NOT SET');
    echo "Raw newData: ";
    var_dump($rawAttrs['newData'] ?? 'NOT SET');
    
    // Check casted attributes
    echo "Casted previousData type: " . gettype($log->previousData) . "\n";
    echo "Casted newData type: " . gettype($log->newData) . "\n";
    
    // Test hasDataChanges
    try {
        $result = $log->hasDataChanges();
        echo "hasDataChanges result: " . ($result ? 'true' : 'false') . "\n";
    } catch (Exception $e) {
        echo "ERROR in hasDataChanges: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
        break; // Stop on first error
    }
    
    echo "\n";
    
    // If we find a log with data, examine it more closely
    if (isset($rawAttrs['previousData']) || isset($rawAttrs['newData'])) {
        echo "*** FOUND LOG WITH DATA - EXAMINING CLOSELY ***\n";
        echo "previousData content: ";
        var_dump($log->previousData);
        echo "newData content: ";
        var_dump($log->newData);
        break;
    }
}

if ($logs->isEmpty()) {
    echo "No logs found in database\n";
}