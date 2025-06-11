<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Models\User;

class Log extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'logs';

    // Acciones del log
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';
    const ACTION_COMPLETE = 'complete';
    const ACTION_CANCEL = 'cancel';

    // Módulos del sistema
    const MODULE_USER = 'user';
    const MODULE_CLIENT = 'client';
    const MODULE_CRANE = 'crane';
    const MODULE_QUOTE = 'quote';
    const MODULE_RENT = 'rent';
    const MODULE_FILE = 'file';
    const MODULE_PHOTO = 'photo';
    const MODULE_AUTH = 'auth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'userId',
        'userName',
        'action',
        'module',
        'entityId',
        'entityName',
        'previousData',
        'newData',
        'description',
        'ipAddress',
        'userAgent',
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
            // MongoDB already stores these as native arrays, no casting needed
            // 'previousData' => 'array',
            // 'newData' => 'array',
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

        static::creating(function ($log) {
            $log->createdAt = now();
            $log->updatedAt = now();
        });

        static::updating(function ($log) {
            $log->updatedAt = now();
        });
    }

    /**
     * Obtener todas las acciones disponibles
     */
    public static function getActions()
    {
        return [
            self::ACTION_CREATE => 'Crear',
            self::ACTION_UPDATE => 'Actualizar',
            self::ACTION_DELETE => 'Eliminar',
            self::ACTION_LOGIN => 'Iniciar Sesión',
            self::ACTION_LOGOUT => 'Cerrar Sesión',
            self::ACTION_APPROVE => 'Aprobar',
            self::ACTION_REJECT => 'Rechazar',
            self::ACTION_COMPLETE => 'Completar',
            self::ACTION_CANCEL => 'Cancelar',
        ];
    }

    /**
     * Obtener todos los módulos disponibles
     */
    public static function getModules()
    {
        return [
            self::MODULE_USER => 'Usuarios',
            self::MODULE_CLIENT => 'Clientes',
            self::MODULE_CRANE => 'Grúas',
            self::MODULE_QUOTE => 'Cotizaciones',
            self::MODULE_RENT => 'Rentas',
            self::MODULE_FILE => 'Archivos',
            self::MODULE_PHOTO => 'Fotos',
            self::MODULE_AUTH => 'Autenticación',
        ];
    }

    /**
     * Scope para filtrar por acción
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope para filtrar por módulo
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('userId', $userId);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('createdAt', [$startDate, $endDate]);
    }

    /**
     * Scope para logs recientes
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('createdAt', '>=', now()->subDays($days));
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * Obtener el nombre de la acción formateado
     */
    public function getFormattedActionAttribute()
    {
        $actions = self::getActions();
        return $actions[$this->action] ?? $this->action;
    }

    /**
     * Obtener el nombre del módulo formateado
     */
    public function getFormattedModuleAttribute()
    {
        $modules = self::getModules();
        return $modules[$this->module] ?? $this->module;
    }

    /**
     * Obtener la descripción completa del log
     */
    public function getFullDescriptionAttribute()
    {
        $action = $this->formatted_action;
        $module = $this->formatted_module;
        $entity = $this->entityName ?? $this->entityId;
        
        return "{$this->userName} realizó la acción '{$action}' en el módulo '{$module}' sobre '{$entity}'";
    }

    /**
     * Verificar si hay cambios en los datos
     */
    public function hasDataChanges()
    {
        return !empty($this->previousData) || !empty($this->newData);
    }

    /**
     * Obtener los cambios realizados
     */
    public function getChanges()
    {
        if (!$this->hasDataChanges()) {
            return [];
        }

        $changes = [];
        $previous = $this->previousData ?? [];
        $new = $this->newData ?? [];

        // Asegurar que los datos sean arrays (compatibilidad con datos existentes)
        if (is_string($previous)) {
            $previous = json_decode($previous, true) ?? [];
        }
        if (is_string($new)) {
            $new = json_decode($new, true) ?? [];
        }

        // Obtener todas las claves únicas
        $allKeys = array_unique(array_merge(array_keys($previous), array_keys($new)));

        foreach ($allKeys as $key) {
            $oldValue = $previous[$key] ?? null;
            $newValue = $new[$key] ?? null;

            if ($oldValue !== $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }

        return $changes;
    }

    /**
     * Create a new log entry
     */
    public static function createLog($userId, $userName, $action, $module, $entityId, $entityName = null, $previousData = null, $newData = null, $description = null, $ipAddress = null, $userAgent = null)
    {
        return self::create([
            'userId' => $userId,
            'userName' => $userName,
            'action' => $action,
            'module' => $module,
            'entityId' => $entityId,
            'entityName' => $entityName,
            'previousData' => $previousData,
            'newData' => $newData,
            'description' => $description,
            'ipAddress' => $ipAddress ?? request()->ip(),
            'userAgent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Get color for action badge
     */
    public function getActionColor()
    {
        $colors = [
            self::ACTION_CREATE => 'success',
            self::ACTION_UPDATE => 'warning',
            self::ACTION_DELETE => 'danger',
            self::ACTION_LOGIN => 'info',
            self::ACTION_LOGOUT => 'secondary',
            self::ACTION_APPROVE => 'success',
            self::ACTION_REJECT => 'danger',
            self::ACTION_COMPLETE => 'primary',
            self::ACTION_CANCEL => 'dark',
        ];

        return $colors[$this->action] ?? 'secondary';
    }

    /**
     * Get icon for action
     */
    public function getActionIcon()
    {
        $icons = [
            self::ACTION_CREATE => 'plus',
            self::ACTION_UPDATE => 'edit',
            self::ACTION_DELETE => 'trash',
            self::ACTION_LOGIN => 'sign-in-alt',
            self::ACTION_LOGOUT => 'sign-out-alt',
            self::ACTION_APPROVE => 'check',
            self::ACTION_REJECT => 'times',
            self::ACTION_COMPLETE => 'check-circle',
            self::ACTION_CANCEL => 'ban',
        ];

        return $icons[$this->action] ?? 'circle';
    }

    /**
     * Get icon for module
     */
    public function getModuleIcon()
    {
        $icons = [
            self::MODULE_USER => 'user',
            self::MODULE_CLIENT => 'users',
            self::MODULE_CRANE => 'truck',
            self::MODULE_QUOTE => 'file-invoice',
            self::MODULE_RENT => 'handshake',
            self::MODULE_FILE => 'file',
            self::MODULE_PHOTO => 'image',
            self::MODULE_AUTH => 'shield-alt',
        ];

        return $icons[$this->module] ?? 'cube';
    }
}