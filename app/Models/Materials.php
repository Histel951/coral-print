<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materials extends Model
{
    use HasFactory;

    protected $table = 'coral_materials';

    protected $fillable = [
        'title',
        'sequence',
        'price',
        'extra_change',
        'cost_price',
        'desc',
        'alias',
        'print_specie_id',
        'material_categories_id',
        'width',
        'weight',
        'hex',
        'type_name',
    ];

    public function types(): HasMany
    {
        return $this->hasMany(MaterialTypes::class, 'material_id', 'id');
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(MaterialCategories::class, 'material_categories_id', 'id');
    }
}
