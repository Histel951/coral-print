<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PivotCalculatorCutting extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['calculator_id', 'cutting_id', 'is_volume'];

    protected array $allowedFilters = ['calculator_id', 'cutting_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['calculator_id', 'cutting_id', 'created_at', 'updated_at'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class, 'cutting_id', 'id');
    }
}
