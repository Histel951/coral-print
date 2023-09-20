<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    public const TABLE = 'menu_items';

    public $timestamps = false;

    protected $table = self::TABLE;

    protected $fillable = [
        'parent_id',
        'name',
        'url',
        'order',
        'is_visible',
    ];
}
