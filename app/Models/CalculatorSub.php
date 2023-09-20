<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Calculator $calculator
 */
class CalculatorSub extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sprintPosition(): BelongsToMany
    {
        return $this->belongsToMany(SprintPosition::class, 'pivot_calculator_sprint_positions', 'calculator_sub_id');
    }

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_subs', 'calculator_sub_id');
    }

    public function prints(): BelongsToMany
    {
        return $this->belongsToMany(PrintModel::class, 'pivot_calculator_prints', 'calculator_sub_id', 'print_id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'pivot_calculator_materials', 'calculator_sub_id');
    }

    public function laminations(): BelongsToMany
    {
        return $this->belongsToMany(Lamination::class, 'pivot_calculator_laminations', 'calculator_sub_id');
    }

    public function foilings(): BelongsToMany
    {
        return $this->belongsToMany(Foiling::class, 'pivot_calculator_foilings', 'calculator_sub_id');
    }

    public function specieType(): BelongsToMany
    {
        return $this->belongsToMany(SpecieType::class, 'pivot_calculator_specie_types', 'calculator_sub_id');
    }

    public function blockSelectFields(): HasMany
    {
        return $this->hasMany(BlockSelectFieldConfig::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'pivot_calculator_colors', 'calculator_sub_id');
    }

    public function plastic(): BelongsToMany
    {
        return $this->belongsToMany(Plastic::class, 'pivot_calculator_plastics', 'calculator_sub_id');
    }

    public function bolts(): BelongsToMany
    {
        return $this->belongsToMany(Bolt::class, 'pivot_calculator_bolts', 'calculator_sub_id');
    }
}
