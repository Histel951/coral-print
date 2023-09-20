<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $count
 */
class Bolt extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'count'];
}
