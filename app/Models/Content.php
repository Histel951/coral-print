<?php

namespace App\Models;

use App\Models\Pages\PageTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Models\Attachment;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content_id',
        'parent',
        'alias',
        'title',
        'page_title',
        'long_title',
        'description',
        'content',
        'url',
        'is_folder',
        'is_visible',
        'calc_type',
        'min_price',
        'show_in_main',
        'default_calculator_id',
        'only_default_calculator_id',
        'page_template_id',
        'is_production',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'content_id', 'content_id');
    }

    public function calculators(): HasManyThrough
    {
        return $this->hasManyThrough(
            Calculator::class,
            CalculatorType::class,
            'id',
            'calculator_type_id',
            'calc_type',
            'id',
        );
    }

    public function imageFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image');
    }

    public function attachFile(): HasOneThrough
    {
        return $this->hasOneThrough(Attachment::class, File::class, 'id', 'id', 'image', 'attach_id');
    }

    public function calculatorType(): HasOne
    {
        return $this->hasOne(CalculatorType::class, 'id', 'calc_type')->withDefault();
    }

    public function pageTemplate(): HasOne
    {
        return $this->hasOne(PageTemplate::class, 'id', 'page_template_id');
    }
}
