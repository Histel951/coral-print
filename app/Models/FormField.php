<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $type
 * @property string $name
 * @property int $sequence
 * @property array $value
 * @property array $parameters
 */
class FormField extends Model
{
    use HasFactory;

    protected $casts = [
        'parameters' => 'array',
    ];

    protected $fillable = ['name', 'type', 'parameters', 'sequence', 'value'];

    public function sequenceField(): HasMany
    {
        return $this->hasMany(FormFieldsSequence::class, 'form_field_id');
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Tooltip::class, 'pivot_tooltips', 'field_id', 'tooltip_id');
    }
}
