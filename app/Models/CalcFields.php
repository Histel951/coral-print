<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalcFields extends Model
{
    use HasFactory;

    protected $table = 'calc_fields';

    protected $fillable = ['name', 'alias', 'calc_category_id'];

    public function fieldsList(): HasMany
    {
        return $this->hasMany(CalcFieldsList::class, 'calc_fields_id', 'id');
    }
}
