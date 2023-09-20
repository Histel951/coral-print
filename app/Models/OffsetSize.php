<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffsetSize extends Model
{
    use HasFactory;

    protected $table = 'offset_size';
    protected $fillable = ['name', 'image', 'color', 'lam', 'offset_id'];

    public function prices()
    {
        return $this->hasMany(OffsetPrice::class, 'id', 'offset_size_id');
    }
    public function material()
    {
        return $this->hasOne(OffsetMaterial::class, 'id', 'offset_material_id');
    }
}
