<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class FoilingColor extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['name', 'image_id'];

    protected array $allowedFilters = ['name', 'image_id'];

    protected array $allowedSorts = ['name', 'created_at', 'updated_at'];

    public function foiling(): BelongsToMany
    {
        return $this->belongsToMany(Foiling::class, 'pivot_foiling_colors', 'foiling_color_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }
}
