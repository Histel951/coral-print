<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulas extends Model
{
    use HasFactory;

    protected $table = 'coral_formulas';

    protected $fillable = ['name', 'alias'];
}
