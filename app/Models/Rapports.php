<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapports extends Model
{
    use HasFactory;

    protected $table = 'rapports';

    protected $fillable = ['rapport_name', 'rapport_length'];
}
