<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['issue_id', 'author_name', 'body'])]
class Comment extends Model
{
    use HasUuids;

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }
}
