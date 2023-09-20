<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaterialTypes extends Model
{
    use HasFactory;

    protected $table = 'material_types';

    protected $fillable = ['name', 'color', 'image', 'sequence', 'material_id'];

    public function info(): HasOne
    {
        return $this->hasOne(Materials::class, 'id', 'material_id');
    }
}
