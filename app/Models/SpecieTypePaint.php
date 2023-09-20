<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecieTypePaint extends Model
{
    use HasFactory;

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
        'specie_type_id',
    ];

    public function specieType(): BelongsTo
    {
        return $this->belongsTo(SpecieType::class);
    }
}
