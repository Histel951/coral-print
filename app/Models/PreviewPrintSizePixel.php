<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreviewPrintSizePixel extends Model
{
    use HasFactory;

    protected $fillable = ['preview_id', 'print_size_id', 'pixels_w', 'pixels_h'];

    public function preview(): BelongsTo
    {
        return $this->belongsTo(Preview::class, 'preview_id', 'id');
    }

    public function printSize(): BelongsTo
    {
        return $this->belongsTo(PrintSize::class, 'print_size_id', 'id');
    }
}
