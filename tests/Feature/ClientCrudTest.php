<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class ClientCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        Client::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        // Create a test user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Create a test client
        $this->client = Client::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        Client::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_client_pages()
    {
        // Test index page
        $response = $this->get(route('clients.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('clients.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('clients.show', $this->client));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('clients.edit', $this->client));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_clients_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('clients.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients');
    }

    /** @test */
    public function authenticated_user_can_view_create_client_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('clients.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.create');
    }

    /** @test */
    public function authenticated_user_can_create_client_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $clientData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'rfc' => 'XAXX010101000',
            'address' => $this->faker->address,
            'status' => 'active'
        ];
        
        $response = $this->post(route('clients.store'), $clientData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'email' => $clientData['email'],
            'rfc' => 'XAXX010101000', // RFC should be uppercase
            'status' => 'active'
        ]);
        
        $response->assertRedirect(route('clients.index'));
    }

    /** @test */
    public function client_creation_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test required fields
        $response = $this->post(route('clients.store'), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'rfc', 'address']);
        
        // Test invalid email
        $response = $this->post(route('clients.store'), [
            'name' => 'Test Name',
            'email' => 'invalid-email',
            'phone' => '123456789',
            'rfc' => 'XAXX010101000',
            'address' => 'Test Address'
        ]);
        $response->assertSessionHasErrors(['email']);
        
        // Test duplicate email
        $existingClient = Client::factory()->create();
        $response = $this->post(route('clients.store'), [
            'name' => 'Test Name',
            'email' => $existingClient->email,
            'phone' => '123456789',
            'rfc' => 'XAXX010101001',
            'address' => 'Test Address'
        ]);
        $response->assertSessionHasErrors(['email']);
        
        // Test duplicate RFC
        $response = $this->post(route('clients.store'), [
            'name' => 'Test Name',
            'email' => 'new@example.com',
            'phone' => '123456789',
            'rfc' => $existingClient->rfc,
            'address' => 'Test Address'
        ]);
        $response->assertSessionHasErrors(['rfc']);
    }

    /** @test */
    public function authenticated_user_can_view_client_details()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create();
        
        $response = $this->get(route('clients.show', $client->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.show');
        $response->assertViewHas('client', $client);
        $response->assertSee($client->name);
        $response->assertSee($client->email);
    }

    /** @test */
    public function authenticated_user_can_view_edit_client_form()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create();
        
        $response = $this->get(route('clients.edit', $client->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.edit');
        $response->assertViewHas('client', $client);
    }

    /** @test */
    public function authenticated_user_can_update_client_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create();
        
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+52 55 9876 5432',
            'rfc' => 'UPDT010101000',
            'address' => 'Updated Address',
            'status' => 'inactive'
        ];
        
        $response = $this->put(route('clients.update', $client->id), $updateData);
        
        $response->assertStatus(302);
        $response->assertRedirect(route('clients.show', $client->id));
        
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'rfc' => 'UPDT010101000',
            'status' => 'inactive'
        ]);
    }

    /** @test */
    public function client_update_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create();
        $otherClient = Client::factory()->create();
        
        // Test duplicate email (excluding current client)
        $response = $this->put(route('clients.update', $client->id), [
            'name' => 'Updated Name',
            'email' => $otherClient->email,
            'phone' => '123456789',
            'rfc' => 'UPDT010101000',
            'address' => 'Updated Address'
        ]);
        $response->assertSessionHasErrors(['email']);
        
        // Test duplicate RFC (excluding current client)
        $response = $this->put(route('clients.update', $client->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '123456789',
            'rfc' => $otherClient->rfc,
            'address' => 'Updated Address'
        ]);
        $response->assertSessionHasErrors(['rfc']);
    }

    /** @test */
    public function authenticated_user_can_delete_client_without_rent_history()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create(['rentHistory' => []]);
        
        $response = $this->delete(route('clients.destroy', $client->id));
        
        $response->assertStatus(302);
        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    /** @test */
    public function authenticated_user_cannot_delete_client_with_rent_history()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create([
            'rentHistory' => ['rent_id_1', 'rent_id_2']
        ]);
        
        $response = $this->delete(route('clients.destroy', $client->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }

    /** @test */
    public function authenticated_user_can_activate_client()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create(['status' => 'inactive']);
        
        $response = $this->patch(route('clients.activate', $client->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'status' => 'active'
        ]);
    }

    /** @test */
    public function authenticated_user_can_deactivate_client()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create(['status' => 'active']);
        
        $response = $this->patch(route('clients.deactivate', $client->id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'status' => 'inactive'
        ]);
    }

    /** @test */
    public function clients_index_supports_search_functionality()
    {
        $this->actingAs($this->user);
        
        $client1 = Client::factory()->create(['name' => 'John Doe']);
        $client2 = Client::factory()->create(['name' => 'Jane Smith']);
        
        $response = $this->get(route('clients.index', ['search' => 'John']));
        
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    /** @test */
    public function clients_index_supports_status_filtering()
    {
        $this->actingAs($this->user);
        
        $activeClient = Client::factory()->create(['status' => 'active']);
        $inactiveClient = Client::factory()->create(['status' => 'inactive']);
        
        $response = $this->get(route('clients.index', ['status' => 'active']));
        
        $response->assertStatus(200);
        $response->assertSee($activeClient->name);
        $response->assertDontSee($inactiveClient->name);
    }

    /** @test */
    public function clients_search_api_returns_json_results()
    {
        $this->actingAs($this->user);
        
        $client = Client::factory()->create(['name' => 'Searchable Client']);
        
        $response = $this->get(route('api.clients.search', ['q' => 'Searchable']));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Búsqueda completada'
        ]);
        
        $responseData = $response->json();
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals($client->name, $responseData['data'][0]['name']);
    }

    /** @test */
    public function clients_stats_api_returns_correct_statistics()
    {
        $this->actingAs($this->user);
        
        // Clear existing clients first
        Client::truncate();
        
        // Crear clientes de prueba
        Client::factory()->count(3)->create(['status' => 'active']);
        Client::factory()->count(2)->create(['status' => 'inactive']);
        Client::factory()->create([
            'status' => 'active',
            'rentHistory' => ['rent1', 'rent2']
        ]);
        
        $response = $this->get(route('api.clients.stats'));
        
        $response->assertStatus(200);
        // Get actual counts from database
        $totalClients = Client::count();
        $activeClients = Client::active()->count();
        $inactiveClients = Client::inactive()->count();
        $withRents = Client::whereNotNull('rentHistory')
                          ->where('rentHistory', '!=', [])
                          ->count();
        
        $response->assertJson([
            'success' => true,
            'data' => [
                'total' => $totalClients,
                'active' => $activeClients,
                'inactive' => $inactiveClients,
                'with_rents' => $withRents
            ]
        ]);
        
        // Verify the expected counts based on what we created
          $this->assertEquals(6, $totalClients);
          $this->assertEquals(4, $activeClients);
          $this->assertEquals(2, $inactiveClients);
          // We expect at least 1 client with rent history
          $this->assertGreaterThanOrEqual(1, $withRents);
    }

    /** @test */
    public function client_model_has_correct_fillable_attributes()
    {
        $client = new Client();
        
        $expectedFillable = [
            'name', 'email', 'phone', 'rfc', 'address', 'rentHistory', 'status'
        ];
        
        $this->assertEquals($expectedFillable, $client->getFillable());
    }

    /** @test */
    public function client_model_casts_dates_correctly()
    {
        $client = Client::factory()->create();
        
        $this->assertInstanceOf(\Carbon\Carbon::class, $client->createdAt);
        $this->assertInstanceOf(\Carbon\Carbon::class, $client->updatedAt);
    }

    /** @test */
    public function client_model_scopes_work_correctly()
    {
        // Clear existing clients first
        Client::truncate();
        
        Client::factory()->count(3)->create(['status' => 'active']);
        Client::factory()->count(2)->create(['status' => 'inactive']);
        
        $activeClients = Client::active()->get();
        $inactiveClients = Client::inactive()->get();
        
        $this->assertCount(3, $activeClients);
        $this->assertCount(2, $inactiveClients);
    }

    /** @test */
    public function client_model_methods_work_correctly()
    {
        // Clear existing clients first
        Client::truncate();
        
        $client = Client::factory()->create(['status' => 'inactive']);
        
        // Test activate method
        $client->activate();
        $this->assertEquals('active', $client->fresh()->status);
        
        // Test deactivate method
        $client->deactivate();
        $this->assertEquals('inactive', $client->fresh()->status);
        
        // Test rent count
        $client->update(['rentHistory' => ['rent1', 'rent2', 'rent3']]);
        $this->assertEquals(3, $client->fresh()->rent_count);
    }

    /** @test */
    public function rfc_is_automatically_converted_to_uppercase()
    {
        $this->actingAs($this->user);
        
        $clientData = [
            'name' => 'Test Client',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'rfc' => 'xaxx010101000', // lowercase
            'address' => 'Test Address'
        ];
        
        $response = $this->post(route('clients.store'), $clientData);
        
        $this->assertDatabaseHas('clients', [
            'email' => 'test@example.com',
            'rfc' => 'XAXX010101000' // should be uppercase
        ]);
    }

    /** @test */
    public function client_json_responses_work_correctly()
    {
        $this->actingAs($this->user);
        
        // Test JSON index
        $client = Client::factory()->create();
        $response = $this->getJson(route('clients.index'));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test JSON store
        $clientData = [
            'name' => 'JSON Test Client',
            'email' => 'json@example.com',
            'phone' => '123456789',
            'rfc' => 'JSON010101000',
            'address' => 'JSON Test Address'
        ];
        
        $response = $this->postJson(route('clients.store'), $clientData);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
        
        // Test JSON show
        $response = $this->getJson(route('clients.show', $client->id));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}