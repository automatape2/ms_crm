<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Interaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_id',
        'organization_id',
        'type',
        'subject',
        'description',
        'date',
        'duration',
        'outcome',
        'next_steps',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'attachments' => 'array',
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByContact($query, $contactId)
    {
        return $query->where('contact_id', $contactId);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeByOutcome($query, $outcome)
    {
        return $query->where('outcome', $outcome);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date', '>=', now()->subDays($days));
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<=', now());
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('subject', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('next_steps', 'like', "%{$search}%");
        });
    }

    // Accessors

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'email' => '📧',
            'call' => '📞',
            'meeting' => '🤝',
            'event' => '📅',
            'note' => '📝',
            default => '📌',
        };
    }

    public function getOutcomeColorAttribute(): string
    {
        return match($this->outcome) {
            'positive' => 'green',
            'neutral' => 'gray',
            'negative' => 'red',
            default => 'blue',
        };
    }

    // Helper Methods

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'email' => 'Email',
            'call' => 'Llamada',
            'meeting' => 'Reunión',
            'event' => 'Evento',
            'note' => 'Nota',
            default => 'Otro',
        };
    }

    public function getOutcomeLabel(): ?string
    {
        return match($this->outcome) {
            'positive' => 'Positivo',
            'neutral' => 'Neutral',
            'negative' => 'Negativo',
            default => null,
        };
    }

    public function getDurationFormattedAttribute(): ?string
    {
        if (!$this->duration) {
            return null;
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return $minutes > 0 ? "{$hours}h {$minutes}m" : "{$hours}h";
        }

        return "{$minutes}m";
    }

    public function isUpcoming(): bool
    {
        return $this->date > now();
    }
}
