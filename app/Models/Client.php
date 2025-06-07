<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Client extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'clients';

    // Estados del cliente
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'rfc',
        'address',
        'rentHistory',
        'status',
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

        static::creating(function ($client) {
            $client->createdAt = now();
            $client->updatedAt = now();
            if (empty($client->status)) {
                $client->status = self::STATUS_ACTIVE;
            }
            if (empty($client->rentHistory)) {
                $client->rentHistory = [];
            }
        });

        static::updating(function ($client) {
            $client->updatedAt = now();
        });
    }

    /**
     * Scope para clientes activos
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope para clientes inactivos
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Obtener todos los estados disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_INACTIVE => 'Inactivo',
        ];
    }

    /**
     * Verificar si el cliente está activo
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Verificar si el cliente está inactivo
     */
    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Activar cliente
     */
    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }

    /**
     * Desactivar cliente
     */
    public function deactivate()
    {
        $this->status = self::STATUS_INACTIVE;
        return $this->save();
    }

    /**
     * Agregar renta al historial
     */
    public function addRentToHistory($rentId)
    {
        $rentHistory = $this->rentHistory ?? [];
        if (!in_array($rentId, $rentHistory)) {
            $rentHistory[] = $rentId;
            $this->rentHistory = $rentHistory;
            return $this->save();
        }
        return true;
    }

    /**
     * Obtener el número de rentas
     */
    public function getRentCountAttribute()
    {
        return count($this->rentHistory ?? []);
    }

    /**
     * Formatear el RFC
     */
    public function getFormattedRfcAttribute()
    {
        return strtoupper($this->rfc);
    }

    /**
     * Formatear el teléfono
     */
    public function getFormattedPhoneAttribute()
    {
        // Formato: (XXX) XXX-XXXX
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        return $this->phone;
    }
}