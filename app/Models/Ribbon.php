<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $material_id
 * @property Material $material
 * @property Collection|Material $materials
 */
class Ribbon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'material_id'
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'ribbons_materials', 'ribbon_id');
    }
}
