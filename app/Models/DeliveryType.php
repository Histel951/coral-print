<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryType extends Model
{
    public const TABLE = 'delivery_types';
    protected $table = self::TABLE;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
