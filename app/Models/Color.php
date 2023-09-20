<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property BelongsToMany|ColorPaint|Collection $paints
 * @property boolean $is_empty
 */
class Color extends Model
{
    use Filterable;
    use AsSource;
    use HasFactory;

    protected $fillable = ['name', 'print_id', 'is_two_side', 'color_type_id', 'is_empty'];

    protected array $allowedFilters = ['name', 'print_id', 'is_two_side', 'color_type_id'];

    protected array $allowedSorts = ['name', 'print_id', 'is_two_side', 'color_type_id'];

    protected $casts = ['is_empty'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ColorCategory::class, 'color_color_categories', 'color_id');
    }

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_colors', 'color_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ColorType::class, 'color_type_id', 'id');
    }

    public function paints(): BelongsToMany
    {
        return $this->belongsToMany(ColorPaint::class, 'pivot_color_paint', 'color_id');
    }

    public function printModel(): BelongsTo
    {
        return $this->belongsTo(PrintModel::class, 'print_id', 'id');
    }
}
