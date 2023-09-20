<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeciesTypesPaints extends Model
{
    use HasFactory;

    protected $table = 'coral_species_types_paints';

    protected $fillable = [
        'quantity',
        'paint1',
        'paint2',
        'paint3',
        'paint4',
        'paint5',
        'paint6',
        'paint7',
        'paint8',
        'overprice',
        'species_types_id',
    ];

    public function specieType(): HasOne
    {
        return $this->hasOne(SpeciesTypes::class, 'id', 'specie_type_id');
    }
}
