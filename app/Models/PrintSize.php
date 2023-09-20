<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrintSize extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name', 'height', 'width'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function previewPrintSizePixels(): HasMany
    {
        return $this->hasMany(PreviewPrintSizePixel::class, 'print_size_id', 'id');
    }
}
