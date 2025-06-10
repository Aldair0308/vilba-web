<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private File $file;
    private string $samplePdfBase64;

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
        
        // Sample PDF base64 (minimal PDF structure)
        $this->samplePdfBase64 = base64_encode(
            "%PDF-1.4\n1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/MediaBox [0 0 612 792]\n>>\nendobj\nxref\n0 4\n0000000000 65535 f \n0000000009 00000 n \n0000000074 00000 n \n0000000120 00000 n \ntrailer\n<<\n/Size 4\n/Root 1 0 R\n>>\nstartxref\n179\n%%EOF"
        );
        
        // Create a test file
        $this->file = File::create([
            'name' => 'Test Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'Testing',
            'responsible_id' => $this->user->id,
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
        $response->assertViewHas('departments');
        $response->assertViewHas('stats');
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
    public function authenticated_user_can_create_file_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $fileData = [
            'name' => 'New Test Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'Sales',
            'responsible_id' => $this->user->id,
        ];
        
        $response = $this->post(route('files.store'), $fileData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('files', [
            'name' => $fileData['name'],
            'type' => 'pdf',
            'department' => 'Sales',
            'responsible_id' => $this->user->id,
        ]);
        
        $response->assertRedirect(route('files.index'));
    }

    /** @test */
    public function file_creation_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test required fields
        $response = $this->post(route('files.store'), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'base64', 'type', 'department', 'responsible_id']);
        
        // Test invalid type
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => $this->samplePdfBase64,
            'type' => 'invalid_type',
            'department' => 'Testing',
            'responsible_id' => $this->user->id,
        ]);
        $response->assertSessionHasErrors(['type']);
        
        // Test invalid base64
        $response = $this->post(route('files.store'), [
            'name' => 'Test File',
            'base64' => 'invalid_base64_content',
            'type' => 'pdf',
            'department' => 'Testing',
            'responsible_id' => $this->user->id,
        ]);
        $response->assertSessionHasErrors(['base64']);
    }

    /** @test */
    public function authenticated_user_can_view_file_details()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.show', $this->file));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.show');
        $response->assertViewHas('file');
        $response->assertSee($this->file->name);
        $response->assertSee($this->file->department);
    }

    /** @test */
    public function authenticated_user_can_view_edit_file_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.edit', $this->file));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.edit');
        $response->assertViewHas('file');
        $response->assertSee($this->file->name);
    }

    /** @test */
    public function authenticated_user_can_update_file_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'name' => 'Updated Test Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'Updated Department',
            'responsible_id' => $this->user->id,
        ];
        
        $response = $this->put(route('files.update', $this->file), $updateData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('files', [
            '_id' => $this->file->id,
            'name' => 'Updated Test Document',
            'department' => 'Updated Department',
        ]);
        
        $response->assertRedirect(route('files.show', $this->file));
    }

    /** @test */
    public function file_update_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test missing required fields
        $response = $this->put(route('files.update', $this->file), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'type', 'department', 'responsible_id']);
        
        // Test invalid type
        $response = $this->put(route('files.update', $this->file), [
            'name' => 'Updated File',
            'base64' => $this->samplePdfBase64,
            'type' => 'invalid_type',
            'department' => 'Testing',
            'responsible_id' => $this->user->id,
        ]);
        $response->assertSessionHasErrors(['type']);
    }

    /** @test */
    public function authenticated_user_can_delete_file()
    {
        $this->actingAs($this->user);
        
        $fileId = $this->file->id;
        
        $response = $this->delete(route('files.destroy', $this->file));
        
        $response->assertStatus(302);
        $this->assertDatabaseMissing('files', [
            '_id' => $fileId,
        ]);
        
        $response->assertRedirect(route('files.index'));
    }

    /** @test */
    public function authenticated_user_can_download_file()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.download', $this->file));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="' . $this->file->name . '.pdf"');
    }

    /** @test */
    public function authenticated_user_can_preview_file()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('files.preview', $this->file));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'inline');
    }

    /** @test */
    public function files_index_can_be_filtered_by_search()
    {
        $this->actingAs($this->user);
        
        // Create additional test files
        File::create([
            'name' => 'Another Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => $this->user->id,
        ]);
        
        $response = $this->get(route('files.index', ['search' => 'Another']));
        
        $response->assertStatus(200);
        $response->assertSee('Another Document');
        $response->assertDontSee('Test Document');
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
        
        // Create an Excel file
        File::create([
            'name' => 'Excel Document',
            'base64' => base64_encode('fake excel content'),
            'type' => 'excel',
            'department' => 'Finance',
            'responsible_id' => $this->user->id,
        ]);
        
        $response = $this->get(route('files.index', ['type' => 'excel']));
        
        $response->assertStatus(200);
        $response->assertSee('Excel Document');
        $response->assertDontSee('Test Document');
    }

    /** @test */
    public function files_index_can_be_filtered_by_department()
    {
        $this->actingAs($this->user);
        
        // Create file in different department
        File::create([
            'name' => 'HR Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'Human Resources',
            'responsible_id' => $this->user->id,
        ]);
        
        $response = $this->get(route('files.index', ['department' => 'Human Resources']));
        
        $response->assertStatus(200);
        $response->assertSee('HR Document');
        $response->assertDontSee('Test Document');
    }

    /** @test */
    public function files_index_can_be_sorted()
    {
        $this->actingAs($this->user);
        
        // Create additional file
        File::create([
            'name' => 'Alpha Document',
            'base64' => $this->samplePdfBase64,
            'type' => 'pdf',
            'department' => 'Testing',
            'responsible_id' => $this->user->id,
        ]);
        
        $response = $this->get(route('files.index', ['sort_by' => 'name', 'sort_order' => 'asc']));
        
        $response->assertStatus(200);
        // Alpha Document should appear before Test Document when sorted by name ascending
        $content = $response->getContent();
        $alphaPos = strpos($content, 'Alpha Document');
        $testPos = strpos($content, 'Test Document');
        $this->assertLessThan($testPos, $alphaPos);
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