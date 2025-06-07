<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'rfc' => $this->generateRFC(),
            'address' => $this->faker->address(),
            'rentHistory' => [],
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }

    /**
     * Indicate that the client is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the client is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the client has rent history.
     */
    public function withRentHistory(int $count = 3): static
    {
        $rentIds = [];
        for ($i = 0; $i < $count; $i++) {
            $rentIds[] = $this->faker->uuid();
        }

        return $this->state(fn (array $attributes) => [
            'rentHistory' => $rentIds,
        ]);
    }

    /**
     * Indicate that the client has no rent history.
     */
    public function withoutRentHistory(): static
    {
        return $this->state(fn (array $attributes) => [
            'rentHistory' => [],
        ]);
    }

    /**
     * Generate a valid RFC format.
     */
    private function generateRFC(): string
    {
        // Generate a basic RFC format: 4 letters + 6 digits + 3 alphanumeric
        $letters = strtoupper($this->faker->lexify('????'));
        $numbers = $this->faker->numerify('######');
        $alphanumeric = strtoupper($this->faker->bothify('???'));
        
        return $letters . $numbers . $alphanumeric;
    }

    /**
     * Create a client with specific RFC.
     */
    public function withRFC(string $rfc): static
    {
        return $this->state(fn (array $attributes) => [
            'rfc' => strtoupper($rfc),
        ]);
    }

    /**
     * Create a client with specific email.
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => $email,
        ]);
    }

    /**
     * Create a client with Mexican phone format.
     */
    public function withMexicanPhone(): static
    {
        $areaCode = $this->faker->randomElement(['55', '81', '33', '222', '998']);
        $number = $this->faker->numerify('#### ####');
        
        return $this->state(fn (array $attributes) => [
            'phone' => "+52 {$areaCode} {$number}",
        ]);
    }

    /**
     * Create a client with complete Mexican address.
     */
    public function withMexicanAddress(): static
    {
        $streets = [
            'Av. Reforma', 'Calle Juárez', 'Av. Insurgentes', 'Calle Madero',
            'Av. Universidad', 'Calle 5 de Mayo', 'Av. Revolución', 'Calle Hidalgo'
        ];
        
        $colonies = [
            'Col. Centro', 'Col. Roma Norte', 'Col. Condesa', 'Col. Polanco',
            'Col. Del Valle', 'Col. Doctores', 'Col. Juárez', 'Col. Santa María'
        ];
        
        $cities = [
            'Ciudad de México', 'Guadalajara', 'Monterrey', 'Puebla',
            'Tijuana', 'León', 'Juárez', 'Torreón'
        ];
        
        $states = [
            'CDMX', 'Jalisco', 'Nuevo León', 'Puebla',
            'Baja California', 'Guanajuato', 'Chihuahua', 'Coahuila'
        ];
        
        $street = $this->faker->randomElement($streets);
        $number = $this->faker->numberBetween(1, 9999);
        $colony = $this->faker->randomElement($colonies);
        $city = $this->faker->randomElement($cities);
        $state = $this->faker->randomElement($states);
        $zipCode = $this->faker->numerify('#####');
        
        return $this->state(fn (array $attributes) => [
            'address' => "{$street} {$number}, {$colony}, {$city}, {$state}, CP {$zipCode}",
        ]);
    }

    /**
     * Create a client that was created recently.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'createdAt' => now()->subDays($this->faker->numberBetween(1, 7)),
            'updatedAt' => now()->subDays($this->faker->numberBetween(0, 3)),
        ]);
    }

    /**
     * Create a client that was created long ago.
     */
    public function old(): static
    {
        $createdAt = now()->subDays($this->faker->numberBetween(30, 365));
        
        return $this->state(fn (array $attributes) => [
            'createdAt' => $createdAt,
            'updatedAt' => $createdAt->addDays($this->faker->numberBetween(0, 30)),
        ]);
    }

    /**
     * Create a client with a specific name pattern.
     */
    public function withNamePattern(string $pattern): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->lexify($pattern),
        ]);
    }
}