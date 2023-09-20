<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTmplvar extends Model
{
    use HasFactory;

    protected $casts = [
        'editor_type' => 'int',
        'category' => 'int',
        'locked' => 'int',
        'rank' => 'int',
        'createdon' => 'int',
        'editedon' => 'int',
        'properties' => 'array',
    ];

    protected $fillable = [
        'type',
        'name',
        'caption',
        'description',
        'editor_type',
        'category',
        'locked',
        'elements',
        'rank',
        'display',
        'display_params',
        'default_text',
        'properties',
    ];

    protected $dateFormat = 'U';
}
