<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;

class Design extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['name', 'design_subcategory_id', 'calculator_type_id', 'image_id'];

    protected array $allowedFilters = ['id', 'design_subcategory_id', 'calculator_type_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'design_subcategory_id', 'calculator_type_id', 'created_at', 'updated_at'];

    public function scopeWhereCalculatorType(Builder $query, int $calculatorTypeId): Builder
    {
        return $query->where('calculator_type_id', $calculatorTypeId);
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(DesignPrice::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(DesignSubcategory::class, 'design_subcategory_id', 'id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image')->withDefault();
    }
}
