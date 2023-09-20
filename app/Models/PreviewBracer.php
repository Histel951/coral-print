<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreviewBracer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function previews(): HasMany
    {
        return $this->hasMany(Preview::class, 'preview_bracer_id', 'id');
    }
}
