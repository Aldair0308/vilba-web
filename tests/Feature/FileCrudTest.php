<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class FileCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private File $file;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        File::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        // Create a test user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Create a test file
        $this->file = File::create([
            'name' => 'Test Document',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content for testing'),
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        File::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_file_pages()
    {
        // Test index page
        $response = $this->get(route('files.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('files.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('files.show', $this->file));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('files.edit', $this->file));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_files_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.index');
        $response->assertViewHas('files');
    }

    /** @test */
    public function authenticated_user_can_view_create_file_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.create');
    }

    /** @test */
    public function authenticated_user_can_store_valid_file()
    {
        $this->actingAs($this->user);
        
        $fileData = [
            'name' => 'New Test Document',
            'base64' => 'data:application/pdf;base64,' . base64_encode('new fake pdf content'),
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ];
        
        $response = $this->post(route('files.store'), $fileData);
        
        $response->assertRedirect(route('files.index'));
        $response->assertSessionHas('success', 'Archivo creado exitosamente');
        
        $this->assertDatabaseHas('files', [
            'name' => 'New Test Document',
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ]);
    }

    /** @test */
    public function authenticated_user_cannot_store_file_without_required_fields()
    {
        $this->actingAs($this->user);
        
        // Test without name
        $response = $this->post(route('files.store'), [
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['name']);
        
        // Test without base64
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['base64']);
        
        // Test without type
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['type']);
        
        // Test without department
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'type' => 'pdf',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['department']);
        
        // Test without responsible_id
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'type' => 'pdf',
            'department' => 'IT',
        ]);
        $response->assertSessionHasErrors(['responsible_id']);
    }

    /** @test */
    public function authenticated_user_cannot_store_file_with_invalid_type()
    {
        $this->actingAs($this->user);
        
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'type' => 'invalid_type',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        
        $response->assertSessionHasErrors(['type']);
    }

    /** @test */
    public function authenticated_user_can_view_file_details()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.show', $this->file->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.show');
        $response->assertViewHas('file', $this->file);
    }

    /** @test */
    public function authenticated_user_can_view_edit_file_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.edit', $this->file->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.edit');
        $response->assertViewHas('file', $this->file);
    }

    /** @test */
    public function authenticated_user_can_update_file_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'name' => 'Updated Document Name',
            'type' => 'excel',
            'department' => 'Finance',
            'responsible_id' => 'user789',
        ];
        
        $response = $this->put(route('files.update', $this->file->id), $updateData);
        
        $response->assertRedirect(route('files.show', $this->file->id));
        $response->assertSessionHas('success', 'Archivo actualizado exitosamente');
        
        $this->file->refresh();
        $this->assertEquals('Updated Document Name', $this->file->name);
        $this->assertEquals('excel', $this->file->type);
        $this->assertEquals('Finance', $this->file->department);
        $this->assertEquals('user789', $this->file->responsible_id);
    }

    /** @test */
    public function authenticated_user_cannot_update_file_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test invalid type
        $response = $this->put(route('files.update', $this->file->id), [
            'name' => 'Test',
            'type' => 'invalid_type',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['type']);
        
        // Test empty name
        $response = $this->put(route('files.update', $this->file->id), [
            'name' => '',
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['name']);
        
        // Test empty department
        $response = $this->put(route('files.update', $this->file->id), [
            'name' => 'Test',
            'type' => 'pdf',
            'department' => '',
            'responsible_id' => 'user123',
        ]);
        $response->assertSessionHasErrors(['department']);
        
        // Test empty responsible_id
        $response = $this->put(route('files.update', $this->file->id), [
            'name' => 'Test',
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => '',
        ]);
        $response->assertSessionHasErrors(['responsible_id']);
    }

    /** @test */
    public function authenticated_user_can_delete_file()
    {
        $this->actingAs($this->user);
        
        $response = $this->delete(route('files.destroy', $this->file->id));
        
        $response->assertRedirect(route('files.index'));
        $response->assertSessionHas('success', 'Archivo eliminado exitosamente');
        
        $this->assertDatabaseMissing('files', [
            '_id' => $this->file->id
        ]);
    }

    /** @test */
    public function authenticated_user_can_download_file()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.download', $this->file->id));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition');
    }

    /** @test */
    public function authenticated_user_can_search_files()
    {
        $this->actingAs($this->user);
        
        // Create additional files for search
        File::create([
            'name' => 'Searchable Document',
            'base64' => 'data:application/pdf;base64,' . base64_encode('content'),
            'type' => 'pdf',
            'department' => 'Marketing',
            'responsible_id' => 'user999',
        ]);
        
        $response = $this->get(route('files.search', ['q' => 'Searchable']));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'type',
                    'department',
                    'responsible_id'
                ]
            ],
            'message'
        ]);
        
        $responseData = $response->json();
        $this->assertTrue($responseData['success']);
        $this->assertGreaterThan(0, count($responseData['data']));
    }

    /** @test */
    public function authenticated_user_can_get_file_statistics()
    {
        $this->actingAs($this->user);
        
        // Create additional files
        File::factory()->pdf()->count(2)->create();
        File::factory()->excel()->count(3)->create();
        
        $response = $this->get(route('files.stats'));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total',
            'pdf',
            'excel',
            'total_size',
            'average_size',
            'formatted_total_size',
            'formatted_average_size'
        ]);
        
        $stats = $response->json();
        $this->assertGreaterThan(0, $stats['total']);
        $this->assertGreaterThan(0, $stats['pdf']);
        $this->assertGreaterThan(0, $stats['excel']);
    }

    /** @test */
    public function files_index_can_be_filtered_by_type()
    {
        $this->actingAs($this->user);
        
        // Create files of different types
        File::factory()->pdf()->create(['name' => 'PDF Document']);
        File::factory()->excel()->create(['name' => 'Excel Document']);
        
        // Filter by PDF
        $response = $this->get(route('files.index', ['type' => 'pdf']));
        $response->assertStatus(200);
        
        // Filter by Excel
        $response = $this->get(route('files.index', ['type' => 'excel']));
        $response->assertStatus(200);
    }

    /** @test */
    public function files_index_can_be_filtered_by_department()
    {
        $this->actingAs($this->user);
        
        // Create files for different departments
        File::factory()->create(['department' => 'HR']);
        File::factory()->create(['department' => 'Finance']);
        
        $response = $this->get(route('files.index', ['department' => 'HR']));
        $response->assertStatus(200);
    }

    /** @test */
    public function files_index_can_be_searched()
    {
        $this->actingAs($this->user);
        
        File::factory()->create(['name' => 'Important Document']);
        File::factory()->create(['name' => 'Regular File']);
        
        $response = $this->get(route('files.index', ['search' => 'Important']));
        $response->assertStatus(200);
    }

    /** @test */
    public function files_index_can_be_sorted()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.index', [
            'sort_by' => 'name',
            'sort_order' => 'asc'
        ]));
        $response->assertStatus(200);
        
        $response = $this->get(route('files.index', [
            'sort_by' => 'createdAt',
            'sort_order' => 'desc'
        ]));
        $response->assertStatus(200);
    }

    /** @test */
    public function file_model_calculates_file_size_correctly()
    {
        $content = 'test content';
        $base64 = base64_encode($content);
        
        $file = File::factory()->create([
            'base64' => 'data:application/pdf;base64,' . $base64
        ]);
        
        $expectedSize = strlen($content);
        $this->assertEquals($expectedSize, $file->file_size);
    }

    /** @test */
    public function file_model_validates_base64_correctly()
    {
        // Valid base64
        $validFile = File::factory()->create();
        $this->assertTrue($validFile->isValidBase64());
        
        // Invalid base64
        $invalidFile = File::factory()->make([
            'base64' => 'invalid-base64-content'
        ]);
        $invalidFile->save();
        $this->assertFalse($invalidFile->isValidBase64());
    }

    /** @test */
    public function file_model_returns_correct_mime_types()
    {
        $pdfFile = File::factory()->pdf()->create();
        $this->assertEquals('application/pdf', $pdfFile->mime_type);
        
        $excelFile = File::factory()->excel()->create();
        $this->assertEquals('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $excelFile->mime_type);
    }

    /** @test */
    public function file_model_returns_correct_extensions()
    {
        $pdfFile = File::factory()->pdf()->create();
        $this->assertEquals('pdf', $pdfFile->file_extension);
        
        $excelFile = File::factory()->excel()->create();
        $this->assertEquals('xlsx', $excelFile->file_extension);
    }

    /** @test */
    public function file_model_scopes_work_correctly()
    {
        // Limpiar todos los archivos antes de la prueba
        File::truncate();
        
        // Crear archivos de prueba
        File::factory()->pdf()->count(3)->create();
        File::factory()->excel()->count(2)->create();
        
        // Verificar que los scopes funcionan correctamente
        $this->assertEquals(3, File::pdf()->count());
        $this->assertEquals(2, File::excel()->count());
        
        // Probar scope por departamento
        $department = 'Test Department';
        File::factory()->department($department)->count(2)->create();
        $this->assertEquals(2, File::byDepartment($department)->count());
        
        // Probar scope por responsable
        $responsibleId = 'test-user-123';
        File::factory()->responsible($responsibleId)->count(1)->create();
        $this->assertEquals(1, File::byResponsible($responsibleId)->count());
    }

    /** @test */
    public function api_endpoints_work_correctly()
    {
        $this->actingAs($this->user);
        
        // Test API index
        $response = $this->getJson(route('api.files.index'));
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data',
                     'message'
                 ]);
        
        // Test API show
        $response = $this->getJson(route('api.files.show', $this->file->id));
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data',
                     'message'
                 ]);
        
        // Test API store
        $fileData = [
            'name' => 'API Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('api test content'),
            'type' => 'pdf',
            'department' => 'API',
            'responsible_id' => 'api-user',
        ];
        
        $response = $this->postJson(route('api.files.store'), $fileData);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'data',
                     'message'
                 ]);
        
        // Test API update
        $updateData = [
            'name' => 'Updated API File',
            'type' => 'excel',
            'department' => 'Updated API',
            'responsible_id' => 'updated-api-user',
        ];
        
        $response = $this->putJson(route('api.files.update', $this->file->id), $updateData);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data',
                     'message'
                 ]);
        
        // Test API delete
        $response = $this->deleteJson(route('api.files.destroy', $this->file->id));
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message'
                 ]);
    }
}