<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalendarDesign extends Model
{
    use HasFactory;

    protected $table = 'calendar_design';

    protected $fillable = [
        'name',
        'calendar_design_subcategory_id',
        'calendar_size_id',
        'image',
        'color',
        'image_small',
        'not_available',
    ];
    public function subcategory(): HasOne
    {
        return $this->hasOne(CalendarDesignSubcategory::class, 'id', 'calendar_design_subcategory_id');
    }
}
