<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarDesignCategory extends Model
{
    use HasFactory;

    protected $table = 'calendar_design_category';

    protected $fillable = ['name'];

    public function subcategories()
    {
        return $this->hasMany(CalendarDesignSubcategory::class, 'calendar_design_category_id', 'id');
    }
}
