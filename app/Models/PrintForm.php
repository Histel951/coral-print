<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 */
class PrintForm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'calculator_type_id', 'is_diameter'];

    protected $guarded = false;

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_print_forms', 'print_form_id');
    }

    public function departure(): HasOne
    {
        return $this->hasOne(Departure::class);
    }

    public function rapportKnifes(): HasMany
    {
        return $this->hasMany(RapportKnife::class, 'print_form_id', 'id');
    }
}
