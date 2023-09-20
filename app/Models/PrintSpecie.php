<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PrintSpecie extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name', 'volume', 'max_size', 'sequence'];

    protected array $allowedFilters = ['id', 'name', 'volume', 'max_size', 'sequence'];

    protected array $allowedSorts = ['id', 'max_size', 'created_at', 'updated_at', 'sequence', 'volume'];

    public function printType(): BelongsTo
    {
        return $this->belongsTo(PrintType::class);
    }

    public function specieTypes(): HasMany
    {
        return $this->hasMany(SpecieType::class);
    }
}
