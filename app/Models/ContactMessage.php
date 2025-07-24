<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;

class ContactMessage extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'phone',
        'status',
        'replied_at',
        'reply_message',
        'replied_by'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['replied_at', 'createdAt', 'updatedAt'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contactMessage) {
            $contactMessage->createdAt = now();
            $contactMessage->updatedAt = now();
            if (empty($contactMessage->status)) {
                $contactMessage->status = 'pending';
            }
        });

        static::updating(function ($contactMessage) {
            $contactMessage->updatedAt = now();
        });
    }

    /**
     * Scope para mensajes pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para mensajes leídos
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope para mensajes respondidos
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Marcar como leído
     */
    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    /**
     * Marcar como respondido
     */
    public function markAsReplied($replyMessage, $repliedBy)
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'reply_message' => $replyMessage,
            'replied_by' => $repliedBy
        ]);
    }

    /**
     * Obtener el estado en español
     */
    public function getStatusInSpanish()
    {
        $statuses = [
            'pending' => 'Pendiente',
            'read' => 'Leído',
            'replied' => 'Respondido',
            'archived' => 'Archivado'
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}