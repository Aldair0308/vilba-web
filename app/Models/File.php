<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class File extends Model
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $collection = 'files';

    // Tipos de archivo
    const TYPE_PDF = 'pdf';
    const TYPE_EXCEL = 'excel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'base64',
        'type',
        'department',
        'responsible_id',
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

        static::creating(function ($file) {
            $file->createdAt = now();
            $file->updatedAt = now();
        });

        static::updating(function ($file) {
            $file->updatedAt = now();
        });
    }

    /**
     * Scope para archivos PDF
     */
    public function scopePdf($query)
    {
        return $query->where('type', self::TYPE_PDF);
    }

    /**
     * Scope para archivos Excel
     */
    public function scopeExcel($query)
    {
        return $query->where('type', self::TYPE_EXCEL);
    }

    /**
     * Scope para archivos por departamento
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope para archivos por responsable
     */
    public function scopeByResponsible($query, $responsibleId)
    {
        return $query->where('responsible_id', $responsibleId);
    }

    /**
     * Verificar si el archivo es PDF
     */
    public function isPdf(): bool
    {
        return $this->type === self::TYPE_PDF;
    }

    /**
     * Verificar si el archivo es Excel
     */
    public function isExcel(): bool
    {
        return $this->type === self::TYPE_EXCEL;
    }

    /**
     * Obtener el tamaño del archivo en bytes
     */
    public function getFileSizeAttribute(): int
    {
        if (empty($this->base64)) {
            return 0;
        }
        
        // Calcular el tamaño del archivo desde base64
        $base64String = $this->base64;
        
        // Remover el prefijo data:type/subtype;base64, si existe
        if (strpos($base64String, ',') !== false) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
        }
        
        // Calcular el tamaño real del archivo
        $padding = substr_count($base64String, '=');
        return (strlen($base64String) * 3 / 4) - $padding;
    }

    /**
     * Obtener el tamaño del archivo formateado
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Obtener los tipos de archivo disponibles
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_PDF => 'PDF',
            self::TYPE_EXCEL => 'Excel',
        ];
    }

    /**
     * Obtener la extensión del archivo basada en el tipo
     */
    public function getFileExtensionAttribute(): string
    {
        return match($this->type) {
            self::TYPE_PDF => 'pdf',
            self::TYPE_EXCEL => 'xlsx',
            default => 'unknown'
        };
    }

    /**
     * Obtener el MIME type del archivo
     */
    public function getMimeTypeAttribute(): string
    {
        return match($this->type) {
            self::TYPE_PDF => 'application/pdf',
            self::TYPE_EXCEL => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/octet-stream'
        };
    }

    /**
     * Validar que el base64 sea válido
     */
    public function isValidBase64(): bool
    {
        if (empty($this->base64)) {
            return false;
        }
        
        $base64String = $this->base64;
        
        // Remover el prefijo data:type/subtype;base64, si existe
        if (strpos($base64String, ',') !== false) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
        }
        
        return base64_encode(base64_decode($base64String, true)) === $base64String;
    }

    /**
     * Obtener estadísticas de archivos
     */
    public static function getStats(): array
    {
        $totalFiles = self::count();
        $pdfFiles = self::pdf()->count();
        $excelFiles = self::excel()->count();
        
        // Calcular tamaño promedio y total
        $files = self::all();
        $totalSize = 0;
        
        foreach ($files as $file) {
            $totalSize += $file->file_size;
        }
        
        $averageSize = $totalFiles > 0 ? $totalSize / $totalFiles : 0;
        
        return [
            'total' => $totalFiles,
            'pdf' => $pdfFiles,
            'excel' => $excelFiles,
            'total_size' => $totalSize,
            'average_size' => $averageSize,
            'formatted_total_size' => self::formatBytes($totalSize),
            'formatted_average_size' => self::formatBytes($averageSize),
        ];
    }

    /**
     * Formatear bytes a una unidad legible
     */
    private static function formatBytes($bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}