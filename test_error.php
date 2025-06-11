<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING ERROR REPRODUCTION ===\n";

// Find a log with data
$log = App\Models\Log::whereNotNull('previousData')
    ->orWhereNotNull('newData')
    ->first();

if (!$log) {
    echo "No logs with data found\n";
    exit;
}

echo "Testing log ID: {$log->id}\n";

// Test the exact operations that might be causing the error
try {
    echo "\n1. Testing hasDataChanges()...\n";
    $result = $log->hasDataChanges();
    echo "Result: " . ($result ? 'true' : 'false') . "\n";
    
    echo "\n2. Testing previousData access...\n";
    $prevData = $log->previousData;
    echo "Type: " . gettype($prevData) . "\n";
    
    echo "\n3. Testing newData access...\n";
    $newData = $log->newData;
    echo "Type: " . gettype($newData) . "\n";
    
    echo "\n4. Testing json_encode on previousData...\n";
    if ($prevData) {
        $encoded = json_encode($prevData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "Success: " . strlen($encoded) . " characters\n";
    } else {
        echo "previousData is null\n";
    }
    
    echo "\n5. Testing json_encode on newData...\n";
    if ($newData) {
        $encoded = json_encode($newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "Success: " . strlen($encoded) . " characters\n";
    } else {
        echo "newData is null\n";
    }
    
    echo "\n6. Testing getChanges()...\n";
    $changes = $log->getChanges();
    echo "Changes type: " . gettype($changes) . "\n";
    echo "Changes count: " . count($changes) . "\n";
    
    echo "\n7. Testing raw attribute access...\n";
    $rawAttrs = $log->getAttributes();
    if (isset($rawAttrs['previousData'])) {
        echo "Raw previousData type: " . gettype($rawAttrs['previousData']) . "\n";
        // Try to json_decode the raw data
        if (is_string($rawAttrs['previousData'])) {
            $decoded = json_decode($rawAttrs['previousData'], true);
            echo "json_decode on raw previousData: " . (is_array($decoded) ? 'SUCCESS' : 'FAILED') . "\n";
        }
    }
    
    if (isset($rawAttrs['newData'])) {
        echo "Raw newData type: " . gettype($rawAttrs['newData']) . "\n";
        // Try to json_decode the raw data
        if (is_string($rawAttrs['newData'])) {
            $decoded = json_decode($rawAttrs['newData'], true);
            echo "json_decode on raw newData: " . (is_array($decoded) ? 'SUCCESS' : 'FAILED') . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "\nERROR CAUGHT: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";