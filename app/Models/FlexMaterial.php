<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property string $article
 * @property int $min_meters
 * @property bool $show
 */
class FlexMaterial extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $table = 'flex_materials';

    protected $fillable = [
        'name',
        'weight',
        'volume',
        'price',
        'price_percent',
        'type',
        'article',
        'min_meters',
        'show',
        'sequence',
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'weight',
        'volume',
        'price',
        'price_percent',
        'type',
        'article',
        'min_meters',
        'show',
        'sequence',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'weight',
        'volume',
        'price',
        'price_percent',
        'type',
        'article',
        'min_meters',
        'show',
        'sequence',
    ];

    protected $casts = [
        'show' => 'boolean',
    ];
}
