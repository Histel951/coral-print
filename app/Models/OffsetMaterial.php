<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OffsetMaterial extends Model
{
    use HasFactory;

    protected $table = 'offset_material';

    protected $fillable = ['name', 'weight', 'volume', 'offset_size_id'];

    public function offset(): HasOne
    {
        return $this->hasOne(Offset::class, 'id', 'offset_id');
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(OffsetSize::class, 'offset_material_id', 'id');
    }
}
