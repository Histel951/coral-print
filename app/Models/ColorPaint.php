<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property int $consumption
 * @property float $price
 * @property int $price_percent
 * @property HasOne|Attachment $image
 */
class ColorPaint extends Model
{
    use Filterable;
    use AsSource;
    use HasFactory;

    protected $table = 'color_paints';

    protected array $allowedFilters = ['id', 'name', 'consumption', 'price', 'price_percent'];

    protected array $allowedSorts = ['id', 'name', 'consumption', 'price', 'price_percent'];

    protected $fillable = ['name', 'consumption', 'price', 'price_percent', 'image_id', 'is_pantone'];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ColorPaintCategory::class, 'color_paint_color_paint_category', 'color_paint_id');
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'pivot_color_paint', 'color_paint_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }
}
