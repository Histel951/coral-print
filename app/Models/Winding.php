<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;

class Winding extends Model
{
    use HasFactory;

    protected $fillable = ['image_id', 'preview_id', 'sequence'];

    public function windingCategories(): BelongsToMany
    {
        return $this->belongsToMany(WindingCategory::class, 'winding_categories_windings', 'winding_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }

    public function preview(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'preview_id')->withDefault();
    }
}
