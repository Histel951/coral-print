<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departure extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class);
    }

    public function printForm(): BelongsTo
    {
        return $this->belongsTo(PrintForm::class);
    }
}
