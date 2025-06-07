<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Crane;
use Illuminate\Support\Facades\DB;

class CranePriceZoneTest extends TestCase
{
    protected $user;
    protected $crane;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Limpiar colecciones existentes
        try {
            User::truncate();
            Crane::truncate();
        } catch (\Exception $e) {
            // Ignorar errores si las colecciones no existen
        }
        
        // Crear usuario de prueba
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Crear grúa de prueba
        $this->crane = Crane::create([
            'marca' => 'Caterpillar',
            'modelo' => 'CAT320',
            'nombre' => 'Grúa Test',
            'capacidad' => 20.5,
            'tipo' => 'móvil',
            'estado' => Crane::STATUS_ACTIVE,
            'categoria' => 'construcción',
            'precios' => []
        ]);
    }

    protected function tearDown(): void
    {
        // Limpiar datos después de cada test
        try {
            if ($this->crane) {
                $this->crane->delete();
            }
            if ($this->user) {
                $this->user->delete();
            }
        } catch (\Exception $e) {
            // Ignorar errores de limpieza
        }
        
        parent::tearDown();
    }

    /** @test */
    public function authenticated_user_can_add_price_zone_to_crane()
    {
        $this->actingAs($this->user);
        
        $zoneData = [
            'zona' => 'Zona Norte',
            'precio' => [100, 150, 200]
        ];
        
        $response = $this->post(route('cranes.price-zones.store', $this->crane->id), $zoneData);
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Zona de precios agregada exitosamente.');
        
        // Verificar que la zona fue agregada
        $this->crane->refresh();
        $this->assertNotEmpty($this->crane->precios);
        $this->assertEquals('Zona Norte', $this->crane->precios[0]['zona']);
        $this->assertEquals([100, 150, 200], $this->crane->precios[0]['precio']);
    }

    /** @test */
    public function authenticated_user_can_add_price_zone_via_api()
    {
        $this->actingAs($this->user);
        
        $zoneData = [
            'zona' => 'Zona Sur',
            'precio' => [80, 120, 160]
        ];
        
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), $zoneData);
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Zona de precios agregada exitosamente'
        ]);
        
        // Verificar que la zona fue agregada
        $this->crane->refresh();
        $this->assertNotEmpty($this->crane->precios);
        $this->assertEquals('Zona Sur', $this->crane->precios[0]['zona']);
        $this->assertEquals([80, 120, 160], $this->crane->precios[0]['precio']);
    }

    /** @test */
    public function cannot_add_duplicate_price_zone()
    {
        $this->actingAs($this->user);
        
        // Agregar primera zona
        $this->crane->addPriceForZone('Zona Centro', [90, 130, 170]);
        
        $zoneData = [
            'zona' => 'Zona Centro',
            'precio' => [100, 140, 180]
        ];
        
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), $zoneData);
        
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'La zona ya existe para esta grúa'
        ]);
    }

    /** @test */
    public function authenticated_user_can_update_price_zone()
    {
        $this->actingAs($this->user);
        
        // Agregar zona inicial
        $this->crane->addPriceForZone('Zona Este', [70, 110, 150]);
        
        $updateData = [
            'precio' => [85, 125, 165]
        ];
        
        $response = $this->putJson(route('api.cranes.price-zones.update', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Este'
        ]), $updateData);
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Zona de precios actualizada exitosamente'
        ]);
        
        // Verificar que la zona fue actualizada
        $this->crane->refresh();
        $this->assertEquals([85, 125, 165], $this->crane->precios[0]['precio']);
    }

    /** @test */
    public function cannot_update_nonexistent_price_zone()
    {
        $this->actingAs($this->user);
        
        $updateData = [
            'precio' => [85, 125, 165]
        ];
        
        $response = $this->putJson(route('api.cranes.price-zones.update', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Inexistente'
        ]), $updateData);
        
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'La zona no existe para esta grúa'
        ]);
    }

    /** @test */
    public function authenticated_user_can_remove_price_zone()
    {
        $this->actingAs($this->user);
        
        // Agregar dos zonas
        $this->crane->addPriceForZone('Zona Oeste', [60, 100, 140]);
        $this->crane->addPriceForZone('Zona Centro', [90, 130, 170]);
        
        $response = $this->deleteJson(route('api.cranes.price-zones.destroy', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Oeste'
        ]));
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Zona de precios eliminada exitosamente'
        ]);
        
        // Verificar que solo queda una zona
        $this->crane->refresh();
        $this->assertCount(1, $this->crane->precios);
        $this->assertEquals('Zona Centro', $this->crane->precios[0]['zona']);
    }

    /** @test */
    public function cannot_remove_nonexistent_price_zone()
    {
        $this->actingAs($this->user);
        
        $response = $this->deleteJson(route('api.cranes.price-zones.destroy', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Inexistente'
        ]));
        
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'La zona no existe para esta grúa'
        ]);
    }

    /** @test */
    public function price_zone_validation_works_correctly()
    {
        $this->actingAs($this->user);
        
        // Test zona requerida
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), [
            'precio' => [100, 150, 200]
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['zona']);
        
        // Test precios requeridos
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), [
            'zona' => 'Zona Test'
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
        
        // Test precios deben ser números
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), [
            'zona' => 'Zona Test',
            'precio' => ['abc', 'def']
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio.0', 'precio.1']);
        
        // Test precios no pueden ser negativos
        $response = $this->postJson(route('api.cranes.price-zones.store', $this->crane->id), [
            'zona' => 'Zona Test',
            'precio' => [-10, 150]
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio.0']);
    }

    /** @test */
    public function unauthenticated_user_cannot_manage_price_zones()
    {
        $zoneData = [
            'zona' => 'Zona Test',
            'precio' => [100, 150, 200]
        ];
        
        // Test crear zona sin autenticación
        $response = $this->post(route('cranes.price-zones.store', $this->crane->id), $zoneData);
        $response->assertRedirect(route('login'));
        
        // Test actualizar zona sin autenticación
        $response = $this->put(route('cranes.price-zones.update', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Test'
        ]), ['precio' => [120, 160, 200]]);
        $response->assertRedirect(route('login'));
        
        // Test eliminar zona sin autenticación
        $response = $this->delete(route('cranes.price-zones.destroy', [
            'crane' => $this->crane->id,
            'zona' => 'Zona Test'
        ]));
        $response->assertRedirect(route('login'));
    }
}