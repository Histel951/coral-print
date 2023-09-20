<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Models\Attachment;

class File extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function attach(): BelongsTo
    {
        return $this->belongsTo(Attachment::class, 'attach_id');
    }
}
