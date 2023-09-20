<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormFieldsSequence extends Model
{
    use HasFactory;

    protected $fillable = ['form_field_id', 'calculator_id', 'sequence'];

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'form_field_id', 'id');
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }
}
