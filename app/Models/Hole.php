<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hole extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function additionalWorks(): BelongsToMany
    {
        return $this->belongsToMany(WorkAdditional::class, 'hole_id', 'id');
    }
}
