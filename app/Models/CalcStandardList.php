<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalcStandardList extends Model
{
    use HasFactory;

    protected $table = 'calc_standard_lists';

    protected $fillable = ['calc_fields_id', 'calc_category_id', 'name', 'ids', 'alias'];

    public function fieldAlias(): HasOne
    {
        return $this->hasOne(CalcFields::class, 'alias', 'calc_fields_alias');
    }
}
