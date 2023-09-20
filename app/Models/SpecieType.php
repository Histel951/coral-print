<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SpecieType extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = [
        'name',
        'type_name',
        'is_white_print',
        'height',
        'width',
        'type',
        'duplex',
        'value_id',
        'print_specie_id',
        'index_name',
        'is_paints',
    ];

    protected array $allowedFilters = [
        'name',
        'type_name',
        'is_white_print',
        'height',
        'width',
        'type',
        'duplex',
        'value_id',
        'print_specie_id',
    ];

    protected array $allowedSorts = [
        'name',
        'type_name',
        'is_white_print',
        'height',
        'width',
        'type',
        'duplex',
        'value_id',
        'print_specie_id',
        'index_name',
    ];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_specie_types', 'specie_type_id');
    }

    public function printSpecie(): BelongsTo
    {
        return $this->belongsTo(PrintSpecie::class);
    }

    public function paints(): HasMany
    {
        return $this->hasMany(SpecieTypePaint::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(SpecieTypePrice::class, 'species_type_id', 'id');
    }

    public function restrictionMessage(): BelongsToMany
    {
        return $this->belongsToMany(
            PrintRestrictionMessage::class,
            'pivot_print_restriction_messages',
            'specie_type_id',
        );
    }
}
