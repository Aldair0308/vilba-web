<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class LogCrudTest extends TestCase
{
    use WithFaker;

    private User $adminUser;
    private User $testUser;
    private Log $testLog;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        User::where('email', 'like', '%@example.com')->delete();
        Log::where('userName', 'like', '%Test%')->delete();
        
        // Create an admin user for testing
        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'status' => 'active',
        ]);
        
        // Create a test user
        $this->testUser = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'rol' => 'user',
            'status' => 'active',
        ]);
        
        // Create a test log
        $this->testLog = Log::create([
            'userId' => $this->testUser->id,
            'userName' => $this->testUser->name,
            'action' => Log::ACTION_CREATE,
            'module' => Log::MODULE_USER,
            'entityId' => $this->testUser->id,
            'entityName' => $this->testUser->name,
            'description' => 'Test log entry',
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Test User Agent',
            'previousData' => null,
            'newData' => ['name' => 'Test User', 'email' => 'testuser@example.com'],
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        User::where('email', 'like', '%@example.com')->delete();
        Log::where('userName', 'like', '%Test%')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_log_pages()
    {
        // Test index page
        $response = $this->get(route('logs.index'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('logs.show', $this->testLog));
        $response->assertRedirect(route('login'));

        // Test search endpoint
        $response = $this->get(route('logs.search'));
        $response->assertRedirect(route('login'));

        // Test stats endpoint
        $response = $this->get(route('logs.stats'));
        $response->assertRedirect(route('login'));

        // Test export endpoint
        $response = $this->get(route('logs.export'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_logs_index()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
        $response->assertViewHas('logs');
    }

    /** @test */
    public function authenticated_user_can_view_log_details()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.show', $this->testLog->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.show');
        $response->assertViewHas('log', $this->testLog);
        $response->assertSee($this->testLog->userName);
        $response->assertSee($this->testLog->formatted_action);
    }

    /** @test */
    public function can_search_logs()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.search', ['q' => 'Test']));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Búsqueda completada exitosamente'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function can_get_log_statistics()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.stats'));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Estadísticas obtenidas exitosamente'
        ]);
        
        $stats = $response->json('data');
        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('by_action', $stats);
        $this->assertArrayHasKey('by_module', $stats);
        $this->assertArrayHasKey('recent_activity', $stats);
    }

    /** @test */
    public function can_export_logs_to_csv()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.export'));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="logs_export_' . date('Y-m-d') . '.csv"');
    }

    /** @test */
    public function can_filter_logs_by_action()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index', ['action' => Log::ACTION_CREATE]));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
    }

    /** @test */
    public function can_filter_logs_by_module()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index', ['module' => Log::MODULE_USER]));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
    }

    /** @test */
    public function can_filter_logs_by_date_range()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index', [
            'date_from' => now()->subDays(7)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d')
        ]));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
    }

    /** @test */
    public function can_search_logs_in_index()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index', ['search' => 'Test']));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
    }

    /** @test */
    public function api_endpoints_return_json_responses()
    {
        $this->actingAs($this->adminUser);
        
        // Test index with JSON
        $response = $this->getJson(route('logs.index'));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test show with JSON
        $response = $this->getJson(route('logs.show', $this->testLog->id));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test search with JSON
        $response = $this->getJson(route('logs.search', ['q' => 'Test']));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test stats with JSON
        $response = $this->getJson(route('logs.stats'));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    /** @test */
    public function log_model_scopes_work_correctly()
    {
        // Test action scope
        $createLogs = Log::byAction(Log::ACTION_CREATE)->get();
        $this->assertGreaterThan(0, $createLogs->count());
        
        // Test module scope
        $userLogs = Log::byModule(Log::MODULE_USER)->get();
        $this->assertGreaterThan(0, $userLogs->count());
        
        // Test user scope
        $userSpecificLogs = Log::byUser($this->testUser->id)->get();
        $this->assertGreaterThan(0, $userSpecificLogs->count());
        
        // Test recent scope
        $recentLogs = Log::recent(7)->get();
        $this->assertGreaterThan(0, $recentLogs->count());
        
        // Test date range scope
        $recentLogs = Log::byDateRange(now()->subDays(1), now())->get();
        $this->assertGreaterThan(0, $recentLogs->count());
    }

    /** @test */
    public function log_model_methods_work_correctly()
    {
        // Test formatted attributes
        $this->assertNotEmpty($this->testLog->formatted_action);
        $this->assertNotEmpty($this->testLog->formatted_module);
        $this->assertNotEmpty($this->testLog->full_description);
        
        // Test data changes methods
        $this->assertTrue($this->testLog->hasDataChanges());
        $this->assertNotEmpty($this->testLog->getChanges());
        
        // Test color and icon methods
        $this->assertNotEmpty($this->testLog->getActionColor());
        $this->assertNotEmpty($this->testLog->getActionIcon());
        $this->assertNotEmpty($this->testLog->getModuleIcon());
    }

    /** @test */
    public function log_model_static_methods_work_correctly()
    {
        // Test getActions method
        $actions = Log::getActions();
        $this->assertIsArray($actions);
        $this->assertArrayHasKey(Log::ACTION_CREATE, $actions);
        
        // Test getModules method
        $modules = Log::getModules();
        $this->assertIsArray($modules);
        $this->assertArrayHasKey(Log::MODULE_USER, $modules);
    }

    /** @test */
    public function can_create_log_using_static_method()
    {
        $logData = [
            'userId' => $this->testUser->id,
            'userName' => $this->testUser->name,
            'action' => Log::ACTION_UPDATE,
            'module' => Log::MODULE_USER,
            'entityId' => $this->testUser->id,
            'entityName' => $this->testUser->name,
            'description' => 'Updated user profile',
            'previousData' => ['name' => 'Old Name'],
            'newData' => ['name' => 'New Name'],
        ];
        
        $log = Log::createLog(
            $logData['userId'],
            $logData['userName'],
            $logData['action'],
            $logData['module'],
            $logData['entityId'],
            $logData['entityName'],
            $logData['previousData'],
            $logData['newData'],
            $logData['description']
        );
        
        $this->assertInstanceOf(Log::class, $log);
        $this->assertEquals($logData['action'], $log->action);
        $this->assertEquals($logData['module'], $log->module);
        $this->assertEquals($logData['description'], $log->description);
        
        // Clean up
        $log->delete();
    }

    /** @test */
    public function log_relationship_with_user_works()
    {
        $this->assertInstanceOf(User::class, $this->testLog->user);
        $this->assertEquals($this->testUser->id, $this->testLog->user->id);
    }

    /** @test */
    public function log_casts_work_correctly()
    {
        // Test that dates are cast to Carbon instances
        $this->assertInstanceOf(\Carbon\Carbon::class, $this->testLog->createdAt);
        $this->assertInstanceOf(\Carbon\Carbon::class, $this->testLog->updatedAt);
        
        // Test that data fields are cast to arrays
        $this->assertIsArray($this->testLog->newData);
    }

    /** @test */
    public function can_filter_logs_with_multiple_criteria()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.index', [
            'action' => Log::ACTION_CREATE,
            'module' => Log::MODULE_USER,
            'search' => 'Test',
            'date_from' => now()->subDays(1)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d')
        ]));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
    }

    /** @test */
    public function export_includes_filtered_results()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('logs.export', [
            'action' => Log::ACTION_CREATE,
            'module' => Log::MODULE_USER
        ]));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function pagination_works_correctly()
    {
        $this->actingAs($this->adminUser);
        
        // Create additional logs for pagination testing
        for ($i = 0; $i < 20; $i++) {
            Log::create([
                'userId' => $this->testUser->id,
                'userName' => "Test User {$i}",
                'action' => Log::ACTION_CREATE,
                'module' => Log::MODULE_USER,
                'entityId' => $this->testUser->id,
                'entityName' => "Test Entity {$i}",
                'description' => "Test log entry {$i}",
                'ipAddress' => '127.0.0.1',
                'userAgent' => 'Test User Agent',
            ]);
        }
        
        $response = $this->get(route('logs.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('logs.index');
        $response->assertViewHas('logs');
        
        $logs = $response->viewData('logs');
        $this->assertLessThanOrEqual(15, $logs->count()); // Default pagination is 15
    }
}