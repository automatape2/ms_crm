<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'industry',
        'website',
        'email',
        'phone',
        'address',
        'tags',
        'custom_fields',
        'status',
        'created_by',
    ];

    protected $casts = [
        'address' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('industry', 'like', "%{$search}%");
        });
    }

    // Accessors

    public function getFullAddressAttribute(): ?string
    {
        if (!$this->address) {
            return null;
        }

        $parts = array_filter([
            $this->address['street'] ?? null,
            $this->address['city'] ?? null,
            $this->address['state'] ?? null,
            $this->address['country'] ?? null,
        ]);

        return implode(', ', $parts);
    }

    // Helper Methods

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'gobierno' => 'Gobierno',
            'ong' => 'ONG',
            'empresa' => 'Empresa',
            'comunidad' => 'Comunidad',
            default => 'Otro',
        };
    }
}
