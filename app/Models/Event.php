<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'events';

    // Estados del evento
    const STATUS_SCHEDULED = 'programado';
    const STATUS_IN_PROGRESS = 'en_progreso';
    const STATUS_COMPLETED = 'completado';
    const STATUS_CANCELLED = 'cancelado';

    // Tipos de evento
    const TYPE_RENTAL = 'renta';
    const TYPE_MAINTENANCE = 'mantenimiento';
    const TYPE_MEETING = 'reunion';
    const TYPE_DELIVERY = 'entrega';
    const TYPE_PICKUP = 'recogida';
    const TYPE_OTHER = 'otro';

    // Prioridades
    const PRIORITY_LOW = 'baja';
    const PRIORITY_MEDIUM = 'media';
    const PRIORITY_HIGH = 'alta';
    const PRIORITY_URGENT = 'urgente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'priority',
        'start_date',
        'end_date',
        'all_day',
        'location',
        'client_id',
        'crane_id',
        'user_id',
        'notes',
        'color',
        'reminder_minutes',
        'attendees',
        'attachments',
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
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'all_day' => 'boolean',
            'reminder_minutes' => 'integer',
            'attendees' => 'array',
            'attachments' => 'array',
            'createdAt' => 'datetime',
            'updatedAt' => 'datetime',
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date', 'createdAt', 'updatedAt'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->createdAt = now();
            $event->updatedAt = now();
            if (empty($event->status)) {
                $event->status = self::STATUS_SCHEDULED;
            }
            if (empty($event->priority)) {
                $event->priority = self::PRIORITY_MEDIUM;
            }
            if (empty($event->color)) {
                $event->color = '#007bff';
            }
            if (empty($event->attendees)) {
                $event->attendees = [];
            }
            if (empty($event->attachments)) {
                $event->attachments = [];
            }
        });

        static::updating(function ($event) {
            $event->updatedAt = now();
        });
    }

    /**
     * Relación con Cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Relación con Grúa
     */
    public function crane()
    {
        return $this->belongsTo(Crane::class, 'crane_id');
    }

    /**
     * Relación con Usuario responsable
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope para eventos programados
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    /**
     * Scope para eventos en progreso
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope para eventos completados
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope para eventos cancelados
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope para eventos por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para eventos por prioridad
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope para eventos en un rango de fechas
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate]);
    }

    /**
     * Scope para eventos de hoy
     */
    public function scopeToday($query)
    {
        return $query->whereDate('start_date', today());
    }

    /**
     * Scope para eventos de esta semana
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Obtener todos los estados disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_SCHEDULED => 'Programado',
            self::STATUS_IN_PROGRESS => 'En Progreso',
            self::STATUS_COMPLETED => 'Completado',
            self::STATUS_CANCELLED => 'Cancelado',
        ];
    }

    /**
     * Obtener todos los tipos disponibles
     */
    public static function getTypes()
    {
        return [
            self::TYPE_RENTAL => 'Renta',
            self::TYPE_MAINTENANCE => 'Mantenimiento',
            self::TYPE_MEETING => 'Reunión',
            self::TYPE_DELIVERY => 'Entrega',
            self::TYPE_PICKUP => 'Recogida',
            self::TYPE_OTHER => 'Otro',
        ];
    }

    /**
     * Obtener todas las prioridades disponibles
     */
    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW => 'Baja',
            self::PRIORITY_MEDIUM => 'Media',
            self::PRIORITY_HIGH => 'Alta',
            self::PRIORITY_URGENT => 'Urgente',
        ];
    }

    /**
     * Verificar si el evento está programado
     */
    public function isScheduled()
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    /**
     * Verificar si el evento está en progreso
     */
    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Verificar si el evento está completado
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Verificar si el evento está cancelado
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Marcar evento como en progreso
     */
    public function markAsInProgress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        return $this->save();
    }

    /**
     * Marcar evento como completado
     */
    public function markAsCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
        return $this->save();
    }

    /**
     * Cancelar evento
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        return $this->save();
    }

    /**
     * Obtener el color del evento según su tipo
     */
    public function getTypeColorAttribute()
    {
        $colors = [
            self::TYPE_RENTAL => '#28a745',
            self::TYPE_MAINTENANCE => '#ffc107',
            self::TYPE_MEETING => '#007bff',
            self::TYPE_DELIVERY => '#17a2b8',
            self::TYPE_PICKUP => '#6f42c1',
            self::TYPE_OTHER => '#6c757d',
        ];

        return $colors[$this->type] ?? '#007bff';
    }

    /**
     * Obtener el color del evento según su prioridad
     */
    public function getPriorityColorAttribute()
    {
        $colors = [
            self::PRIORITY_LOW => '#28a745',
            self::PRIORITY_MEDIUM => '#ffc107',
            self::PRIORITY_HIGH => '#fd7e14',
            self::PRIORITY_URGENT => '#dc3545',
        ];

        return $colors[$this->priority] ?? '#ffc107';
    }

    /**
     * Formatear la duración del evento
     */
    public function getDurationAttribute()
    {
        if ($this->all_day) {
            return 'Todo el día';
        }

        if ($this->start_date && $this->end_date) {
            $duration = $this->start_date->diffInMinutes($this->end_date);
            
            if ($duration < 60) {
                return $duration . ' minutos';
            } elseif ($duration < 1440) {
                $hours = floor($duration / 60);
                $minutes = $duration % 60;
                return $hours . 'h' . ($minutes > 0 ? ' ' . $minutes . 'm' : '');
            } else {
                $days = floor($duration / 1440);
                return $days . ' día' . ($days > 1 ? 's' : '');
            }
        }

        return 'Sin duración';
    }

    /**
     * Verificar si el evento es de todo el día
     */
    public function isAllDay()
    {
        return $this->all_day;
    }

    /**
     * Verificar si el evento ya pasó
     */
    public function isPast()
    {
        return $this->end_date && $this->end_date->isPast();
    }

    /**
     * Verificar si el evento es hoy
     */
    public function isToday()
    {
        return $this->start_date && $this->start_date->isToday();
    }

    /**
     * Verificar si el evento es futuro
     */
    public function isFuture()
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    /**
     * Convert the model instance to an array.
     */
    public function toArray()
    {
        $array = parent::toArray();
        
        // Convert _id to id for JSON responses
        if (isset($array['_id'])) {
            $array['id'] = $array['_id'];
            unset($array['_id']);
        }
        
        // Convert _id to id for relationships
        if (isset($array['client']) && is_array($array['client']) && isset($array['client']['_id'])) {
            $array['client']['id'] = $array['client']['_id'];
            unset($array['client']['_id']);
        }
        
        if (isset($array['crane']) && is_array($array['crane']) && isset($array['crane']['_id'])) {
            $array['crane']['id'] = $array['crane']['_id'];
            unset($array['crane']['_id']);
        }
        
        if (isset($array['user']) && is_array($array['user']) && isset($array['user']['_id'])) {
            $array['user']['id'] = $array['user']['_id'];
            unset($array['user']['_id']);
        }
        
        return $array;
    }
}