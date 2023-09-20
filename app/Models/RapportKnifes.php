<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportKnifes extends Model
{
    use HasFactory;

    protected $table = 'rapport_knives';

    protected $fillable = [
        'rapport_id',
        'knife_number',
        'form',
        'description',
        'width',
        'height',
        'count_rapport',
        'count_rows',
        'radius',
        'line_space',
        'row_space',
        'print_height',
        'price',
        'price_percent',
        'marking',
        'isset_knife',
        'image',
        'image_small',
        'dummy',
        'knife_number_summary',
    ];
}
