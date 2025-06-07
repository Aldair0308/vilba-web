<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Crane;
use App\Models\User;

class CraneCrudSimpleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear un usuario para autenticación
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_crane_model_can_be_created()
    {
        $crane = Crane::factory()->create();
        
        $this->assertInstanceOf(Crane::class, $crane);
        $this->assertDatabaseHas('cranes', [
            'marca' => $crane->marca,
            'modelo' => $crane->modelo,
            'nombre' => $crane->nombre
        ]);
    }

    public function test_crane_factory_creates_valid_data()
    {
        $crane = Crane::factory()->create();
        
        $this->assertNotEmpty($crane->marca);
        $this->assertNotEmpty($crane->modelo);
        $this->assertNotEmpty($crane->nombre);
        $this->assertIsInt($crane->capacidad);
        $this->assertGreaterThan(0, $crane->capacidad);
        $this->assertContains($crane->tipo, ['torre', 'móvil', 'oruga', 'camión']);
        $this->assertContains($crane->estado, ['activo', 'inactivo', 'mantenimiento']);
    }

    public function test_crane_factory_with_pricing()
    {
        $crane = Crane::factory()->withPricing(2)->create();
        
        $this->assertIsArray($crane->precios);
        $this->assertCount(2, $crane->precios);
        
        foreach ($crane->precios as $precio) {
            $this->assertArrayHasKey('zona', $precio);
            $this->assertArrayHasKey('precio', $precio);
            $this->assertIsArray($precio['precio']);
            $this->assertNotEmpty($precio['zona']);
        }
    }

    public function test_crane_factory_without_pricing()
    {
        $crane = Crane::factory()->withoutPricing()->create();
        
        $this->assertIsArray($crane->precios);
        $this->assertEmpty($crane->precios);
    }

    public function test_crane_factory_different_types()
    {
        $towerCrane = Crane::factory()->tower()->create();
        $mobileCrane = Crane::factory()->mobile()->create();
        $crawlerCrane = Crane::factory()->crawler()->create();
        $truckCrane = Crane::factory()->truck()->create();
        
        $this->assertEquals('torre', $towerCrane->tipo);
        $this->assertEquals('móvil', $mobileCrane->tipo);
        $this->assertEquals('oruga', $crawlerCrane->tipo);
        $this->assertEquals('camión', $truckCrane->tipo);
    }

    public function test_crane_factory_different_states()
    {
        $activeCrane = Crane::factory()->create();
        $inactiveCrane = Crane::factory()->inactive()->create();
        $maintenanceCrane = Crane::factory()->maintenance()->create();
        
        $this->assertEquals('activo', $activeCrane->estado);
        $this->assertEquals('inactivo', $inactiveCrane->estado);
        $this->assertEquals('mantenimiento', $maintenanceCrane->estado);
    }

    public function test_crane_index_route_works()
    {
        $response = $this->get(route('cranes.index'));
        
        $response->assertStatus(200);
    }

    public function test_crane_create_route_works()
    {
        $response = $this->get(route('cranes.create'));
        
        $response->assertStatus(200);
    }

    public function test_crane_can_be_created_via_post()
    {
        $craneData = [
            'marca' => 'Liebherr',
            'modelo' => 'LTM1200',
            'nombre' => 'Grúa Principal',
            'capacidad' => 200,
            'tipo' => 'móvil',
            'estado' => 'activo',
            'category' => 'Construcción'
        ];
        
        $response = $this->post(route('cranes.store'), $craneData);
        
        $response->assertRedirect(route('cranes.index'));
        $this->assertDatabaseHas('cranes', [
            'marca' => 'Liebherr',
            'modelo' => 'LTM1200',
            'nombre' => 'Grúa Principal'
        ]);
    }

    public function test_crane_show_route_works()
    {
        $crane = Crane::factory()->create();
        
        $response = $this->get(route('cranes.show', $crane->id));
        
        $response->assertStatus(200);
    }

    public function test_crane_edit_route_works()
    {
        $crane = Crane::factory()->create();
        
        $response = $this->get(route('cranes.edit', $crane->id));
        
        $response->assertStatus(200);
    }

    public function test_crane_can_be_updated()
    {
        $crane = Crane::factory()->create();
        
        $updateData = [
            'marca' => 'Manitowoc',
            'modelo' => 'MLC300',
            'nombre' => 'Grúa Actualizada',
            'capacidad' => 300,
            'tipo' => 'oruga',
            'estado' => 'activo',
            'category' => 'Industrial'
        ];
        
        $response = $this->put(route('cranes.update', $crane->id), $updateData);
        
        $response->assertRedirect(route('cranes.show', $crane->id));
        $this->assertDatabaseHas('cranes', [
            'marca' => 'Manitowoc',
            'modelo' => 'MLC300',
            'nombre' => 'Grúa Actualizada'
        ]);
    }

    public function test_crane_can_be_deleted()
    {
        $crane = Crane::factory()->create();
        
        $response = $this->delete(route('cranes.destroy', $crane->id));
        
        $response->assertRedirect(route('cranes.index'));
        $this->assertDatabaseMissing('cranes', [
            '_id' => $crane->id
        ]);
    }
}