<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class FlexColorPaint extends Model
{
    use Filterable;
    use AsSource;
    use HasFactory;

    protected array $allowedFilters = ['id', 'name', 'consumption', 'price', 'price_percent'];

    protected array $allowedSorts = ['id', 'name', 'consumption', 'price', 'price_percent'];

    protected $fillable = ['name', 'consumption', 'price', 'price_percent', 'image_id'];

    public function color(): BelongsToMany
    {
        return $this->belongsToMany(FlexColor::class, 'pivot_color_paint', 'color_paint_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }
}
