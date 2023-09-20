<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property float $rapport_length
 */
class Rapport extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name', 'rapport_length'];

    protected array $allowedFilters = ['id', 'name', 'rapport_length'];

    protected array $allowedSorts = ['id', 'name', 'rapport_length'];

    public function knifes(): HasMany
    {
        return $this->hasMany(RapportKnife::class, 'rapport_id');
    }
}
