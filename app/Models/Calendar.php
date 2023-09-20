<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendar';
    protected $fillable = ['name'];

    public function sizes(): HasMany
    {
        return $this->hasMany(CalendarSize::class, 'calendar_id', 'id');
    }
}
