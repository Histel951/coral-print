<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SpecieTypePrice extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['quantity', 'price', 'overprice', 'species_type_id'];

    protected array $allowedFilters = ['quantity', 'price', 'overprice', 'species_type_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['quantity', 'price', 'overprice', 'species_type_id', 'created_at', 'updated_at'];

    public function specieType(): BelongsTo
    {
        return $this->belongsTo(SpecieType::class);
    }
}
