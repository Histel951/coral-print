<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlexPaint extends Model
{
    use HasFactory;

    protected $table = 'flex_paints';

    protected $fillable = ['name', 'consumption', 'price', 'price_percent', 'image'];
}
