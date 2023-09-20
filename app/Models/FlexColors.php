<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlexColors extends Model
{
    use HasFactory;

    protected $table = 'flex_colors';

    protected $fillable = ['name', 'paints'];
}
