<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class WorkAdditionalType extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['id', 'name', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'name', 'created_at', 'updated_at'];

    public function workAdditionals(): HasMany
    {
        return $this->hasMany(WorkAdditional::class);
    }
}
