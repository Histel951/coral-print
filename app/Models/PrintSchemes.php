<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintSchemes extends Model
{
    use HasFactory;

    protected $table = 'print_schemes';

    protected $fillable = ['name', 'alias'];
}
