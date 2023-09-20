<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formula extends Model
{
    use HasFactory;

    public function additionalWorks(): HasMany
    {
        return $this->hasMany(WorkAdditional::class, 'formula_id', 'id');
    }
}
