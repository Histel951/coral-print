<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialCategories extends Model
{
    use HasFactory;

    protected $table = 'material_categories';

    protected $fillable = ['name'];

    public function materials(): HasMany
    {
        return $this->hasMany(Materials::class, 'material_categories_id', 'id');
    }
}
