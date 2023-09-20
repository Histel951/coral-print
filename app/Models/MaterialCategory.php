<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property HasMany|Material|Collection $material
 */
class MaterialCategory extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['name'];

    protected array $allowedSorts = ['created_at', 'updated_at'];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'material_category_id', 'id');
    }
}
