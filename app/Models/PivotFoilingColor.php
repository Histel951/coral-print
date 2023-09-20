<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotFoilingColor extends Model
{
    use HasFactory;

    protected $fillable = ['foiling_color_id', 'foiling_id'];
}
