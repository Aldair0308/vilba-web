<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class ClientCrudSimpleTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        try {
            User::where('email', 'test@example.com')->delete();
            Client::where('email', 'like', '%@example.com')->delete();
        } catch (\Exception $e) {
            // Ignore cleanup errors
        }
        
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
        try {
            User::where('email', 'test@example.com')->delete();
            Client::where('email', 'like', '%@example.com')->delete();
        } catch (\Exception $e) {
            // Ignore cleanup errors
        }
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_client_index()
    {
        $response = $this->get(route('clients.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_clients_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('clients.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
    }

    /** @test */
    public function authenticated_user_can_view_create_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('clients.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.create');
    }

    /** @test */
    public function authenticated_user_can_create_client()
    {
        $this->actingAs($this->user);
        
        $clientData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ];
        
        $response = $this->post(route('clients.store'), $clientData);
        
        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('clients', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function authenticated_user_can_view_client_details()
    {
        $this->actingAs($this->user);
        
        $client = Client::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        $response = $this->get(route('clients.show', $client->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.show');
        $response->assertViewHas('client');
    }

    /** @test */
    public function authenticated_user_can_edit_client()
    {
        $this->actingAs($this->user);
        
        $client = Client::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        $response = $this->get(route('clients.edit', $client->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('clients.edit');
        $response->assertViewHas('client');
    }

    /** @test */
    public function authenticated_user_can_update_client()
    {
        $this->actingAs($this->user);
        
        $client = Client::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        $updateData = [
            'name' => 'Updated Client Name',
            'email' => 'updated@example.com',
            'phone' => '+52 55 9876 5432',
            'rfc' => 'WXYZ987654ABC',
            'address' => 'Updated Address 456, Updated City',
            'status' => 'inactive',
        ];
        
        $response = $this->put(route('clients.update', $client->id), $updateData);
        
        $response->assertRedirect(route('clients.show', $client->id));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('clients', [
            'name' => 'Updated Client Name',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_client()
    {
        $this->actingAs($this->user);
        
        $client = Client::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        $response = $this->delete(route('clients.destroy', $client->id));
        
        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    /** @test */
    public function client_creation_requires_valid_data()
    {
        $this->actingAs($this->user);
        
        // Test with empty data
        $response = $this->post(route('clients.store'), []);
        
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'rfc', 'address']);
    }

    /** @test */
    public function client_creation_requires_unique_email()
    {
        $this->actingAs($this->user);
        
        // Create first client
        Client::create([
            'name' => 'First Client',
            'email' => 'duplicate@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'ABCD123456EFG',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        // Try to create second client with same email
        $clientData = [
            'name' => 'Second Client',
            'email' => 'duplicate@example.com',
            'phone' => '+52 55 9876 5432',
            'rfc' => 'WXYZ987654ABC',
            'address' => 'Another Address 456, Another City',
            'status' => 'active',
        ];
        
        $response = $this->post(route('clients.store'), $clientData);
        
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function client_creation_requires_unique_rfc()
    {
        $this->actingAs($this->user);
        
        // Create first client
        Client::create([
            'name' => 'First Client',
            'email' => 'first@example.com',
            'phone' => '+52 55 1234 5678',
            'rfc' => 'DUPLICATE123456',
            'address' => 'Test Address 123, Test City',
            'status' => 'active',
        ]);
        
        // Try to create second client with same RFC
        $clientData = [
            'name' => 'Second Client',
            'email' => 'second@example.com',
            'phone' => '+52 55 9876 5432',
            'rfc' => 'DUPLICATE123456',
            'address' => 'Another Address 456, Another City',
            'status' => 'active',
        ];
        
        $response = $this->post(route('clients.store'), $clientData);
        
        $response->assertSessionHasErrors(['rfc']);
    }
}