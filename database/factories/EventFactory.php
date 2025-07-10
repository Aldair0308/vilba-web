<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\Client;
use App\Models\Crane;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 8) . ' hours');
        
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'type' => $this->faker->randomElement(['renta', 'mantenimiento', 'reunion', 'entrega', 'recogida', 'otro']),
            'status' => $this->faker->randomElement(['programado', 'en_progreso', 'completado', 'cancelado']),
            'priority' => $this->faker->randomElement(['baja', 'media', 'alta', 'urgente']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'all_day' => $this->faker->boolean(20), // 20% chance of being all day
            'location' => $this->faker->optional(0.8)->address(),
            'client_id' => null, // Will be set by relationships
            'crane_id' => null, // Will be set by relationships
            'user_id' => null, // Will be set by relationships
            'notes' => $this->faker->optional(0.5)->paragraph(),
            'color' => $this->faker->hexColor(),
            'reminder_minutes' => $this->faker->optional(0.6)->randomElement([15, 30, 60, 120, 1440]),
            'attendees' => $this->faker->optional(0.4)->randomElements([
                $this->faker->name(),
                $this->faker->name(),
                $this->faker->name(),
            ], $this->faker->numberBetween(1, 3)),
            'attachments' => [],
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }

    /**
     * Indicate that the event is scheduled.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Event::STATUS_SCHEDULED,
        ]);
    }

    /**
     * Indicate that the event is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Event::STATUS_IN_PROGRESS,
        ]);
    }

    /**
     * Indicate that the event is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Event::STATUS_COMPLETED,
        ]);
    }

    /**
     * Indicate that the event is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Event::STATUS_CANCELLED,
        ]);
    }

    /**
     * Indicate that the event is a rental.
     */
    public function rental(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Event::TYPE_RENTAL,
            'title' => 'Renta de ' . $this->faker->randomElement(['Grúa Torre', 'Grúa Móvil', 'Grúa Oruga']),
            'color' => '#28a745',
        ]);
    }

    /**
     * Indicate that the event is maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Event::TYPE_MAINTENANCE,
            'title' => 'Mantenimiento ' . $this->faker->randomElement(['preventivo', 'correctivo', 'programado']),
            'color' => '#ffc107',
        ]);
    }

    /**
     * Indicate that the event is a meeting.
     */
    public function meeting(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Event::TYPE_MEETING,
            'title' => 'Reunión ' . $this->faker->randomElement(['con cliente', 'de equipo', 'de planificación']),
            'color' => '#007bff',
        ]);
    }

    /**
     * Indicate that the event is a delivery.
     */
    public function delivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Event::TYPE_DELIVERY,
            'title' => 'Entrega de ' . $this->faker->randomElement(['equipo', 'documentos', 'materiales']),
            'color' => '#17a2b8',
        ]);
    }

    /**
     * Indicate that the event is a pickup.
     */
    public function pickup(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Event::TYPE_PICKUP,
            'title' => 'Recogida de ' . $this->faker->randomElement(['equipo', 'documentos', 'materiales']),
            'color' => '#6f42c1',
        ]);
    }

    /**
     * Indicate that the event has low priority.
     */
    public function lowPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Event::PRIORITY_LOW,
        ]);
    }

    /**
     * Indicate that the event has medium priority.
     */
    public function mediumPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Event::PRIORITY_MEDIUM,
        ]);
    }

    /**
     * Indicate that the event has high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Event::PRIORITY_HIGH,
        ]);
    }

    /**
     * Indicate that the event is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Event::PRIORITY_URGENT,
        ]);
    }

    /**
     * Indicate that the event is all day.
     */
    public function allDay(): static
    {
        $date = $this->faker->dateTimeBetween('-1 month', '+2 months');
        
        return $this->state(fn (array $attributes) => [
            'all_day' => true,
            'start_date' => Carbon::parse($date)->startOfDay(),
            'end_date' => Carbon::parse($date)->endOfDay(),
        ]);
    }

    /**
     * Indicate that the event is today.
     */
    public function today(): static
    {
        $startTime = $this->faker->time('H:i:s');
        $endTime = Carbon::parse($startTime)->addHours($this->faker->numberBetween(1, 4))->format('H:i:s');
        
        return $this->state(fn (array $attributes) => [
            'start_date' => Carbon::today()->setTimeFromTimeString($startTime),
            'end_date' => Carbon::today()->setTimeFromTimeString($endTime),
        ]);
    }

    /**
     * Indicate that the event is this week.
     */
    public function thisWeek(): static
    {
        $date = $this->faker->dateTimeBetween('now', 'next week');
        $endDate = (clone $date)->modify('+' . $this->faker->numberBetween(1, 6) . ' hours');
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $date,
            'end_date' => $endDate,
        ]);
    }

    /**
     * Indicate that the event is in the past.
     */
    public function past(): static
    {
        $startDate = $this->faker->dateTimeBetween('-2 months', '-1 day');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 8) . ' hours');
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement([Event::STATUS_COMPLETED, Event::STATUS_CANCELLED]),
        ]);
    }

    /**
     * Indicate that the event is in the future.
     */
    public function future(): static
    {
        $startDate = $this->faker->dateTimeBetween('+1 day', '+2 months');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 8) . ' hours');
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => Event::STATUS_SCHEDULED,
        ]);
    }

    /**
     * Associate the event with a client.
     */
    public function withClient(Client $client): static
    {
        return $this->state(fn (array $attributes) => [
            'client_id' => (string) $client->_id,
        ]);
    }

    /**
     * Associate the event with a crane.
     */
    public function withCrane(Crane $crane): static
    {
        return $this->state(fn (array $attributes) => [
            'crane_id' => (string) $crane->_id,
        ]);
    }

    /**
     * Associate the event with a user.
     */
    public function withUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => (string) $user->_id,
        ]);
    }

    /**
     * Create an event with attendees.
     */
    public function withAttendees(int $count = 3): static
    {
        $attendees = [];
        for ($i = 0; $i < $count; $i++) {
            $attendees[] = $this->faker->name();
        }
        
        return $this->state(fn (array $attributes) => [
            'attendees' => $attendees,
        ]);
    }

    /**
     * Create an event with reminder.
     */
    public function withReminder(int $minutes = 30): static
    {
        return $this->state(fn (array $attributes) => [
            'reminder_minutes' => $minutes,
        ]);
    }

    /**
     * Create an event with specific location.
     */
    public function withLocation(string $location): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => $location,
        ]);
    }

    /**
     * Create an event with specific color.
     */
    public function withColor(string $color): static
    {
        return $this->state(fn (array $attributes) => [
            'color' => $color,
        ]);
    }

    /**
     * Create an event with notes.
     */
    public function withNotes(string $notes = null): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => $notes ?: $this->faker->paragraph(),
        ]);
    }

    /**
     * Create an event with specific duration in hours.
     */
    public function withDuration(int $hours): static
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $endDate = (clone $startDate)->modify("+{$hours} hours");
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * Create a recent event.
     */
    public function recent(): static
    {
        $createdAt = now()->subDays($this->faker->numberBetween(1, 7));
        
        return $this->state(fn (array $attributes) => [
            'createdAt' => $createdAt,
            'updatedAt' => $createdAt->addHours($this->faker->numberBetween(0, 24)),
        ]);
    }
}