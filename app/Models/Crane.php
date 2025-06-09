<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Crane extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'cranes';

    // Estados de la grúa
    const STATUS_ACTIVE = 'activo';
    const STATUS_INACTIVE = 'inactivo';
    const STATUS_MAINTENANCE = 'mantenimiento';
    const STATUS_RENTED = 'en_renta';

    // Tipos de grúa
    const TYPE_TOWER = 'torre';
    const TYPE_MOBILE = 'móvil';
    const TYPE_CRAWLER = 'oruga';
    const TYPE_TRUCK = 'camión';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'marca',
        'modelo',
        'nombre',
        'capacidad',
        'tipo',
        'estado',
        'category',
        'precios',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'createdAt' => 'datetime',
            'updatedAt' => 'datetime',
            'capacidad' => 'integer',
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createdAt', 'updatedAt'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($crane) {
            $crane->createdAt = now();
            $crane->updatedAt = now();
            if (empty($crane->estado)) {
                $crane->estado = self::STATUS_ACTIVE;
            }
            if (empty($crane->precios)) {
                $crane->precios = [];
            }
        });

        static::updating(function ($crane) {
            $crane->updatedAt = now();
        });
    }

    /**
     * Scope para grúas activas
     */
    public function scopeActive($query)
    {
        return $query->where('estado', self::STATUS_ACTIVE);
    }

    /**
     * Scope para grúas inactivas
     */
    public function scopeInactive($query)
    {
        return $query->where('estado', self::STATUS_INACTIVE);
    }

    /**
     * Scope para grúas en mantenimiento
     */
    public function scopeMaintenance($query)
    {
        return $query->where('estado', self::STATUS_MAINTENANCE);
    }

    /**
     * Scope para grúas en renta
     */
    public function scopeRented($query)
    {
        return $query->where('estado', self::STATUS_RENTED);
    }

    /**
     * Scope para grúas con precios configurados
     */
    public function scopeWithPrices($query)
    {
        return $query->whereNotNull('precios')
                    ->where('precios', '!=', []);
    }

    /**
     * Obtener todos los estados disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_INACTIVE => 'Inactivo',
            self::STATUS_MAINTENANCE => 'Mantenimiento',
            self::STATUS_RENTED => 'En Renta',
        ];
    }

    /**
     * Obtener todos los tipos disponibles
     */
    public static function getTypes()
    {
        return [
            self::TYPE_TOWER => 'Torre',
            self::TYPE_MOBILE => 'Móvil',
            self::TYPE_CRAWLER => 'Oruga',
            self::TYPE_TRUCK => 'Camión',
        ];
    }

    /**
     * Verificar si la grúa está activa
     */
    public function isActive()
    {
        return $this->estado === self::STATUS_ACTIVE;
    }

    /**
     * Verificar si la grúa está inactiva
     */
    public function isInactive()
    {
        return $this->estado === self::STATUS_INACTIVE;
    }

    /**
     * Verificar si la grúa está en mantenimiento
     */
    public function isInMaintenance()
    {
        return $this->estado === self::STATUS_MAINTENANCE;
    }

    /**
     * Verificar si la grúa está en renta
     */
    public function isRented()
    {
        return $this->estado === self::STATUS_RENTED;
    }

    /**
     * Activar grúa
     */
    public function activate()
    {
        $this->estado = self::STATUS_ACTIVE;
        return $this->save();
    }

    /**
     * Desactivar grúa
     */
    public function deactivate()
    {
        $this->estado = self::STATUS_INACTIVE;
        return $this->save();
    }

    /**
     * Poner grúa en mantenimiento
     */
    public function setMaintenance()
    {
        $this->estado = self::STATUS_MAINTENANCE;
        return $this->save();
    }

    /**
     * Poner grúa en renta
     */
    public function setRented()
    {
        $this->estado = self::STATUS_RENTED;
        return $this->save();
    }

    /**
     * Agregar precio para una zona
     */
    public function addPriceForZone($zona, $precios)
    {
        $currentPrices = $this->precios ?? [];
        
        // Buscar si ya existe la zona
        $zoneIndex = null;
        foreach ($currentPrices as $index => $priceData) {
            if ($priceData['zona'] === $zona) {
                $zoneIndex = $index;
                break;
            }
        }
        
        if ($zoneIndex !== null) {
            // Actualizar precios existentes
            $currentPrices[$zoneIndex]['precio'] = is_array($precios) ? $precios : [$precios];
        } else {
            // Agregar nueva zona
            $currentPrices[] = [
                'zona' => $zona,
                'precio' => is_array($precios) ? $precios : [$precios]
            ];
        }
        
        $this->precios = $currentPrices;
        return $this->save();
    }

    /**
     * Obtener precio para una zona específica
     */
    public function getPriceForZone($zona)
    {
        $precios = $this->precios ?? [];
        
        foreach ($precios as $priceData) {
            if ($priceData['zona'] === $zona) {
                return $priceData['precio'];
            }
        }
        
        return null;
    }

    /**
     * Obtener todas las zonas con precios
     */
    public function getZonesWithPrices()
    {
        $precios = $this->precios ?? [];
        return array_column($precios, 'zona');
    }

    /**
     * Obtener el número de zonas con precios configurados
     */
    public function getZoneCountAttribute()
    {
        return count($this->precios ?? []);
    }

    /**
     * Formatear la capacidad
     */
    public function getFormattedCapacityAttribute()
    {
        return number_format($this->capacidad, 0) . ' ton';
    }

    /**
     * Obtener el nombre completo de la grúa
     */
    public function getFullNameAttribute()
    {
        return $this->marca . ' ' . $this->modelo . ' - ' . $this->nombre;
    }
}