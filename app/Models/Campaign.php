<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'segment_id',
        'scheduled_at',
        'started_at',
        'completed_at',
        'stats',
        'created_by',
    ];

    protected $casts = [
        'stats' => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    // Scopes

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Helper Methods

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'email' => 'Email',
            'event' => 'Evento',
            'survey' => 'Encuesta',
            default => 'Desconocido',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'draft' => 'Borrador',
            'scheduled' => 'Programada',
            'active' => 'Activa',
            'completed' => 'Completada',
            'paused' => 'Pausada',
            default => 'Desconocido',
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'scheduled' => 'blue',
            'active' => 'green',
            'completed' => 'purple',
            'paused' => 'yellow',
            default => 'gray',
        };
    }

    public function updateStats(array $newStats): void
    {
        $currentStats = $this->stats ?? [];
        $this->update([
            'stats' => array_merge($currentStats, $newStats)
        ]);
    }
}
