<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoilingColors extends Model
{
    use HasFactory;

    public function calculator()
    {
        return $this->belongsTo(Calculator::class);
    }
}
