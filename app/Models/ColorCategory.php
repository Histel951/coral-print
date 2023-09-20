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
 * @property Color|BelongsToMany|Collection $colors
 */
class ColorCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_color_categories', 'color_category_id');
    }
}
