<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePrintSettings extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'module_print_settings';

    protected $fillable = ['type', 'name', 'value'];
}
