<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Crane;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class CraneCrudTest extends TestCase
{
    use WithFaker;

    private User $user;
    private Crane $crane;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test database
        Config::set('database.connections.mongodb.database', 'vilba-test-db');
        
        // Clean up any existing test data
        Crane::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        // Create a test user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Create a test crane
        $this->crane = Crane::create([
            'marca' => 'Liebherr',
            'modelo' => 'LTM1200',
            'nombre' => 'Test Crane',
            'capacidad' => 200,
            'tipo' => 'móvil',
            'estado' => 'activo',
            'category' => 'Construcción',
            'precios' => [
                [
                    'zona' => 'Norte',
                    'precio' => [1500, 1800, 2000]
                ],
                [
                    'zona' => 'Sur',
                    'precio' => [1400, 1700, 1900]
                ]
            ]
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        Crane::truncate();
        User::where('email', 'like', '%@example.com')->delete();
        
        parent::tearDown();
    }

    /** @test */
    public function guest_cannot_access_crane_pages()
    {
        // Test index page
        $response = $this->get(route('cranes.index'));
        $response->assertRedirect(route('login'));

        // Test create page
        $response = $this->get(route('cranes.create'));
        $response->assertRedirect(route('login'));

        // Test show page
        $response = $this->get(route('cranes.show', $this->crane));
        $response->assertRedirect(route('login'));

        // Test edit page
        $response = $this->get(route('cranes.edit', $this->crane));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_cranes_index()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('cranes.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('cranes.index');
        $response->assertViewHas('cranes');
    }

    /** @test */
    public function authenticated_user_can_view_create_crane_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('cranes.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('cranes.create');
    }

    /** @test */
    public function authenticated_user_can_create_crane()
    {
        $this->actingAs($this->user);
        
        $craneData = [
            'marca' => 'Manitowoc',
            'modelo' => 'MLC300',
            'nombre' => 'Nueva Grúa',
            'capacidad' => 300,
            'tipo' => 'oruga',
            'estado' => 'activo',
            'category' => 'Industrial'
        ];
        
        $response = $this->post(route('cranes.store'), $craneData);
        
        $response->assertRedirect(route('cranes.index'));
        $response->assertSessionHas('success', 'Grúa creada exitosamente.');
        
        $this->assertDatabaseHas('cranes', [
            'marca' => 'Manitowoc',
            'modelo' => 'MLC300',
            'nombre' => 'Nueva Grúa',
            'capacidad' => 300,
            'tipo' => 'oruga'
        ]);
    }

    /** @test */
    public function authenticated_user_can_create_crane_with_pricing()
    {
        $this->actingAs($this->user);
        
        $craneData = [
            'marca' => 'Caterpillar',
            'modelo' => 'CT660',
            'nombre' => 'Grúa con Precios',
            'capacidad' => 150,
            'tipo' => 'camión',
            'estado' => 'activo',
            'category' => 'Construcción',
            'precios' => [
                [
                    'zona' => 'Centro',
                    'precio' => [1200, 1500, 1800]
                ],
                [
                    'zona' => 'Este',
                    'precio' => [1100, 1400, 1700]
                ]
            ]
        ];
        
        $response = $this->post(route('cranes.store'), $craneData);
        
        $response->assertRedirect(route('cranes.index'));
        $response->assertSessionHas('success', 'Grúa creada exitosamente.');
        
        $crane = Crane::where('nombre', 'Grúa con Precios')->first();
        $this->assertNotNull($crane);
        $this->assertCount(2, $crane->precios);
        $this->assertEquals('Centro', $crane->precios[0]['zona']);
        $this->assertEquals([1200, 1500, 1800], $crane->precios[0]['precio']);
    }

    /** @test */
    public function crane_creation_requires_valid_data()
    {
        $this->actingAs($this->user);
        
        // Test empty data
        $response = $this->post(route('cranes.store'), []);
        $response->assertSessionHasErrors(['marca', 'modelo', 'nombre', 'capacidad', 'tipo']);
        
        // Test invalid capacity
        $response = $this->post(route('cranes.store'), [
            'marca' => 'Test',
            'modelo' => 'Test',
            'nombre' => 'Test',
            'capacidad' => -10,
            'tipo' => 'móvil'
        ]);
        $response->assertSessionHasErrors(['capacidad']);
        
        // Test invalid tipo
        $response = $this->post(route('cranes.store'), [
            'marca' => 'Test',
            'modelo' => 'Test',
            'nombre' => 'Test',
            'capacidad' => 100,
            'tipo' => 'invalid_type'
        ]);
        $response->assertSessionHasErrors(['tipo']);
        
        // Test invalid estado
        $response = $this->post(route('cranes.store'), [
            'marca' => 'Test',
            'modelo' => 'Test',
            'nombre' => 'Test',
            'capacidad' => 100,
            'tipo' => 'móvil',
            'estado' => 'invalid_status'
        ]);
        $response->assertSessionHasErrors(['estado']);
    }

    /** @test */
    public function authenticated_user_can_view_crane_details()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('cranes.show', $this->crane));
        
        $response->assertStatus(200);
        $response->assertViewIs('cranes.show');
        $response->assertViewHas('crane', $this->crane);
        $response->assertSee($this->crane->marca);
        $response->assertSee($this->crane->modelo);
        $response->assertSee($this->crane->nombre);
    }

    /** @test */
    public function authenticated_user_can_view_edit_crane_form()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('cranes.edit', $this->crane));
        
        $response->assertStatus(200);
        $response->assertViewIs('cranes.edit');
        $response->assertViewHas('crane', $this->crane);
    }

    /** @test */
    public function authenticated_user_can_update_crane()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'marca' => 'Updated Brand',
            'modelo' => 'Updated Model',
            'nombre' => 'Updated Name',
            'capacidad' => 250,
            'tipo' => 'torre',
            'estado' => 'mantenimiento',
            'category' => 'Updated Category'
        ];
        
        $response = $this->put(route('cranes.update', $this->crane), $updateData);
        
        $response->assertRedirect(route('cranes.show', $this->crane));
        $response->assertSessionHas('success', 'Grúa actualizada exitosamente.');
        
        $this->crane->refresh();
        $this->assertEquals('Updated Brand', $this->crane->marca);
        $this->assertEquals('Updated Model', $this->crane->modelo);
        $this->assertEquals('Updated Name', $this->crane->nombre);
        $this->assertEquals(250, $this->crane->capacidad);
        $this->assertEquals('torre', $this->crane->tipo);
        $this->assertEquals('mantenimiento', $this->crane->estado);
    }

    /** @test */
    public function authenticated_user_can_update_crane_pricing()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'marca' => $this->crane->marca,
            'modelo' => $this->crane->modelo,
            'nombre' => $this->crane->nombre,
            'capacidad' => $this->crane->capacidad,
            'tipo' => $this->crane->tipo,
            'estado' => $this->crane->estado,
            'category' => $this->crane->category,
            'precios' => [
                [
                    'zona' => 'Oeste',
                    'precio' => [1600, 1900, 2200]
                ],
                [
                    'zona' => 'Centro',
                    'precio' => [1550, 1850, 2150]
                ],
                [
                    'zona' => 'Este',
                    'precio' => [1500, 1800, 2100]
                ]
            ]
        ];
        
        $response = $this->put(route('cranes.update', $this->crane), $updateData);
        
        $response->assertRedirect(route('cranes.show', $this->crane));
        $response->assertSessionHas('success', 'Grúa actualizada exitosamente.');
        
        $this->crane->refresh();
        $this->assertCount(3, $this->crane->precios);
        $this->assertEquals('Oeste', $this->crane->precios[0]['zona']);
        $this->assertEquals([1600, 1900, 2200], $this->crane->precios[0]['precio']);
    }

    /** @test */
    public function crane_update_requires_valid_data()
    {
        $this->actingAs($this->user);
        
        // Test invalid capacity
        $response = $this->put(route('cranes.update', $this->crane), [
            'marca' => 'Test',
            'modelo' => 'Test',
            'nombre' => 'Test',
            'capacidad' => 'invalid',
            'tipo' => 'móvil'
        ]);
        $response->assertSessionHasErrors(['capacidad']);
        
        // Test invalid tipo
        $response = $this->put(route('cranes.update', $this->crane), [
            'marca' => 'Test',
            'modelo' => 'Test',
            'nombre' => 'Test',
            'capacidad' => 100,
            'tipo' => 'invalid_type'
        ]);
        $response->assertSessionHasErrors(['tipo']);
    }

    /** @test */
    public function authenticated_user_can_delete_crane()
    {
        $this->actingAs($this->user);
        
        $craneId = $this->crane->id;
        
        $response = $this->delete(route('cranes.destroy', $this->crane));
        
        $response->assertRedirect(route('cranes.index'));
        $response->assertSessionHas('success', 'Grúa eliminada exitosamente.');
        
        $this->assertDatabaseMissing('cranes', [
            '_id' => $craneId
        ]);
    }

    /** @test */
    public function authenticated_user_can_activate_crane()
    {
        $this->actingAs($this->user);
        
        // First deactivate the crane
        $this->crane->update(['estado' => 'inactivo']);
        
        $response = $this->patch(route('cranes.activate', $this->crane));
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Grúa activada exitosamente.');
        
        $this->crane->refresh();
        $this->assertEquals('activo', $this->crane->estado);
    }

    /** @test */
    public function authenticated_user_can_deactivate_crane()
    {
        $this->actingAs($this->user);
        
        $response = $this->patch(route('cranes.deactivate', $this->crane));
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Grúa desactivada exitosamente.');
        
        $this->crane->refresh();
        $this->assertEquals('inactivo', $this->crane->estado);
    }

    /** @test */
    public function authenticated_user_can_set_crane_to_maintenance()
    {
        $this->actingAs($this->user);
        
        $response = $this->patch(route('cranes.maintenance', $this->crane));
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Grúa puesta en mantenimiento exitosamente.');
        
        $this->crane->refresh();
        $this->assertEquals('mantenimiento', $this->crane->estado);
    }

    /** @test */
    public function cranes_index_can_be_filtered_by_status()
    {
        $this->actingAs($this->user);
        
        // Create cranes with different statuses
        Crane::create([
            'marca' => 'Test1',
            'modelo' => 'Model1',
            'nombre' => 'Inactive Crane',
            'capacidad' => 100,
            'tipo' => 'móvil',
            'estado' => 'inactivo'
        ]);
        
        Crane::create([
            'marca' => 'Test2',
            'modelo' => 'Model2',
            'nombre' => 'Maintenance Crane',
            'capacidad' => 150,
            'tipo' => 'torre',
            'estado' => 'mantenimiento'
        ]);
        
        // Test filter by active status
        $response = $this->get(route('cranes.index', ['estado' => 'activo']));
        $response->assertStatus(200);
        $response->assertSee($this->crane->nombre);
        $response->assertDontSee('Inactive Crane');
        $response->assertDontSee('Maintenance Crane');
        
        // Test filter by inactive status
        $response = $this->get(route('cranes.index', ['estado' => 'inactivo']));
        $response->assertStatus(200);
        $response->assertSee('Inactive Crane');
        $response->assertDontSee($this->crane->nombre);
        $response->assertDontSee('Maintenance Crane');
        
        // Test filter by maintenance status
        $response = $this->get(route('cranes.index', ['estado' => 'mantenimiento']));
        $response->assertStatus(200);
        $response->assertSee('Maintenance Crane');
        $response->assertDontSee($this->crane->nombre);
        $response->assertDontSee('Inactive Crane');
    }

    /** @test */
    public function cranes_index_can_be_filtered_by_type()
    {
        $this->actingAs($this->user);
        
        // Create cranes with different types
        Crane::create([
            'marca' => 'Test1',
            'modelo' => 'Model1',
            'nombre' => 'Tower Crane',
            'capacidad' => 200,
            'tipo' => 'torre',
            'estado' => 'activo'
        ]);
        
        Crane::create([
            'marca' => 'Test2',
            'modelo' => 'Model2',
            'nombre' => 'Crawler Crane',
            'capacidad' => 300,
            'tipo' => 'oruga',
            'estado' => 'activo'
        ]);
        
        // Test filter by mobile type
        $response = $this->get(route('cranes.index', ['tipo' => 'móvil']));
        $response->assertStatus(200);
        $response->assertSee($this->crane->nombre);
        $response->assertDontSee('Tower Crane');
        $response->assertDontSee('Crawler Crane');
        
        // Test filter by tower type
        $response = $this->get(route('cranes.index', ['tipo' => 'torre']));
        $response->assertStatus(200);
        $response->assertSee('Tower Crane');
        $response->assertDontSee($this->crane->nombre);
        $response->assertDontSee('Crawler Crane');
    }

    /** @test */
    public function cranes_index_can_be_searched()
    {
        $this->actingAs($this->user);
        
        // Create additional cranes for search testing
        Crane::create([
            'marca' => 'Caterpillar',
            'modelo' => 'CT660',
            'nombre' => 'Searchable Crane',
            'capacidad' => 180,
            'tipo' => 'camión',
            'estado' => 'activo'
        ]);
        
        // Test search by brand
        $response = $this->get(route('cranes.index', ['search' => 'Liebherr']));
        $response->assertStatus(200);
        $response->assertSee($this->crane->nombre);
        $response->assertDontSee('Searchable Crane');
        
        // Test search by model
        $response = $this->get(route('cranes.index', ['search' => 'CT660']));
        $response->assertStatus(200);
        $response->assertSee('Searchable Crane');
        $response->assertDontSee($this->crane->nombre);
        
        // Test search by name
        $response = $this->get(route('cranes.index', ['search' => 'Test Crane']));
        $response->assertStatus(200);
        $response->assertSee($this->crane->nombre);
        $response->assertDontSee('Searchable Crane');
    }

    /** @test */
    public function cranes_index_can_be_sorted()
    {
        $this->actingAs($this->user);
        
        // Create additional cranes for sorting
        Crane::create([
            'marca' => 'AAA Brand',
            'modelo' => 'Model A',
            'nombre' => 'A Crane',
            'capacidad' => 50,
            'tipo' => 'móvil',
            'estado' => 'activo'
        ]);
        
        Crane::create([
            'marca' => 'ZZZ Brand',
            'modelo' => 'Model Z',
            'nombre' => 'Z Crane',
            'capacidad' => 500,
            'tipo' => 'torre',
            'estado' => 'activo'
        ]);
        
        // Test sort by capacity ascending
        $response = $this->get(route('cranes.index', ['sort' => 'capacidad', 'direction' => 'asc']));
        $response->assertStatus(200);
        
        // Test sort by capacity descending
        $response = $this->get(route('cranes.index', ['sort' => 'capacidad', 'direction' => 'desc']));
        $response->assertStatus(200);
        
        // Test sort by name
        $response = $this->get(route('cranes.index', ['sort' => 'nombre', 'direction' => 'asc']));
        $response->assertStatus(200);
    }

    /** @test */
    public function cranes_index_supports_pagination()
    {
        $this->actingAs($this->user);
        
        // Create multiple cranes to test pagination
        for ($i = 1; $i <= 25; $i++) {
            Crane::create([
                'marca' => "Brand {$i}",
                'modelo' => "Model {$i}",
                'nombre' => "Crane {$i}",
                'capacidad' => 100 + $i,
                'tipo' => 'móvil',
                'estado' => 'activo'
            ]);
        }
        
        $response = $this->get(route('cranes.index'));
        $response->assertStatus(200);
        $response->assertViewHas('cranes');
        
        // Test second page
        $response = $this->get(route('cranes.index', ['page' => 2]));
        $response->assertStatus(200);
    }

    /** @test */
    public function cranes_index_returns_json_when_requested()
    {
        $this->actingAs($this->user);
        
        $response = $this->getJson(route('cranes.index'));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'marca',
                    'modelo',
                    'nombre',
                    'capacidad',
                    'tipo',
                    'estado',
                    'category',
                    'precios'
                ]
            ],
            'current_page',
            'last_page',
            'per_page',
            'total'
        ]);
    }

    /** @test */
    public function crane_stats_endpoint_works()
    {
        $this->actingAs($this->user);
        
        // Create cranes with different statuses
        Crane::create([
            'marca' => 'Test1',
            'modelo' => 'Model1',
            'nombre' => 'Inactive Crane',
            'capacidad' => 100,
            'tipo' => 'móvil',
            'estado' => 'inactivo'
        ]);
        
        Crane::create([
            'marca' => 'Test2',
            'modelo' => 'Model2',
            'nombre' => 'Maintenance Crane',
            'capacidad' => 150,
            'tipo' => 'torre',
            'estado' => 'mantenimiento'
        ]);
        
        $response = $this->getJson(route('cranes.stats'));
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total',
            'activo',
            'inactivo',
            'mantenimiento',
            'by_type' => [
                'torre',
                'móvil',
                'oruga',
                'camión'
            ],
            'average_capacity'
        ]);
        
        $data = $response->json();
        $this->assertEquals(3, $data['total']); // Including the crane from setUp
        $this->assertEquals(1, $data['activo']);
        $this->assertEquals(1, $data['inactivo']);
        $this->assertEquals(1, $data['mantenimiento']);
    }
}