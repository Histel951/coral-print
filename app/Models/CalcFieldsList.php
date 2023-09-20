<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalcFieldsList extends Model
{
    use HasFactory;

    protected $table = 'calc_fields_list';

    protected $fillable = ['calc_fields_id', 'calc_category_id', 'name', 'adds', 'image', 'alias'];

    public function field(): HasOne
    {
        return $this->hasOne(CalcFields::class, 'id', 'calc_fields_id');
    }
}
