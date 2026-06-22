<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

#[Fillable(['name', 'description', 'start_date', 'deadline'])]
class Project extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'deadline' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project): void {
            if ($project->owner_id === null && Auth::check()) {
                $project->owner_id = Auth::id();
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}
