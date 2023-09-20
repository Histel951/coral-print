<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property ColorPaint|Collection $paints
 */
class ColorPaintCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function paints(): BelongsToMany
    {
        return $this->belongsToMany(ColorPaint::class, 'color_paint_color_paint_category', 'color_paint_category_id');
    }
}
