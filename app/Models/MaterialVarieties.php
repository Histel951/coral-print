<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property HasMany|Material $materials
 */
class MaterialVarieties extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'material_variety_id', 'id');
    }
}
