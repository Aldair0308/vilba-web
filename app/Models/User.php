<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    // MongoDB configuration
    protected $connection = 'mongodb';
    protected $collection = 'users';

    // User roles
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    // User statuses
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'rol',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
            if (empty($model->updated_at)) {
                $model->updated_at = now();
            }
            if (empty($model->status)) {
                $model->status = self::STATUS_ACTIVE;
            }
            if (empty($model->rol)) {
                $model->rol = self::ROLE_USER;
            }
        });
        
        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    /**
     * Scope to filter users by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('rol', $role);
    }

    /**
     * Scope to filter admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('rol', self::ROLE_ADMIN);
    }

    /**
     * Scope to filter regular users
     */
    public function scopeRegularUsers($query)
    {
        return $query->where('rol', self::ROLE_USER);
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope para usuarios inactivos
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Obtener todos los roles disponibles
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 'Administrador',
            self::ROLE_USER => 'Usuario',
        ];
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
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->rol === self::ROLE_ADMIN;
    }

    /**
     * Verificar si el usuario está activo
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Verificar si el usuario está inactivo
     */
    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Activar usuario
     */
    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }

    /**
     * Desactivar usuario
     */
    public function deactivate()
    {
        $this->status = self::STATUS_INACTIVE;
        return $this->save();
    }

    /**
     * Get the photo URL attribute.
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ?? 'photo_user.jpg';
    }

    /**
     * Get the display name attribute.
     */
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Check if user is admin.
     */
    public function getIsAdminAttribute()
    {
        return $this->rol === self::ROLE_ADMIN;
    }

    /**
     * Get the formatted role attribute.
     */
    public function getFormattedRoleAttribute()
    {
        $roles = self::getRoles();
        return $roles[$this->rol] ?? $this->rol;
    }

    /**
     * Get the formatted status attribute.
     */
    public function getFormattedStatusAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }
}
