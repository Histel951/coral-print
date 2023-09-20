<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotLaminationType extends Model
{
    use HasFactory;

    protected $fillable = ['lamination_type_id', 'lamination_id'];
}
