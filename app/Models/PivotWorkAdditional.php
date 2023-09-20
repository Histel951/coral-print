<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PivotWorkAdditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculator_id',
        'work_additional_id',
        'lamination_id',
        'print_type_id',
        'cutting_id',
        'hole_id',
        'foiling_id',
        'calculator_id',
        'print_form_id',
        'is_complex_form',
        'is_mounting_film',
        'is_small_objects',
        'is_white_print',
        'is_volume',
        'foiling_color_id',
        'is_varnish',
        'calculator_sub_id',
        'plastic_id',
        'is_rounding_corners',
        'is_congregation',
        'is_cliche',
        'is_thermal_rise_face',
        'is_thermal_rise_back',
        'is_varnish_face',
        'is_varnish_back',
        'foiling_face',
        'foiling_back',
        'embossing_face',
        'embossing_back',
        'embossing_face2',
        'embossing_back2',
        'repeat',
        'color_id',
        'is_quantity_types',
        'bolt_id',
        'material_id',
        'is_folds',
        'print_specie_id',
    ];

    protected $table = 'pivot_work_additionals';

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function workAdditional(): BelongsTo
    {
        return $this->belongsTo(WorkAdditional::class);
    }

    public function lamination(): BelongsTo
    {
        return $this->belongsTo(Lamination::class);
    }

    public function printType(): BelongsTo
    {
        return $this->belongsTo(PrintType::class);
    }

    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class);
    }

    public function hole(): BelongsTo
    {
        return $this->belongsTo(Hole::class);
    }

    public function foiling(): BelongsTo
    {
        return $this->belongsTo(Foiling::class);
    }

    public function plastic(): BelongsTo
    {
        return $this->belongsTo(Plastic::class);
    }
}
