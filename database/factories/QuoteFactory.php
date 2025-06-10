<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quote;
use App\Models\Client;
use App\Models\File;
use App\Models\Crane;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener IDs existentes o crear si no existen
        $clients = Client::all();
        $client = $clients->isNotEmpty() ? $clients->random() : Client::factory()->create();
        
        $files = File::all();
        $file = $files->isNotEmpty() ? $files->random() : File::factory()->create();
        
        $users = User::all();
        $user = $users->isNotEmpty() ? $users->random() : User::factory()->create();
        
        // Obtener grúas activas o crear algunas si no existen
        $cranes = Crane::where('estado', Crane::STATUS_ACTIVE)->get();
        if ($cranes->isEmpty()) {
            $cranes = Crane::factory()->count(3)->create(['estado' => Crane::STATUS_ACTIVE]);
        }
        
        // Crear array de grúas para la cotización (1-3 grúas)
        $quoteCranes = [];
        $selectedCranes = $cranes->random(rand(1, min(3, $cranes->count())));
        
        foreach ($selectedCranes as $crane) {
            $quoteCranes[] = [
                'crane' => (string) $crane->_id,
                'dias' => $this->faker->numberBetween(1, 30),
                'precio' => $this->faker->randomFloat(2, 1000, 10000)
            ];
        }
        
        $iva = $this->faker->randomElement([0, 16, 21]); // IVA común en diferentes países
        
        return [
            'name' => $this->faker->sentence(3),
            'zone' => $this->faker->randomElement([
                'Norte',
                'Sur', 
                'Este',
                'Oeste',
                'Centro',
                'Zona Industrial',
                'Zona Comercial',
                'Zona Residencial'
            ]),
            'clientId' => (string) $client->_id,
            'fileId' => (string) $file->_id,
            'status' => $this->faker->randomElement([
                Quote::STATUS_PENDING,
                Quote::STATUS_APPROVED,
                Quote::STATUS_REJECTED,
                Quote::STATUS_ACTIVE,
                Quote::STATUS_COMPLETED
            ]),
            'cranes' => $quoteCranes,
            'iva' => $iva,
            'total' => null, // Se calculará automáticamente
            'responsibleId' => (string) $user->_id,
            'createdAt' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updatedAt' => now(),
        ];
    }

    /**
     * Indicate that the quote is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Quote::STATUS_PENDING,
        ]);
    }

    /**
     * Indicate that the quote is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Quote::STATUS_APPROVED,
        ]);
    }

    /**
     * Indicate that the quote is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Quote::STATUS_REJECTED,
        ]);
    }

    /**
     * Indicate that the quote is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Quote::STATUS_ACTIVE,
        ]);
    }

    /**
     * Indicate that the quote is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Quote::STATUS_COMPLETED,
        ]);
    }

    /**
     * Create a quote with a specific client.
     */
    public function forClient(Client $client): static
    {
        return $this->state(fn (array $attributes) => [
            'clientId' => (string) $client->_id,
        ]);
    }

    /**
     * Create a quote with a specific file.
     */
    public function withFile(File $file): static
    {
        return $this->state(fn (array $attributes) => [
            'fileId' => (string) $file->_id,
        ]);
    }

    /**
     * Create a quote with a specific responsible user.
     */
    public function withResponsible(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'responsibleId' => (string) $user->_id,
        ]);
    }

    /**
     * Create a quote with specific zone.
     */
    public function inZone(string $zone): static
    {
        return $this->state(fn (array $attributes) => [
            'zone' => $zone,
        ]);
    }

    /**
     * Create a quote with high value.
     */
    public function highValue(): static
    {
        return $this->state(function (array $attributes) {
            // Crear grúas con precios altos
            $cranes = Crane::where('estado', Crane::STATUS_ACTIVE)->get();
            if ($cranes->isEmpty()) {
                $cranes = Crane::factory()->count(3)->create(['estado' => Crane::STATUS_ACTIVE]);
            }
            
            $quoteCranes = [];
            $selectedCranes = $cranes->random(rand(2, min(3, $cranes->count())));
            
            foreach ($selectedCranes as $crane) {
                $quoteCranes[] = [
                    'crane' => (string) $crane->_id,
                    'dias' => $this->faker->numberBetween(15, 60), // Más días
                    'precio' => $this->faker->randomFloat(2, 8000, 20000) // Precios más altos
                ];
            }
            
            return [
                'cranes' => $quoteCranes,
                'iva' => 16, // IVA estándar
            ];
        });
    }

    /**
     * Create a quote with low value.
     */
    public function lowValue(): static
    {
        return $this->state(function (array $attributes) {
            // Crear grúas con precios bajos
            $cranes = Crane::where('estado', Crane::STATUS_ACTIVE)->get();
            if ($cranes->isEmpty()) {
                $cranes = Crane::factory()->count(3)->create(['estado' => Crane::STATUS_ACTIVE]);
            }
            
            $quoteCranes = [];
            $selectedCranes = $cranes->random(1); // Solo una grúa
            
            foreach ($selectedCranes as $crane) {
                $quoteCranes[] = [
                    'crane' => (string) $crane->_id,
                    'dias' => $this->faker->numberBetween(1, 7), // Pocos días
                    'precio' => $this->faker->randomFloat(2, 500, 2000) // Precios bajos
                ];
            }
            
            return [
                'cranes' => $quoteCranes,
                'iva' => 0, // Sin IVA
            ];
        });
    }
}