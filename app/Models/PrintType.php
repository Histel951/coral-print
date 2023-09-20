<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PrintType extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name', 'calculator_type_id', 'print_specit_id'];

    protected array $allowedFilters = ['name', 'calculator_type_id', 'print_specit_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['name', 'calculator_type_id', 'print_specit_id', 'created_at', 'updated_at'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function prints(): HasMany
    {
        return $this->hasMany(PrintModel::class);
    }
}
