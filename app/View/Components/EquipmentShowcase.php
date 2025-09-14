<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class EquipmentShowcase extends Component
{
    public $equipments;
    public $currentLanguage;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->currentLanguage = session('language', 'es');
        $this->equipments = $this->getFeaturedEquipments();
    }

    /**
     * Get featured equipments for showcase
     */
    private function getFeaturedEquipments()
    {
        // Los primeros 6 equipos que aparecen en la página de equipos
        $equipments = [
            [
                'slug' => 'excavadora',
                'name' => [
                    'es' => 'Excavadora',
                    'en' => 'Excavator'
                ],
                'description' => [
                    'es' => 'Excavadoras de trabajo pesado para movimiento de tierra, demolición y proyectos de construcción.',
                    'en' => 'Heavy-duty excavators for earthmoving, demolition, and construction projects.'
                ],
                'hero_image' => 'assets/img/equipos/excavadora.png'
            ],
            [
                'slug' => 'retroexcavadora-414E',
                'name' => [
                    'es' => 'Retroexcavadora 414E',
                    'en' => 'Backhoe Loader 414E'
                ],
                'description' => [
                    'es' => 'Retroexcavadora de alta capacidad para proyectos de construcción de todos los tamaños.',
                    'en' => 'High-capacity backhoe loader for construction projects of all sizes.'
                ],
                'hero_image' => 'assets/img/equipos/Retro-414.png'
            ],
            [
                'slug' => 'camion-ford',
                'name' => [
                    'es' => 'Camión de Volteo Ford',
                    'en' => 'Ford Dump Truck'
                ],
                'description' => [
                    'es' => 'Camiones de volteo para transporte y descarga de materiales en proyectos de construcción.',
                    'en' => 'Dump trucks for material transport and unloading in construction projects.'
                ],
                'hero_image' => 'assets/img/equipos/camion.png'
            ],
            [
                'slug' => 'camion-kenworth',
                'name' => [
                    'es' => 'Camión Kenworth',
                    'en' => 'Kenworth Truck'
                ],
                'description' => [
                    'es' => 'Camiones versátiles para montaje rápido y posicionamiento flexible en proyectos.',
                    'en' => 'Versatile trucks for quick setup and flexible positioning in projects.'
                ],
                'hero_image' => 'assets/img/equipos/camion-kenworth.png'
            ],
            [
                'slug' => 'retroexcavadora-416F',
                'name' => [
                    'es' => 'Retroexcavadora 416F',
                    'en' => 'Backhoe Loader 416F'
                ],
                'description' => [
                    'es' => 'Retroexcavadora 416F de alto rendimiento para excavación y carga en terrenos variados.',
                    'en' => 'High-performance 416F backhoe loader for excavation and loading on varied terrains.'
                ],
                'hero_image' => 'assets/img/equipos/Retro-416.png'
            ],
            [
                'slug' => 'camion-volvo',
                'name' => [
                    'es' => 'Camión Volvo FH',
                    'en' => 'Volvo FH Truck'
                ],
                'description' => [
                    'es' => 'Camión Volvo FH para transporte de larga distancia y construcción. Potencia de 420-540 CV, ideal para tareas de transporte regional y relacionado con edificación.',
                    'en' => 'Volvo FH truck for long-distance transport and construction. Power 420-540 HP, ideal for regional transport and building-related tasks.'
                ],
                'hero_image' => 'assets/img/service/servicess4.png'
            ]
        ];

        return array_slice($equipments, 0, 6);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.equipment-showcase');
    }
}
