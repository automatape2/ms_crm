<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'conditions',
        'contact_count',
        'is_dynamic',
        'created_by',
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_dynamic' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    // Scopes

    public function scopeDynamic($query)
    {
        return $query->where('is_dynamic', true);
    }

    public function scopeStatic($query)
    {
        return $query->where('is_dynamic', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Helper Methods

    public function updateContactCount(): void
    {
        // TODO: Implement dynamic query based on conditions
        $this->update(['contact_count' => 0]);
    }

    public function getContacts()
    {
        // TODO: Implement dynamic query based on conditions
        return Contact::query();
    }
}
