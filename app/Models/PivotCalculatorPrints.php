<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PivotCalculatorPrints extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['calculator_id', 'print_id', 'calculator_sub'];

    protected array $allowedFilters = ['id', 'calculator_id', 'print_id', 'calculator_sub', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'calculator_id', 'print_id', 'calculator_sub', 'created_at', 'updated_at'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function print(): BelongsTo
    {
        return $this->belongsTo(PrintModel::class, 'print_id', 'id');
    }

    public function calculatorSub(): BelongsTo
    {
        return $this->belongsTo(CalculatorSub::class, 'calculator_sub_id', 'id');
    }
}
