<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PivotCalculatorMaterial extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['calculator_id', 'calculator_sub_id', 'material_id', 'print_id', 'is_white_print'];

    protected array $allowedFilters = ['id', 'calculator_id', 'material_id', 'print_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'calculator_id', 'material_id', 'print_id', 'created_at', 'updated_at'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function printModel(): BelongsTo
    {
        return $this->belongsTo(PrintModel::class, 'print_id', 'id');
    }
}
