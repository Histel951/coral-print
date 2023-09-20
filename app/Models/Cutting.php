<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property int $cutting_type_id
 * @property CuttingType $cutting_type
 */
class Cutting extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name', 'cutting_type_id', 'is_volume'];

    protected array $allowedFilters = ['id', 'name', 'cutting_type_id'];

    protected array $allowedSorts = ['id', 'cutting_type_id', 'created_at', 'updated_at'];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_cuttings', 'cutting_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CuttingType::class, 'cutting_type_id', 'id');
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Departure::class);
    }
}
