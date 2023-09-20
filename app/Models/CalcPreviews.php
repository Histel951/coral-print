<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalcPreviews extends Model
{
    use HasFactory;

    protected $table = 'calc_previews';

    protected $fillable = ['calc_category_id', 'calc_form_id', 'calc_type_id', 'calc_cutting_id', 'image'];

    public function fields(): HasOne
    {
        return $this->hasOne(CalcFieldsList::class, 'id', 'calc_field_list_id');
    }
}
