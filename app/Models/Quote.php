<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Quote extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'quotes';

    // Estados de la cotización
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';
    const STATUS_APPROVED = 'approved';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'zone',
        'clientId',
        'fileId',
        'status',
        'cranes',
        'iva',
        'total',
        'responsibleId',
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
            'cranes' => 'array',
            'iva' => 'float',
            'createdAt' => 'datetime',
            'updatedAt' => 'datetime',
        ];
    }

    /**
     * Set the cranes attribute.
     */
    public function setCranesAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['cranes'] = json_decode($value, true) ?: [];
        } elseif (is_array($value)) {
            $this->attributes['cranes'] = $value;
        } else {
            $this->attributes['cranes'] = [];
        }
    }

    /**
     * Get the cranes attribute.
     */
    public function getCranesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return is_array($value) ? $value : [];
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

        static::creating(function ($quote) {
            $quote->createdAt = now();
            $quote->updatedAt = now();
            if (!$quote->status) {
                $quote->status = self::STATUS_PENDING;
            }
        });

        static::updating(function ($quote) {
            $quote->updatedAt = now();
        });
    }

    /**
     * Relación con el cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId');
    }

    /**
     * Relación con el archivo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'fileId');
    }

    /**
     * Relación con el usuario responsable
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsibleId');
    }

    /**
     * Scope para cotizaciones pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope para cotizaciones aprobadas
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope para cotizaciones activas
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope para cotizaciones completadas
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope para cotizaciones rechazadas
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Scope para cotizaciones por zona
     */
    public function scopeByZone($query, $zone)
    {
        return $query->where('zone', $zone);
    }

    /**
     * Scope para cotizaciones por cliente
     */
    public function scopeByClient($query, $clientId)
    {
        return $query->where('clientId', $clientId);
    }

    /**
     * Scope para cotizaciones por responsable
     */
    public function scopeByResponsible($query, $responsibleId)
    {
        return $query->where('responsibleId', $responsibleId);
    }

    /**
     * Obtener el total calculado de las grúas
     */
    public function getCalculatedTotalAttribute()
    {
        if (!$this->cranes || !is_array($this->cranes)) {
            return 0;
        }

        $subtotal = 0;
        foreach ($this->cranes as $crane) {
            if (isset($crane['dias']) && isset($crane['precio'])) {
                $subtotal += $crane['dias'] * $crane['precio'];
            }
        }

        $iva = $this->iva ?? 0;
        return $subtotal + ($subtotal * ($iva / 100));
    }

    /**
     * Obtener el subtotal sin IVA
     */
    public function getSubtotalAttribute()
    {
        if (!$this->cranes || !is_array($this->cranes)) {
            return 0;
        }

        $subtotal = 0;
        foreach ($this->cranes as $crane) {
            if (isset($crane['dias']) && isset($crane['precio'])) {
                $subtotal += $crane['dias'] * $crane['precio'];
            }
        }

        return $subtotal;
    }

    /**
     * Obtener el monto del IVA
     */
    public function getIvaAmountAttribute()
    {
        $subtotal = $this->getSubtotalAttribute();
        $iva = $this->iva ?? 0;
        return $subtotal * ($iva / 100);
    }

    /**
     * Validar estructura de grúas
     */
    public function validateCranes()
    {
        if (!$this->cranes || !is_array($this->cranes)) {
            return false;
        }

        foreach ($this->cranes as $crane) {
            if (!isset($crane['crane']) || !isset($crane['dias']) || !isset($crane['precio'])) {
                return false;
            }
            if (!is_numeric($crane['dias']) || !is_numeric($crane['precio'])) {
                return false;
            }
            if ($crane['dias'] <= 0 || $crane['precio'] <= 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Obtener todas las grúas referenciadas en la cotización
     */
    public function getCraneModels()
    {
        if (!$this->cranes || !is_array($this->cranes)) {
            return collect();
        }

        $craneIds = collect($this->cranes)->pluck('crane')->filter();
        return Crane::whereIn('_id', $craneIds)->get();
    }

    /**
     * Obtener información detallada de las grúas con precios
     */
    public function getCraneDetailsAttribute()
    {
        if (!$this->cranes || !is_array($this->cranes)) {
            return [];
        }

        $craneModels = $this->getCraneModels()->keyBy('_id');
        
        return collect($this->cranes)->map(function ($crane) use ($craneModels) {
            // Validar que $crane sea un array válido con la estructura QuoteCrane
            if (!is_array($crane)) {
                return [
                    'crane' => null,
                    'dias' => 0,
                    'precio' => 0,
                    'subtotal' => 0,
                    'crane_info' => null
                ];
            }
            
            // Extraer valores con validación y valores por defecto
            $craneId = isset($crane['crane']) && (is_string($crane['crane']) || is_object($crane['crane'])) ? (string)$crane['crane'] : null;
            $dias = isset($crane['dias']) && is_numeric($crane['dias']) ? (int)$crane['dias'] : 0;
            $precio = isset($crane['precio']) && is_numeric($crane['precio']) ? (float)$crane['precio'] : 0;
            
            $craneModel = $craneId ? $craneModels->get($craneId) : null;
            
            return [
                'crane' => $craneId,
                'dias' => $dias,
                'precio' => $precio,
                'subtotal' => $dias * $precio,
                'crane_info' => $craneModel ? [
                    'nombre' => $craneModel->nombre ?? '',
                    'marca' => $craneModel->marca ?? '',
                    'modelo' => $craneModel->modelo ?? '',
                    'capacidad' => $craneModel->capacidad ?? '',
                    'tipo' => $craneModel->tipo ?? '',
                ] : null
            ];
        })->toArray();
    }
}