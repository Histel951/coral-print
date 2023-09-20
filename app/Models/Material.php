<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property bool $is_show
 * @property int $ribbon_id
 * @property Collection|Ribbon $ribbons
 * @property MaterialVarieties $variety
 */
class Material extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Attachable;

    protected $fillable = [
        'name',
        'type_name',
        'desc',
        'price_percent',
        'price',
        'cost_price',
        'extra_change',
        'max_size',
        'article',
        'min_meters',
        'print_specie_id',
        'sequence',
        'width',
        'weight',
        'is_hex',
        'material_type_id',
        'material_category_id',
        'volume',
        'is_show',
        'material_variety_id',
        'ribbon_id'
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'desc',
        'price_percent',
        'price',
        'cost_price',
        'extra_change',
        'max_size',
        'article',
        'min_meters',
        'print_specie_id',
        'sequence',
        'width',
        'weight',
        'is_hex',
        'material_type_id',
        'material_category_id',
        'volume',
        'is_show',
    ];

    protected array $allowedSorts = [
        'id',
        'price_percent',
        'price',
        'cost_price',
        'extra_change',
        'max_size',
        'min_meters',
        'print_specie_id',
        'sequence',
        'width',
        'weight',
        'material_type_id',
        'material_category_id',
        'volume',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id', 'id');
    }

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_materials', 'material_id');
    }

    public function printRef(): BelongsToMany
    {
        return $this->belongsToMany(PrintModel::class, 'pivot_calculator_materials', 'material_id', 'print_id');
    }

    public function foiling(): BelongsTo
    {
        return $this->belongsTo(Foiling::class);
    }

    public function printType(): BelongsTo
    {
        return $this->belongsTo(PrintType::class);
    }

    public function printSpecie(): BelongsTo
    {
        return $this->belongsTo(PrintSpecie::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id', 'id');
    }

    /**
     * Тоже самое что и coral_material_types в старой,
     * но по другому потому что такое название таблицы нелогичное и уже имеется в новой базе
     * @return HasMany
     */
    public function materialSubTypes(): HasMany
    {
        return $this->hasMany(MaterialSubType::class);
    }

    public function variety(): BelongsTo
    {
        return $this->belongsTo(MaterialVarieties::class, 'material_variety_id', 'id');
    }

    public function ribbons(): BelongsToMany
    {
        return $this->belongsToMany(Ribbon::class, 'ribbon_id', 'material_id');
    }
}
