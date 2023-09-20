<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class BlockSelectFieldConfigTypes extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}
