<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function galleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class, 'category_gallery');
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id');
    }
}
