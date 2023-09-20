<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property CalculatorType $calculatorType
 * @property FormField $field
 */
class Tooltip extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected array $allowedSorts = ['calculator_type_id'];

    protected array $allowedFilters = ['id', 'name', 'type', 'calculator_type_id', 'field_id', 'is_active'];

    protected $fillable = ['name', 'type', 'description', 'content', 'calculator_type_id', 'field_id', 'is_active'];

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class)->withDefault();
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(FormField::class)->withDefault();
    }
}
