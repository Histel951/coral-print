<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorPage extends Model
{
    use HasFactory;

    protected $fillable = ['print_time_description', 'is_show_constructor'];

    public function calculator(): HasMany
    {
        return $this->hasMany(Calculator::class, 'calculator_page_id');
    }
}
