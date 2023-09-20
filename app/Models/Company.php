<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public const TABLE = 'companies';
    protected $table = self::TABLE;

    protected $fillable = ['name', 'inn'];
}
