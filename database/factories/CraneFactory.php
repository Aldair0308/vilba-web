<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Crane;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crane>
 */
class CraneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crane::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $marcas = ['Liebherr', 'Manitowoc', 'Terex', 'Grove', 'Tadano', 'Kato', 'Zoomlion', 'XCMG'];
        $tipos = [Crane::TYPE_TOWER, Crane::TYPE_MOBILE, Crane::TYPE_CRAWLER, Crane::TYPE_TRUCK];
        $categorias = ['Construcción', 'Industrial', 'Portuario', 'Minería', 'Petróleo'];
        
        $marca = $this->faker->randomElement($marcas);
        $modelo = $this->faker->bothify('??###');
        
        return [
            'marca' => $marca,
            'modelo' => strtoupper($modelo),
            'nombre' => $marca . ' ' . $modelo . ' - ' . $this->faker->word(),
            'capacidad' => $this->faker->randomElement([25, 50, 75, 100, 150, 200, 300, 500]),
            'tipo' => $this->faker->randomElement($tipos),
            'estado' => Crane::STATUS_ACTIVE,
            'category' => $this->faker->randomElement($categorias),
            'precios' => [],
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }

    /**
     * Indicate that the crane is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Crane::STATUS_INACTIVE,
        ]);
    }

    /**
     * Indicate that the crane is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Crane::STATUS_MAINTENANCE,
        ]);
    }

    /**
     * Indicate that the crane has pricing configured.
     */
    public function withPricing(int $zoneCount = 3): static
    {
        $zonas = ['Norte', 'Sur', 'Este', 'Oeste', 'Centro', 'Metropolitana', 'Industrial'];
        $selectedZones = $this->faker->randomElements($zonas, $zoneCount);
        
        $precios = [];
        foreach ($selectedZones as $zona) {
            $precios[] = [
                'zona' => $zona,
                'precio' => [
                    $this->faker->numberBetween(1000, 5000), // Precio por día
                    $this->faker->numberBetween(25000, 120000), // Precio por semana
                    $this->faker->numberBetween(80000, 400000), // Precio por mes
                ]
            ];
        }
        
        return $this->state(fn (array $attributes) => [
            'precios' => $precios,
        ]);
    }

    /**
     * Indicate that the crane has no pricing configured.
     */
    public function withoutPricing(): static
    {
        return $this->state(fn (array $attributes) => [
            'precios' => [],
        ]);
    }

    /**
     * Create a tower crane.
     */
    public function tower(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Crane::TYPE_TOWER,
            'capacidad' => $this->faker->randomElement([150, 200, 300, 500]),
        ]);
    }

    /**
     * Create a mobile crane.
     */
    public function mobile(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Crane::TYPE_MOBILE,
            'capacidad' => $this->faker->randomElement([25, 50, 75, 100]),
        ]);
    }

    /**
     * Create a crawler crane.
     */
    public function crawler(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Crane::TYPE_CRAWLER,
            'capacidad' => $this->faker->randomElement([100, 150, 200, 300]),
        ]);
    }

    /**
     * Create a truck crane.
     */
    public function truck(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Crane::TYPE_TRUCK,
            'capacidad' => $this->faker->randomElement([25, 50, 75]),
        ]);
    }
}