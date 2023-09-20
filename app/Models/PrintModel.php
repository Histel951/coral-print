<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 */
class PrintModel extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $table = 'prints';

    protected $fillable = ['name', 'print_type_id'];

    protected array $allowedFilters = ['id', 'name', 'print_type_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'print_type_id', 'created_at', 'updated_at'];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_prints', 'print_id');
    }

    public function printType(): BelongsTo
    {
        return $this->belongsTo(PrintType::class);
    }
}
