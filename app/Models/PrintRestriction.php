<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PrintRestriction extends Model
{
    use HasFactory;

    protected $fillable = ['height', 'min_height', 'width', 'min_width'];

    public function calculators(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_print_restrictions', 'print_restriction_id');
    }

    public function restrictionMessage(): BelongsToMany
    {
        return $this->belongsToMany(
            PrintRestrictionMessage::class,
            'pivot_print_restriction_messages',
            'print_restriction_id',
        );
    }
}
