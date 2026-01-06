<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_type',
        'subject_id',
        'action',
        'description',
        'properties',
        'user_id',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSubject($query, $subjectType, $subjectId)
    {
        return $query->where('subject_type', $subjectType)
                     ->where('subject_id', $subjectId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Helper Methods

    public function getActionLabel(): string
    {
        return match($this->action) {
            'created' => 'Creado',
            'updated' => 'Actualizado',
            'deleted' => 'Eliminado',
            'contacted' => 'Contactado',
            'emailed' => 'Email enviado',
            'called' => 'Llamada realizada',
            'met' => 'Reunión realizada',
            default => ucfirst($this->action),
        };
    }

    public function getActionIcon(): string
    {
        return match($this->action) {
            'created' => '➕',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'contacted' => '📬',
            'emailed' => '📧',
            'called' => '📞',
            'met' => '🤝',
            default => '📋',
        };
    }

    // Static Methods

    public static function log(string $action, Model $subject, ?string $description = null, array $properties = []): self
    {
        return static::create([
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
            'user_id' => auth()->id(),
        ]);
    }
}
