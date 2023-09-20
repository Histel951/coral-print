<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class CalendarDesignSubcategory extends Model
{
    use HasFactory;

    protected $table = 'calendar_design_subcategory';

    protected $fillable = ['name', 'calendar_design_category_id'];

    public function category(): HasOne
    {
        return $this->hasOne(CalendarDesignCategory::class, 'id', 'calendar_design_category_id');
    }

    public function categoryName(): Collection
    {
        return $this->category()->get();
    }
}
