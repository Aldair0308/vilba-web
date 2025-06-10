<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Quote;
use App\Models\Client;
use App\Models\File;
use App\Models\Crane;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class QuoteCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private Quote $quote;
    private Client $client;
    private File $file;
    private Crane $crane;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        Quote::truncate();
        Client::truncate();
        File::truncate();
        Crane::truncate();
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
        
        // Create a test file
        $this->file = File::create([
            'name' => 'Test PDF File',
            'base64' => base64_encode('fake pdf content'),
            'type' => 'pdf',
            'department' => 'Test Department',
            'responsible_id' => (string) $this->user->_id,
        ]);
        
        // Create a test crane
        $this->crane = Crane::create([
            'marca' => 'Test Brand',
            'modelo' => 'Test Model',
            'nombre' => 'Test Crane',
            'capacidad' => '50 tons',
            'tipo' => 'torre',
            'estado' => 'activo',
            'category' => 'heavy',
            'precios' => [
                'zona_norte' => 1500,
                'zona_sur' => 1200
            ],
        ]);
        
        // Create a test quote
        $this->quote = Quote::create([
            'name' => 'Test Quote',
            'zone' => 'Norte',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'status' => 'pending',
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 10,
                    'precio' => 1500
                ]
            ],
            'iva' => 16,
            'total' => '17400',
            'responsibleId' => (string) $this->user->_id,
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        Quote::truncate();
        Client::truncate();
        File::truncate();
        Crane::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_quote_pages()
    {
        // Test index page
        $response = $this->get(route('quotes.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('quotes.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('quotes.show', $this->quote));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('quotes.edit', $this->quote));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_quotes_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('quotes.index');
        $response->assertViewHas('quotes');
    }

    /** @test */
    public function authenticated_user_can_view_create_quote_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('quotes.create');
        $response->assertViewHas(['clients', 'files', 'cranes', 'users']);
    }

    /** @test */
    public function authenticated_user_can_create_quote_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $quoteData = [
            'name' => 'New Test Quote',
            'zone' => 'Sur',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'status' => 'pending',
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 5,
                    'precio' => 1200
                ]
            ],
            'iva' => 16,
            'responsibleId' => (string) $this->user->_id,
        ];
        
        $response = $this->post(route('quotes.store'), $quoteData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('quotes', [
            'name' => $quoteData['name'],
            'zone' => $quoteData['zone'],
            'clientId' => $quoteData['clientId'],
            'status' => 'pending'
        ]);
        
        // Verify redirect to show page
        $createdQuote = Quote::where('name', $quoteData['name'])->first();
        $response->assertRedirect(route('quotes.show', $createdQuote->_id));
    }

    /** @test */
    public function quote_creation_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test required fields
        $response = $this->post(route('quotes.store'), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'zone', 'clientId', 'fileId', 'cranes', 'responsibleId']);
        
        // Test invalid client ID
        $response = $this->post(route('quotes.store'), [
            'name' => 'Test Quote',
            'zone' => 'Norte',
            'clientId' => 'invalid-id',
            'fileId' => (string) $this->file->_id,
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 5,
                    'precio' => 1200
                ]
            ],
            'responsibleId' => (string) $this->user->_id,
        ]);
        $response->assertSessionHasErrors(['clientId']);
        
        // Test invalid crane data
        $response = $this->post(route('quotes.store'), [
            'name' => 'Test Quote',
            'zone' => 'Norte',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'cranes' => [
                [
                    'crane' => 'invalid-crane-id',
                    'dias' => 5,
                    'precio' => 1200
                ]
            ],
            'responsibleId' => (string) $this->user->_id,
        ]);
        $response->assertSessionHasErrors(['cranes.0.crane']);
        
        // Test negative days
        $response = $this->post(route('quotes.store'), [
            'name' => 'Test Quote',
            'zone' => 'Norte',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => -1,
                    'precio' => 1200
                ]
            ],
            'responsibleId' => (string) $this->user->_id,
        ]);
        $response->assertSessionHasErrors(['cranes.0.dias']);
    }

    /** @test */
    public function authenticated_user_can_view_quote_details()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.show', $this->quote));
        
        $response->assertStatus(200);
        $response->assertViewIs('quotes.show');
        $response->assertViewHas('quote');
        $response->assertSee($this->quote->name);
        $response->assertSee($this->quote->zone);
    }

    /** @test */
    public function authenticated_user_can_view_edit_quote_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.edit', $this->quote));
        
        $response->assertStatus(200);
        $response->assertViewIs('quotes.edit');
        $response->assertViewHas(['quote', 'clients', 'files', 'cranes', 'users']);
    }

    /** @test */
    public function authenticated_user_can_update_quote_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'name' => 'Updated Quote Name',
            'zone' => 'Este',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'status' => 'approved',
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 15,
                    'precio' => 1800
                ]
            ],
            'iva' => 21,
            'responsibleId' => (string) $this->user->_id,
        ];
        
        $response = $this->put(route('quotes.update', $this->quote), $updateData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('quotes', [
            '_id' => $this->quote->_id,
            'name' => 'Updated Quote Name',
            'zone' => 'Este',
            'status' => 'approved'
        ]);
        
        $response->assertRedirect(route('quotes.show', $this->quote->_id));
    }

    /** @test */
    public function quote_update_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test invalid status
        $response = $this->put(route('quotes.update', $this->quote), [
            'name' => 'Updated Quote',
            'zone' => 'Norte',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'status' => 'invalid-status',
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 5,
                    'precio' => 1200
                ]
            ],
            'responsibleId' => (string) $this->user->_id,
        ]);
        $response->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function authenticated_user_can_delete_quote()
    {
        $this->actingAs($this->user);
        
        $response = $this->delete(route('quotes.destroy', $this->quote));
        
        $response->assertStatus(302);
        $response->assertRedirect(route('quotes.index'));
        $this->assertDatabaseMissing('quotes', [
            '_id' => $this->quote->_id
        ]);
    }

    /** @test */
    public function authenticated_user_can_change_quote_status()
    {
        $this->actingAs($this->user);
        
        $response = $this->patch(route('quotes.change-status', $this->quote), [
            'status' => 'approved'
        ]);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('quotes', [
            '_id' => $this->quote->_id,
            'status' => 'approved'
        ]);
    }

    /** @test */
    public function status_change_fails_with_invalid_status()
    {
        $this->actingAs($this->user);
        
        $response = $this->patch(route('quotes.change-status', $this->quote), [
            'status' => 'invalid-status'
        ]);
        
        $response->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function can_get_quotes_by_client()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.by-client', $this->client->_id));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);
        
        $responseData = $response->json();
        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(1, $responseData['data']); // Should have our test quote
    }

    /** @test */
    public function can_get_quote_statistics()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('quotes.stats'));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);
        
        $responseData = $response->json();
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('total', $responseData['data']);
        $this->assertArrayHasKey('pending', $responseData['data']);
        $this->assertArrayHasKey('approved', $responseData['data']);
        $this->assertArrayHasKey('active', $responseData['data']);
        $this->assertArrayHasKey('completed', $responseData['data']);
        $this->assertArrayHasKey('rejected', $responseData['data']);
    }

    /** @test */
    public function quote_calculates_total_automatically()
    {
        $this->actingAs($this->user);
        
        $quoteData = [
            'name' => 'Auto Calculate Quote',
            'zone' => 'Centro',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 10,
                    'precio' => 1000
                ]
            ],
            'iva' => 16,
            'responsibleId' => (string) $this->user->_id,
        ];
        
        $response = $this->post(route('quotes.store'), $quoteData);
        
        $response->assertStatus(302);
        
        $createdQuote = Quote::where('name', 'Auto Calculate Quote')->first();
        $this->assertNotNull($createdQuote);
        
        // Subtotal: 10 * 1000 = 10000
        // IVA: 10000 * 0.16 = 1600
        // Total: 10000 + 1600 = 11600
        $this->assertEquals('11600', $createdQuote->total);
    }

    /** @test */
    public function quote_model_calculates_subtotal_correctly()
    {
        $expectedSubtotal = 10 * 1500; // dias * precio
        $this->assertEquals($expectedSubtotal, $this->quote->subtotal);
    }

    /** @test */
    public function quote_model_calculates_iva_amount_correctly()
    {
        $subtotal = 10 * 1500; // 15000
        $expectedIva = $subtotal * (16 / 100); // 2400
        $this->assertEquals($expectedIva, $this->quote->iva_amount);
    }

    /** @test */
    public function quote_model_calculates_total_correctly()
    {
        $subtotal = 10 * 1500; // 15000
        $iva = $subtotal * (16 / 100); // 2400
        $expectedTotal = $subtotal + $iva; // 17400
        $this->assertEquals($expectedTotal, $this->quote->calculated_total);
    }

    /** @test */
    public function quote_validates_cranes_structure()
    {
        $this->assertTrue($this->quote->validateCranes());
        
        // Test invalid structure
        $invalidQuote = new Quote([
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    // Missing dias and precio
                ]
            ]
        ]);
        $this->assertFalse($invalidQuote->validateCranes());
        
        // Test negative values
        $invalidQuote2 = new Quote([
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => -1,
                    'precio' => 1000
                ]
            ]
        ]);
        $this->assertFalse($invalidQuote2->validateCranes());
    }

    /** @test */
    public function quote_can_get_crane_models()
    {
        $craneModels = $this->quote->getCraneModels();
        $this->assertCount(1, $craneModels);
        $this->assertEquals($this->crane->_id, $craneModels->first()->_id);
    }

    /** @test */
    public function quote_can_get_detailed_crane_information()
    {
        $craneDetails = $this->quote->crane_details;
        $this->assertIsArray($craneDetails);
        $this->assertCount(1, $craneDetails);
        
        $firstCrane = $craneDetails[0];
        $this->assertArrayHasKey('crane', $firstCrane);
        $this->assertArrayHasKey('dias', $firstCrane);
        $this->assertArrayHasKey('precio', $firstCrane);
        $this->assertArrayHasKey('subtotal', $firstCrane);
        $this->assertArrayHasKey('crane_info', $firstCrane);
        
        $this->assertEquals(10 * 1500, $firstCrane['subtotal']);
        $this->assertEquals('Test Crane', $firstCrane['crane_info']['nombre']);
    }

    /** @test */
    public function quote_scopes_work_correctly()
    {
        // Create quotes with different statuses
        Quote::factory()->approved()->create();
        Quote::factory()->rejected()->create();
        Quote::factory()->active()->create();
        Quote::factory()->completed()->create();
        
        $this->assertEquals(1, Quote::pending()->count()); // Our test quote
        $this->assertEquals(1, Quote::approved()->count());
        $this->assertEquals(1, Quote::rejected()->count());
        $this->assertEquals(1, Quote::active()->count());
        $this->assertEquals(1, Quote::completed()->count());
    }

    /** @test */
    public function api_endpoints_work_correctly()
    {
        $this->actingAs($this->user);
        
        // Test API index
        $response = $this->getJson(route('api.quotes.index'));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test API show
        $response = $this->getJson(route('api.quotes.show', $this->quote));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test API store
        $quoteData = [
            'name' => 'API Test Quote',
            'zone' => 'API Zone',
            'clientId' => (string) $this->client->_id,
            'fileId' => (string) $this->file->_id,
            'cranes' => [
                [
                    'crane' => (string) $this->crane->_id,
                    'dias' => 5,
                    'precio' => 1200
                ]
            ],
            'iva' => 16,
            'responsibleId' => (string) $this->user->_id,
        ];
        
        $response = $this->postJson(route('api.quotes.store'), $quoteData);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
        
        // Test API update
        $updateData = array_merge($quoteData, ['name' => 'Updated API Quote']);
        $response = $this->putJson(route('api.quotes.update', $this->quote), $updateData);
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
        
        // Test API delete
        $response = $this->deleteJson(route('api.quotes.destroy', $this->quote));
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}