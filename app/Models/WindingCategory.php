<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WindingCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sequence'];

    public function windings(): BelongsToMany
    {
        return $this->belongsToMany(Winding::class, 'winding_categories_windings', 'winding_category_id');
    }
}
