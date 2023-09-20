<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $value
 */
class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];
}
