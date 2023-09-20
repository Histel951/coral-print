<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public const TABLE = 'blocks';

    protected $table = self::TABLE;

    protected $fillable = ['alias', 'content'];
}
