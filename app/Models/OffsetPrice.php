<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OffsetPrice extends Model
{
    use HasFactory;

    protected $table = 'offset_price';

    protected $fillable = ['quantity', 'price', 'offset_material_id'];

    public function size(): HasOne
    {
        return $this->hasOne(OffsetSize::class, 'id', 'offset_size_id');
    }
}
