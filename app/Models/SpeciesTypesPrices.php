<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeciesTypesPrices extends Model
{
    use HasFactory;

    protected $table = 'coral_species_types_prices';

    protected $fillable = ['quantity', 'price', 'overprice', 'species_types_id'];

    public function specieType(): HasOne
    {
        return $this->hasOne(SpeciesTypes::class, 'id', 'specie_type_id');
    }
}
