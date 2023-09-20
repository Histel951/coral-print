<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    public const TABLE = 'page_templates';

    protected $table = self::TABLE;

    protected $fillable = ['name', 'alias', 'template'];
}
