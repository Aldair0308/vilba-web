<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Command as MongoCommand;
use MongoDB\Driver\Query;
use MongoDB\Driver\BulkWrite;
use Exception;

class TestMongoConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongo:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test MongoDB connection and list all collections';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Create MongoDB connection using native driver
            $manager = new Manager('mongodb://localhost:27017');
            
            $this->info('✓ MongoDB connection successful!');
            
            // First, let's check what databases exist and find the correct one
            $command = new MongoCommand(['listDatabases' => 1]);
            $cursor = $manager->executeCommand('admin', $command);
            $databases = $cursor->toArray()[0]->databases;
            
            // Look for databases that might be the target (vilba-bd or similar)
            $targetDatabase = null;
            $possibleNames = ['vilba-bd', 'vilba_bd', 'vilbabd', 'vilba-db'];
            
            foreach ($databases as $db) {
                if (in_array($db->name, $possibleNames)) {
                    $targetDatabase = $db->name;
                    break;
                }
            }
            
            if (!$targetDatabase) {
                $this->warn('No se encontró la base de datos vilba-bd. Bases de datos disponibles:');
                foreach ($databases as $db) {
                    if (!in_array($db->name, ['admin', 'config', 'local'])) {
                        $this->line("  • {$db->name}");
                    }
                }
                return 1;
            }
            
            $this->info("\n📊 Conectado a la base de datos: {$targetDatabase}");
            $this->info(str_repeat('=', 50));
            
            // Get database stats
            try {
                $statsCommand = new MongoCommand(['dbStats' => 1]);
                $statsCursor = $manager->executeCommand($targetDatabase, $statsCommand);
                $dbStats = $statsCursor->toArray()[0];
                $dbSize = isset($dbStats->dataSize) ? number_format($dbStats->dataSize) . ' bytes' : 'Unknown size';
                $this->line("🗄️  {$targetDatabase} ({$dbSize})");
            } catch (Exception $e) {
                $this->line("🗄️  {$targetDatabase}");
            }
            
            // List collections for the target database only
            try {
                $listCollections = new MongoCommand(['listCollections' => 1]);
                $collectionsCursor = $manager->executeCommand($targetDatabase, $listCollections);
                $collections = $collectionsCursor->toArray();
                
                if (!empty($collections)) {
                    $this->info("\n📁 Colecciones en {$targetDatabase}:");
                    $this->info(str_repeat('-', 40));
                    
                    foreach ($collections as $collection) {
                        // Get collection stats
                        try {
                            $statsCommand = new MongoCommand(['collStats' => $collection->name]);
                            $statsCursor = $manager->executeCommand($targetDatabase, $statsCommand);
                            $stats = $statsCursor->toArray()[0];
                            $docCount = $stats->count ?? 0;
                            $avgDocSize = isset($stats->avgObjSize) ? number_format($stats->avgObjSize, 2) . ' bytes' : 'N/A';
                            $totalSize = isset($stats->size) ? number_format($stats->size) . ' bytes' : 'N/A';
                            
                            $this->line("📄 {$collection->name}");
                            $this->line("   • Documentos: {$docCount}");
                            $this->line("   • Tamaño promedio por documento: {$avgDocSize}");
                            $this->line("   • Tamaño total: {$totalSize}");
                            $this->line('');
                        } catch (Exception $e) {
                            $this->line("📄 {$collection->name} (no se pudieron obtener estadísticas)");
                        }
                    }
                } else {
                    $this->line('\n(No hay colecciones en esta base de datos)');
                }
            } catch (Exception $e) {
                $this->warn("No se pudieron listar las colecciones: {$e->getMessage()}");
            }
            
            $this->info('\n🎉 Conexión exitosa a MongoDB!');
            $this->info('✅ Base de datos encontrada y accesible');
            $this->info('✅ Colecciones listadas correctamente');
            
        } catch (Exception $e) {
            $this->error('❌ MongoDB connection failed!');
            $this->error('Error: ' . $e->getMessage());
            $this->info('');
            $this->info('Please check:');
            $this->info('1. MongoDB is running on your system');
            $this->info('2. MongoDB is accessible on localhost:27017');
            $this->info('3. PHP MongoDB extension is properly installed');
            
            return 1;
        }
        
        return 0;
    }
}