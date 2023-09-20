<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 */
class Lamination extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['id', 'name'];

    protected array $allowedSorts = ['id', 'name', 'created_at', 'updated_at'];

    public function type(): BelongsToMany
    {
        return $this->belongsToMany(LaminationType::class, 'pivot_lamination_types', 'lamination_id');
    }

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_laminations', 'lamination_id');
    }

    public function additionalWorks(): HasMany
    {
        return $this->hasMany(WorkAdditional::class, 'lamination_id', 'id');
    }
}
