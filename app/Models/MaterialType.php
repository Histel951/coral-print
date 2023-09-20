<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class MaterialType extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name', 'type_name', 'sort'];

    protected array $allowedFilters = ['id', 'name', 'type_name', 'sort'];

    protected array $allowedSorts = ['id', 'sort', 'created_at', 'updated_at'];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'material_type_id');
    }
}
