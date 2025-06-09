<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class FileCrudSimpleTest extends TestCase
{
    private User $user;

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
        $file = File::factory()->create();

        // Test index page
        $response = $this->get(route('files.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('files.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('files.show', $file));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('files.edit', $file));
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
    public function authenticated_user_can_create_file()
    {
        $this->actingAs($this->user);
        
        $fileData = [
            'name' => 'Test Document',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ];
        
        $response = $this->post(route('files.store'), $fileData);
        
        $response->assertRedirect(route('files.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('files', [
            'name' => 'Test Document',
            'type' => 'pdf',
            'department' => 'IT',
            'responsible_id' => 'user123',
        ]);
    }

    /** @test */
    public function authenticated_user_can_view_file_details()
    {
        $this->actingAs($this->user);
        
        $file = File::create([
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ]);
        
        $response = $this->get(route('files.show', $file->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.show');
        $response->assertViewHas('file');
        $response->assertSee('Test File');
        $response->assertSee('HR');
    }

    /** @test */
    public function authenticated_user_can_edit_file()
    {
        $this->actingAs($this->user);
        
        $file = File::create([
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ]);
        
        $response = $this->get(route('files.edit', $file->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('files.edit');
        $response->assertViewHas('file');
    }

    /** @test */
    public function authenticated_user_can_update_file()
    {
        $this->actingAs($this->user);
        
        $file = File::create([
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ]);
        
        $updateData = [
            'name' => 'Updated File Name',
            'type' => 'excel',
            'department' => 'Finance',
            'responsible_id' => 'user789',
        ];
        
        $response = $this->put(route('files.update', $file->id), $updateData);
        
        $response->assertRedirect(route('files.show', $file->id));
        $response->assertSessionHas('success');
        
        $file->refresh();
        $this->assertEquals('Updated File Name', $file->name);
        $this->assertEquals('excel', $file->type);
        $this->assertEquals('Finance', $file->department);
        $this->assertEquals('user789', $file->responsible_id);
    }

    /** @test */
    public function authenticated_user_can_delete_file()
    {
        $this->actingAs($this->user);
        
        $file = File::create([
            'name' => 'Test File',
            'base64' => 'data:application/pdf;base64,' . base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'HR',
            'responsible_id' => 'user456',
        ]);
        
        $response = $this->delete(route('files.destroy', $file->id));
        
        $response->assertRedirect(route('files.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('files', [
            '_id' => $file->id
        ]);
    }

    /** @test */
    public function test_file_index_route_works()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.index'));
        
        $response->assertStatus(200);
    }

    /** @test */
    public function test_file_create_route_works()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('files.create'));
        
        $response->assertStatus(200);
    }

    /** @test */
    public function test_file_show_route_works()
    {
        $this->actingAs($this->user);
        
        $file = File::factory()->create();
        
        $response = $this->get(route('files.show', $file->id));
        
        $response->assertStatus(200);
    }

    /** @test */
    public function test_file_edit_route_works()
    {
        $this->actingAs($this->user);
        
        $file = File::factory()->create();
        
        $response = $this->get(route('files.edit', $file->id));
        
        $response->assertStatus(200);
    }

    /** @test */
    public function test_file_download_route_works()
    {
        $this->actingAs($this->user);
        
        $file = File::factory()->small()->create();
        
        $response = $this->get(route('files.download', $file->id));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', $file->mime_type);
    }

    /** @test */
    public function test_file_stats_route_works()
    {
        $this->actingAs($this->user);
        
        File::factory()->count(3)->create();
        
        $response = $this->get(route('files.stats'));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total',
            'pdf',
            'excel',
            'total_size',
            'average_size'
        ]);
    }

    /** @test */
    public function test_file_search_route_works()
    {
        $this->actingAs($this->user);
        
        File::factory()->create(['name' => 'Searchable Document']);
        
        $response = $this->get(route('files.search', ['q' => 'Searchable']));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);
    }
}