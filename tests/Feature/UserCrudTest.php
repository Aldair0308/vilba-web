<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserCrudTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'rol' => 'user'
        ]);
        
        $this->adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'rol' => 'admin'
        ]);
    }

    // Guest Access Tests
    public function test_guest_cannot_access_user_index()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_user_show()
    {
        $response = $this->get(route('users.show', $this->testUser));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_user_create()
    {
        $response = $this->get(route('users.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_user_edit()
    {
        $response = $this->get(route('users.edit', $this->testUser));
        $response->assertRedirect(route('login'));
    }

    // Authenticated User Access Tests
    public function test_authenticated_user_can_access_user_index()
    {
        $response = $this->actingAs($this->testUser)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas(['users', 'stats', 'roles']);
    }

    public function test_authenticated_user_can_access_user_show()
    {
        $response = $this->actingAs($this->testUser)->get(route('users.show', $this->testUser));
        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user');
        $response->assertSee($this->testUser->name);
        $response->assertSee($this->testUser->email);
    }

    public function test_authenticated_user_can_access_user_create()
    {
        $response = $this->actingAs($this->adminUser)->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    public function test_authenticated_user_can_access_user_edit()
    {
        $response = $this->actingAs($this->testUser)->get(route('users.edit', $this->testUser));
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user');
        $response->assertSee($this->testUser->name);
        $response->assertSee($this->testUser->email);
    }

    // CRUD Operations Tests
    public function test_authenticated_user_can_create_user()
    {
        $userData = [
            'name' => 'New Test User',
            'email' => 'newuser@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post(route('users.store'), $userData);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'New Test User',
            'email' => 'newuser@test.com',
            'rol' => 'user'
        ]);

        $user = User::where('email', 'newuser@test.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_authenticated_user_can_update_user()
    {
        $updateData = [
            'name' => 'Updated User Name',
            'email' => 'updated@test.com',
            'rol' => 'admin'
        ];

        $response = $this->actingAs($this->testUser)
                         ->put(route('users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('users.show', $this->testUser));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'name' => 'Updated User Name',
            'email' => 'updated@test.com',
            'rol' => 'admin'
        ]);
    }

    public function test_authenticated_user_can_update_user_password()
    {
        $updateData = [
            'name' => $this->testUser->name,
            'email' => $this->testUser->email,
            'rol' => $this->testUser->rol,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->actingAs($this->testUser)
                         ->put(route('users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('users.show', $this->testUser));
        $response->assertSessionHas('success');

        $updatedUser = User::find($this->testUser->id);
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    public function test_authenticated_user_can_delete_user()
    {
        $userToDelete = User::factory()->create([
            'email' => 'delete@test.com'
        ]);

        $response = $this->actingAs($this->adminUser)
                         ->delete(route('users.destroy', $userToDelete));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id
        ]);
    }

    // Validation Tests
    public function test_authenticated_user_cannot_create_user_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'rol' => 'invalid_role'
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post(route('users.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'rol']);
    }

    public function test_authenticated_user_cannot_update_user_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'rol' => 'invalid_role'
        ];

        $response = $this->actingAs($this->testUser)
                         ->put(route('users.update', $this->testUser), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'rol']);
    }

    public function test_authenticated_user_cannot_create_user_with_duplicate_email()
    {
        $userData = [
            'name' => 'Duplicate Email User',
            'email' => $this->testUser->email, // Using existing email
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post(route('users.store'), $userData);

        $response->assertSessionHasErrors(['email']);
    }

    // Search and Filter Tests
    public function test_authenticated_user_can_search_users()
    {
        $response = $this->actingAs($this->testUser)
                         ->get(route('users.index', ['search' => 'Test User']));

        $response->assertStatus(200);
        $response->assertSee('Test User');
    }

    public function test_authenticated_user_can_filter_users_by_role()
    {
        $response = $this->actingAs($this->testUser)
                         ->get(route('users.index', ['role' => 'admin']));

        $response->assertStatus(200);
        $response->assertSee('Admin User');
    }

    // API Tests
    public function test_api_user_index_returns_json()
    {
        $response = $this->actingAs($this->testUser)
                         ->getJson(route('api.users.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data',
                     'stats',
                     'roles',
                     'message'
                 ]);
    }

    public function test_api_user_show_returns_json()
    {
        $response = $this->actingAs($this->testUser)
                         ->getJson(route('api.users.show', $this->testUser));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'rol'
                     ],
                     'message'
                 ]);
    }

    public function test_api_user_store_creates_user()
    {
        $userData = [
            'name' => 'API Test User',
            'email' => 'apiuser@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'user'
        ];

        $response = $this->actingAs($this->adminUser)
                         ->postJson(route('api.users.store'), $userData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'rol'
                     ],
                     'message'
                 ]);

        $this->assertDatabaseHas('users', [
            'name' => 'API Test User',
            'email' => 'apiuser@test.com'
        ]);
    }

    public function test_api_user_update_modifies_user()
    {
        $updateData = [
            'name' => 'API Updated User',
            'email' => 'apiupdated@test.com',
            'rol' => 'admin'
        ];

        $response = $this->actingAs($this->testUser)
                         ->putJson(route('api.users.update', $this->testUser), $updateData);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'rol'
                     ]
                 ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'name' => 'API Updated User',
            'email' => 'apiupdated@test.com'
        ]);
    }

    public function test_api_user_destroy_deletes_user()
    {
        $userToDelete = User::factory()->create([
            'email' => 'apidelete@test.com'
        ]);

        $response = $this->actingAs($this->adminUser)
                         ->deleteJson(route('api.users.destroy', $userToDelete));

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Usuario eliminado exitosamente'
                 ]);

        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id
        ]);
    }

    // Search API Tests
    public function test_api_user_search_returns_results()
    {
        $response = $this->actingAs($this->testUser)
                         ->getJson(route('api.users.search', ['q' => 'Test']));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'email',
                             'rol'
                         ]
                     ],
                     'message'
                 ]);
    }

    // Stats API Tests
    public function test_api_user_stats_returns_statistics()
    {
        $response = $this->actingAs($this->testUser)
                         ->getJson(route('api.users.stats'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'total_users',
                         'admin_users',
                         'regular_users',
                         'users_by_role'
                     ],
                     'message'
                 ]);
    }

    // Model Tests
    public function test_user_model_has_correct_fillable_attributes()
    {
        $user = new User();
        $expected = ['name', 'email', 'password', 'photo', 'rol'];
        $this->assertEquals($expected, $user->getFillable());
    }

    public function test_user_model_has_correct_hidden_attributes()
    {
        $user = new User();
        $expected = ['password', 'remember_token'];
        $this->assertEquals($expected, $user->getHidden());
    }

    public function test_user_model_casts_email_verified_at_to_datetime()
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    public function test_user_can_be_filtered_by_role()
    {
        $adminUsers = User::where('rol', 'admin')->get();
        $regularUsers = User::where('rol', 'user')->get();

        $this->assertTrue($adminUsers->contains($this->adminUser));
        $this->assertTrue($regularUsers->contains($this->testUser));
    }

    public function test_user_scope_admins_returns_only_admins()
    {
        $admins = User::where('rol', 'admin')->get();
        $this->assertTrue($admins->contains($this->adminUser));
        $this->assertFalse($admins->contains($this->testUser));
    }

    public function test_user_scope_regular_users_returns_only_regular_users()
    {
        $regularUsers = User::where('rol', 'user')->get();
        $this->assertTrue($regularUsers->contains($this->testUser));
        $this->assertFalse($regularUsers->contains($this->adminUser));
    }

    public function test_user_is_admin_method_works_correctly()
    {
        $this->assertTrue($this->adminUser->is_admin);
        $this->assertFalse($this->testUser->is_admin);
    }

    public function test_user_photo_url_attribute_returns_correct_value()
    {
        $this->assertEquals('photo_user.jpg', $this->testUser->photo_url);
    }

    public function test_user_display_name_attribute_returns_name()
    {
        $this->assertEquals($this->testUser->name, $this->testUser->display_name);
    }
}