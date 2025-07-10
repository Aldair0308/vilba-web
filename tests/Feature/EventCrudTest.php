<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Client;
use App\Models\Crane;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EventCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private Event $event;
    private Client $client;
    private Crane $crane;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        Event::truncate();
        Client::truncate();
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
        
        // Create a test crane
        $this->crane = Crane::create([
            'nombre' => 'Test Crane',
            'modelo' => 'TC-100',
            'capacidad' => '50 tons',
            'altura_maxima' => '60m',
            'radio_maximo' => '45m',
            'año' => 2020,
            'numero_serie' => 'TC100-2020-001',
            'estado' => 'disponible',
            'ubicacion_actual' => 'Warehouse A',
            'precio_base_dia' => 5000.00,
            'zonas_precio' => [],
            'historial_mantenimiento' => [],
            'documentos' => []
        ]);
        
        // Create a test event
        $this->event = Event::create([
            'title' => 'Test Event',
            'description' => 'This is a test event',
            'type' => 'renta',
            'status' => 'programado',
            'priority' => 'media',
            'start_date' => Carbon::now()->addDay(),
            'end_date' => Carbon::now()->addDays(2),
            'all_day' => false,
            'location' => 'Test Location',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id,
            'notes' => 'Test notes',
            'color' => '#007bff',
            'reminder_minutes' => 30,
            'attendees' => [],
            'attachments' => []
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        Event::truncate();
        Client::truncate();
        Crane::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_event_pages()
    {
        // Test index page
        $response = $this->get(route('events.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('events.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('events.show', $this->event));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('events.edit', $this->event));
        $response->assertRedirect(route('login'));
        
        // Test calendar page
        $response = $this->get(route('events.calendar'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_events_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('events.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas('events');
    }

    /** @test */
    public function authenticated_user_can_view_events_calendar()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('events.calendar'));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.calendar');
        $response->assertViewHas(['clients', 'users']);
    }

    /** @test */
    public function authenticated_user_can_view_create_event_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('events.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.create');
        $response->assertViewHas(['clients', 'cranes', 'users']);
    }

    /** @test */
    public function authenticated_user_can_create_event_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $eventData = [
            'title' => 'New Test Event',
            'description' => 'Description for new event',
            'type' => 'mantenimiento',
            'status' => 'programado',
            'priority' => 'alta',
            'start_date' => Carbon::now()->addDays(3)->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDays(4)->format('Y-m-d\TH:i'),
            'all_day' => '0',
            'location' => 'New Location',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id,
            'notes' => 'New event notes',
            'color' => '#28a745',
            'reminder_minutes' => '60'
        ];
        
        $response = $this->post(route('events.store'), $eventData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('events', [
            'title' => $eventData['title'],
            'type' => $eventData['type'],
            'status' => $eventData['status'],
            'priority' => $eventData['priority'],
            'location' => $eventData['location']
        ]);
        
        $response->assertRedirect(route('events.index'));
    }

    /** @test */
    public function event_creation_fails_with_invalid_data()
    {
        $this->actingAs($this->user);
        
        // Test required fields
        $response = $this->post(route('events.store'), []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'type', 'priority', 'start_date']);
        
        // Test invalid type
        $response = $this->post(route('events.store'), [
            'title' => 'Test Event',
            'type' => 'invalid_type',
            'priority' => 'media',
            'start_date' => Carbon::now()->addDay()->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDays(2)->format('Y-m-d\TH:i')
        ]);
        $response->assertSessionHasErrors(['type']);
        
        // Test invalid priority
        $response = $this->post(route('events.store'), [
            'title' => 'Test Event',
            'type' => 'renta',
            'priority' => 'invalid_priority',
            'start_date' => Carbon::now()->addDay()->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDays(2)->format('Y-m-d\TH:i')
        ]);
        $response->assertSessionHasErrors(['priority']);
        
        // Test end date before start date
        $response = $this->post(route('events.store'), [
            'title' => 'Test Event',
            'type' => 'renta',
            'priority' => 'media',
            'start_date' => Carbon::now()->addDays(2)->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDay()->format('Y-m-d\TH:i')
        ]);
        $response->assertSessionHasErrors(['end_date']);
    }

    /** @test */
    public function authenticated_user_can_view_event_details()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.show', $event->_id));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertViewHas('event', $event);
        $response->assertSee($event->title);
        $response->assertSee($event->description);
    }

    /** @test */
    public function authenticated_user_can_view_edit_event_form()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.edit', $event->_id));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
        $response->assertViewHas('event', $event);
        $response->assertViewHas(['clients', 'cranes', 'users']);
    }

    /** @test */
    public function authenticated_user_can_update_event_with_valid_data()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $updateData = [
            'title' => 'Updated Event Title',
            'description' => 'Updated description',
            'type' => 'reunion',
            'status' => 'en_progreso',
            'priority' => 'urgente',
            'start_date' => Carbon::now()->addDays(5)->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDays(6)->format('Y-m-d\TH:i'),
            'all_day' => '1',
            'location' => 'Updated Location',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id,
            'notes' => 'Updated notes',
            'color' => '#dc3545',
            'reminder_minutes' => '120'
        ];
        
        $response = $this->put(route('events.update', $event->_id), $updateData);
        
        $response->assertStatus(302);
        $response->assertRedirect(route('events.show', $event->_id));
        
        $this->assertDatabaseHas('events', [
            '_id' => $event->_id,
            'title' => 'Updated Event Title',
            'type' => 'reunion',
            'status' => 'en_progreso',
            'priority' => 'urgente',
            'location' => 'Updated Location'
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_event()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->delete(route('events.destroy', $event->_id));
        
        $response->assertStatus(302);
        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseMissing('events', ['_id' => $event->_id]);
    }

    /** @test */
    public function authenticated_user_can_mark_event_as_in_progress()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'status' => 'programado',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->patch(route('events.start', $event->_id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('events', [
            '_id' => $event->_id,
            'status' => 'en_progreso'
        ]);
    }

    /** @test */
    public function authenticated_user_can_mark_event_as_completed()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'status' => 'en_progreso',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->patch(route('events.complete', $event->_id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('events', [
            '_id' => $event->_id,
            'status' => 'completado'
        ]);
    }

    /** @test */
    public function authenticated_user_can_mark_event_as_cancelled()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'status' => 'programado',
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->patch(route('events.cancel', $event->_id));
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('events', [
            '_id' => $event->_id,
            'status' => 'cancelado'
        ]);
    }

    /** @test */
    public function events_index_supports_search_functionality()
    {
        $this->actingAs($this->user);
        
        $event1 = Event::factory()->create([
            'title' => 'Important Meeting',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        $event2 = Event::factory()->create([
            'title' => 'Crane Maintenance',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.index', ['search' => 'Meeting']));
        
        $response->assertStatus(200);
        $response->assertSee('Important Meeting');
        $response->assertDontSee('Crane Maintenance');
    }

    /** @test */
    public function events_index_supports_status_filtering()
    {
        $this->actingAs($this->user);
        
        $scheduledEvent = Event::factory()->create([
            'status' => 'programado',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        $completedEvent = Event::factory()->create([
            'status' => 'completado',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.index', ['status' => 'programado']));
        
        $response->assertStatus(200);
        $response->assertSee($scheduledEvent->title);
        $response->assertDontSee($completedEvent->title);
    }

    /** @test */
    public function events_index_supports_type_filtering()
    {
        $this->actingAs($this->user);
        
        $rentalEvent = Event::factory()->create([
            'type' => 'renta',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        $maintenanceEvent = Event::factory()->create([
            'type' => 'mantenimiento',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.index', ['type' => 'renta']));
        
        $response->assertStatus(200);
        $response->assertSee($rentalEvent->title);
        $response->assertDontSee($maintenanceEvent->title);
    }

    /** @test */
    public function events_calendar_data_returns_json_events()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'title' => 'Calendar Event',
            'start_date' => Carbon::now()->addDay(),
            'end_date' => Carbon::now()->addDays(2),
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.calendar-data', [
            'start' => Carbon::now()->format('Y-m-d'),
            'end' => Carbon::now()->addDays(7)->format('Y-m-d')
        ]));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'start',
                'end',
                'allDay',
                'backgroundColor',
                'borderColor',
                'textColor',
                'type',
                'status',
                'priority'
            ]
        ]);
    }

    /** @test */
    public function events_search_api_returns_json_results()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'title' => 'Searchable Event',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('api.events.search', ['q' => 'Searchable']));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Búsqueda completada'
        ]);
        
        $responseData = $response->json();
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals($event->title, $responseData['data'][0]['title']);
    }

    /** @test */
    public function events_stats_api_returns_correct_statistics()
    {
        $this->actingAs($this->user);
        
        // Clear existing events first
        Event::truncate();
        
        // Create test events
        Event::factory()->count(3)->create([
            'status' => 'programado',
            'type' => 'renta',
            'priority' => 'media',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        Event::factory()->count(2)->create([
            'status' => 'completado',
            'type' => 'mantenimiento',
            'priority' => 'alta',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        Event::factory()->create([
            'status' => 'cancelado',
            'type' => 'reunion',
            'priority' => 'urgente',
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('api.events.stats'));
        
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'success',
            'data' => [
                'total_events',
                'by_status' => [
                    'programado',
                    'en_progreso',
                    'completado',
                    'cancelado'
                ],
                'by_type' => [
                    'renta',
                    'mantenimiento',
                    'reunion',
                    'entrega',
                    'recogida',
                    'otro'
                ],
                'by_priority' => [
                    'baja',
                    'media',
                    'alta',
                    'urgente'
                ]
            ]
        ]);
        
        $responseData = $response->json();
        $this->assertEquals(6, $responseData['data']['total_events']);
        $this->assertEquals(3, $responseData['data']['by_status']['programado']);
        $this->assertEquals(2, $responseData['data']['by_status']['completado']);
        $this->assertEquals(1, $responseData['data']['by_status']['cancelado']);
    }

    /** @test */
    public function event_cannot_be_updated_with_invalid_dates()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'user_id' => $this->user->_id
        ]);
        
        // Test past start date
        $response = $this->put(route('events.update', $event->_id), [
            'title' => 'Updated Event',
            'type' => 'renta',
            'priority' => 'media',
            'start_date' => Carbon::now()->subDay()->format('Y-m-d\TH:i'),
            'end_date' => Carbon::now()->addDay()->format('Y-m-d\TH:i')
        ]);
        $response->assertSessionHasErrors(['start_date']);
    }

    /** @test */
    public function event_json_response_includes_relationships()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'client_id' => $this->client->_id,
            'crane_id' => $this->crane->_id,
            'user_id' => $this->user->_id
        ]);
        
        $response = $this->get(route('events.show', $event->_id), [
            'Accept' => 'application/json'
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'type',
            'status',
            'priority',
            'start_date',
            'end_date',
            'client' => [
                'id',
                'name',
                'email'
            ],
            'crane' => [
                'id',
                'nombre',
                'modelo'
            ],
            'user' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }
}