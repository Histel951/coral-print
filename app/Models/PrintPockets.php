<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintPockets extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['print_specie_id', 'quantity', 'price_1', 'price_2', 'price_3', 'overprice'];
}
