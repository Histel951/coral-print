<?php

namespace App\Models\Gallery;

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['name'];

    public function files(): HasMany
    {
        return $this->hasMany(GalleryFile::class);
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id');
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(GalleryCategory::class, 'category_gallery');
    }

    public function scopeNonUsedElementsInCategory(Builder $builder, $calculatorTypeId, $categoryId)
    {
        $builder->where('calculator_type_id', $calculatorTypeId);
        $builder->whereDoesntHave(
            'categories',
            fn (Builder $builder) => $builder->where('gallery_category_id', $categoryId),
        );

        return $builder;
    }
}
