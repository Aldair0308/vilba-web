<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserCrudProfessionalTest extends TestCase
{
    use WithFaker;

    private User $adminUser;
    private User $testUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        User::where('email', 'like', '%@example.com')->delete();
        
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
    }

    protected function tearDown(): void
    {
        // Clean up test data
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_user_pages()
    {
        // Test index page
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('users.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('users.show', $this->testUser));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('users.edit', $this->testUser));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_users_index()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function authenticated_user_can_view_create_user_form()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function authenticated_user_can_create_user_with_valid_data()
    {
        $this->actingAs($this->adminUser);
        
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user',
            'status' => 'active'
        ];
        
        $response = $this->post(route('users.store'), $userData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'rol' => 'user',
            'status' => 'active'
        ]);
        
        $response->assertRedirect(route('users.index'));
    }

    /** @test */
    public function user_creation_fails_with_invalid_data()
    {
        $this->actingAs($this->adminUser);
        
        // Test required fields
        $response = $this->post(route('users.store'), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'password', 'rol']);
        
        // Test invalid email
        $response = $this->post(route('users.store'), [
            'name' => 'Test Name',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ]);
        $response->assertSessionHasErrors(['email']);
        
        // Test duplicate email
        $response = $this->post(route('users.store'), [
            'name' => 'Test Name',
            'email' => $this->testUser->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ]);
        $response->assertSessionHasErrors(['email']);
        
        // Test password confirmation mismatch
        $response = $this->post(route('users.store'), [
            'name' => 'Test Name',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
            'rol' => 'user'
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function authenticated_user_can_view_user_details()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.show', $this->testUser->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $this->testUser);
        $response->assertSee($this->testUser->name);
        $response->assertSee($this->testUser->email);
    }

    /** @test */
    public function authenticated_user_can_view_edit_user_form()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.edit', $this->testUser->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $this->testUser);
    }

    /** @test */
    public function authenticated_user_can_update_user_with_valid_data()
    {
        $this->actingAs($this->adminUser);
        
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'rol' => 'admin',
            'status' => 'inactive'
        ];
        
        $response = $this->put(route('users.update', $this->testUser->id), $updateData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'rol' => 'admin',
            'status' => 'inactive'
        ]);
        
        $response->assertRedirect(route('users.show', $this->testUser->id));
    }

    /** @test */
    public function user_update_fails_with_invalid_data()
    {
        $this->actingAs($this->adminUser);
        
        // Test required fields
        $response = $this->put(route('users.update', $this->testUser->id), [
            'name' => '',
            'email' => '',
            'rol' => ''
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'rol']);
        
        // Test duplicate email
        $response = $this->put(route('users.update', $this->testUser->id), [
            'name' => 'Test Name',
            'email' => $this->adminUser->email,
            'rol' => 'user'
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function authenticated_user_can_delete_user()
    {
        $this->actingAs($this->adminUser);
        
        $userToDelete = User::create([
            'name' => 'User to Delete',
            'email' => 'delete@example.com',
            'password' => Hash::make('password'),
            'rol' => 'user',
            'status' => 'active'
        ]);
        
        $response = $this->delete(route('users.destroy', $userToDelete->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id
        ]);
        
        $response->assertRedirect(route('users.index'));
    }

    /** @test */
    public function user_cannot_delete_themselves()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->delete(route('users.destroy', $this->adminUser->id));
        
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'No puedes eliminar tu propia cuenta');
        
        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id
        ]);
    }

    /** @test */
    public function authenticated_user_can_activate_user()
    {
        $this->actingAs($this->adminUser);
        
        // First deactivate the user
        $this->testUser->deactivate();
        
        $response = $this->post(route('users.activate', $this->testUser->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'status' => 'active'
        ]);
        
        $response->assertSessionHas('success', 'Usuario activado exitosamente');
    }

    /** @test */
    public function authenticated_user_can_deactivate_user()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->post(route('users.deactivate', $this->testUser->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'status' => 'inactive'
        ]);
        
        $response->assertSessionHas('success', 'Usuario desactivado exitosamente');
    }

    /** @test */
    public function user_cannot_deactivate_themselves()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->post(route('users.deactivate', $this->adminUser->id));
        
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'No puedes desactivar tu propia cuenta');
        
        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
            'status' => 'active'
        ]);
    }

    /** @test */
    public function can_search_users()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.search', ['q' => 'Test']));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Búsqueda completada exitosamente'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertStringContainsString('Test', $data[0]['name']);
    }

    /** @test */
    public function can_get_user_statistics()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.stats'));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Estadísticas obtenidas exitosamente'
        ]);
        
        $stats = $response->json('data');
        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('active', $stats);
        $this->assertArrayHasKey('inactive', $stats);
        $this->assertArrayHasKey('admins', $stats);
        $this->assertArrayHasKey('regular_users', $stats);
        $this->assertArrayHasKey('recent', $stats);
    }

    /** @test */
    public function can_filter_users_by_role()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.index', ['role' => 'admin']));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function can_filter_users_by_status()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.index', ['status' => 'active']));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function can_search_users_in_index()
    {
        $this->actingAs($this->adminUser);
        
        $response = $this->get(route('users.index', ['search' => 'Test']));
        
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function api_endpoints_return_json_responses()
    {
        $this->actingAs($this->adminUser);
        
        // Test index with JSON
        $response = $this->getJson(route('users.index'));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test show with JSON
        $response = $this->getJson(route('users.show', $this->testUser->id));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test store with JSON
        $userData = [
            'name' => 'API Test User',
            'email' => 'apitest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ];
        
        $response = $this->postJson(route('users.store'), $userData);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    /** @test */
    public function user_model_scopes_work_correctly()
    {
        // Test active scope
        $activeUsers = User::active()->get();
        $this->assertGreaterThan(0, $activeUsers->count());
        
        // Test admin scope
        $adminUsers = User::admins()->get();
        $this->assertGreaterThan(0, $adminUsers->count());
        
        // Test regular users scope
        $regularUsers = User::regularUsers()->get();
        $this->assertGreaterThan(0, $regularUsers->count());
    }

    /** @test */
    public function user_model_methods_work_correctly()
    {
        // Test isAdmin method
        $this->assertTrue($this->adminUser->isAdmin());
        $this->assertFalse($this->testUser->isAdmin());
        
        // Test isActive method
        $this->assertTrue($this->testUser->isActive());
        
        // Test activate/deactivate methods
        $this->testUser->deactivate();
        $this->assertTrue($this->testUser->isInactive());
        
        $this->testUser->activate();
        $this->assertTrue($this->testUser->isActive());
        
        // Test formatted attributes
        $this->assertNotEmpty($this->testUser->formatted_role);
        $this->assertNotEmpty($this->testUser->formatted_status);
    }
}