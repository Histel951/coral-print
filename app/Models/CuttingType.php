<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CuttingType extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['id', 'name'];

    protected array $allowedSorts = ['id', 'name'];

    public function cuttings(): HasMany
    {
        return $this->hasMany(Cutting::class);
    }
}
