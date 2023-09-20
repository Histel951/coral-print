<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;

class Advantages extends Model
{
    use HasFactory;

    protected $fillable = ['image_id', 'title', 'description', 'calculator_type_id'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id', 'id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }
}
