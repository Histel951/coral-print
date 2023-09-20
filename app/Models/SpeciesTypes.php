<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeciesTypes extends Model
{
    use HasFactory;

    protected $table = 'coral_species_types';

    protected $casts = [
        'duplex' => 'integer',
    ];

    protected $fillable = [
        'name',
        'alias',
        'print_specie_id',
        'index_name',
        'height',
        'width',
        'value_id',
        'type',
        'duplex',
    ];

    public function printSpecie(): HasOne
    {
        return $this->hasOne(PrintSpecies::class, 'id', 'print_specie_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(SpeciesTypesPrices::class, 'species_types_id', 'id');
    }
    public function speciesTypesPaints(): HasMany
    {
        return $this->hasMany(SpeciesTypesPaints::class, 'species_types_id', 'id');
    }
}
