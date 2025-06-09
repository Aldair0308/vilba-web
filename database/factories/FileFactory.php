<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [File::TYPE_PDF, File::TYPE_EXCEL];
        $type = $this->faker->randomElement($types);
        
        // Generar contenido base64 simulado basado en el tipo
        $base64Content = $this->generateFakeBase64($type);
        
        return [
            'name' => $this->faker->words(3, true),
            'base64' => $base64Content,
            'type' => $type,
            'department' => $this->faker->randomElement([
                'Recursos Humanos',
                'Contabilidad',
                'Operaciones',
                'Ventas',
                'Marketing',
                'IT',
                'Legal',
                'Administración'
            ]),
            'responsible_id' => $this->faker->uuid(),
        ];
    }

    /**
     * Indicate that the file is a PDF.
     */
    public function pdf(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => File::TYPE_PDF,
            'base64' => $this->generateFakeBase64(File::TYPE_PDF),
        ]);
    }

    /**
     * Indicate that the file is an Excel file.
     */
    public function excel(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => File::TYPE_EXCEL,
            'base64' => $this->generateFakeBase64(File::TYPE_EXCEL),
        ]);
    }

    /**
     * Indicate that the file belongs to a specific department.
     */
    public function department(string $department): static
    {
        return $this->state(fn (array $attributes) => [
            'department' => $department,
        ]);
    }

    /**
     * Indicate that the file has a specific responsible.
     */
    public function responsible(string $responsibleId): static
    {
        return $this->state(fn (array $attributes) => [
            'responsible_id' => $responsibleId,
        ]);
    }

    /**
     * Generate fake base64 content for testing.
     */
    private function generateFakeBase64(string $type): string
    {
        // Generar contenido aleatorio para simular un archivo
        $content = $this->faker->text(1000);
        
        // Agregar algunos datos binarios simulados
        for ($i = 0; $i < 100; $i++) {
            $content .= chr($this->faker->numberBetween(0, 255));
        }
        
        $base64 = base64_encode($content);
        
        // Agregar prefijo MIME type apropiado
        $mimeType = match($type) {
            File::TYPE_PDF => 'application/pdf',
            File::TYPE_EXCEL => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/octet-stream'
        };
        
        return "data:{$mimeType};base64,{$base64}";
    }

    /**
     * Generate a small file for testing.
     */
    public function small(): static
    {
        return $this->state(function (array $attributes) {
            $content = $this->faker->text(100);
            $base64 = base64_encode($content);
            
            $mimeType = match($attributes['type'] ?? File::TYPE_PDF) {
                File::TYPE_PDF => 'application/pdf',
                File::TYPE_EXCEL => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                default => 'application/octet-stream'
            };
            
            return [
                'base64' => "data:{$mimeType};base64,{$base64}",
            ];
        });
    }

    /**
     * Generate a large file for testing.
     */
    public function large(): static
    {
        return $this->state(function (array $attributes) {
            $content = str_repeat($this->faker->text(1000), 10);
            
            // Agregar más datos binarios para simular un archivo más grande
            for ($i = 0; $i < 1000; $i++) {
                $content .= chr($this->faker->numberBetween(0, 255));
            }
            
            $base64 = base64_encode($content);
            
            $mimeType = match($attributes['type'] ?? File::TYPE_PDF) {
                File::TYPE_PDF => 'application/pdf',
                File::TYPE_EXCEL => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                default => 'application/octet-stream'
            };
            
            return [
                'base64' => "data:{$mimeType};base64,{$base64}",
            ];
        });
    }
}