<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'organization_id',
        'tags',
        'custom_fields',
        'status',
        'source',
        'created_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'custom_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%");
        });
    }

    public function scopeWithOrganization($query)
    {
        return $query->with('organization');
    }

    // Accessors

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        $first = substr($this->first_name, 0, 1);
        $last = substr($this->last_name, 0, 1);
        return strtoupper($first . $last);
    }

    // Helper Methods

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getSourceLabel(): string
    {
        return match($this->source) {
            'manual' => 'Manual',
            'import' => 'Importación',
            'form' => 'Formulario',
            'api' => 'API',
            default => 'Desconocido',
        };
    }

    public function hasOrganization(): bool
    {
        return !is_null($this->organization_id);
    }

    public function getRecentInteractions(int $limit = 5)
    {
        return $this->interactions()
            ->orderBy('date', 'desc')
            ->limit($limit)
            ->get();
    }
}
