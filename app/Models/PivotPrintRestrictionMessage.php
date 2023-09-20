<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotPrintRestrictionMessage extends Model
{
    use HasFactory;

    protected $fillable = ['print_restriction_message_id', 'print_restriction_id', 'specie_type_id'];
}
