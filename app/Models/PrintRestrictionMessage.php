<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintRestrictionMessage extends Model
{
    use HasFactory;

    protected $fillable = ['error_field', 'message'];
}
