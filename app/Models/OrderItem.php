<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public const TABLE = 'order_items';
    protected $table = self::TABLE;

    protected $fillable = [
        'order_id',
        'name',
        'count',
        'product_count',
        'product_price',
        'design_price',
        'item_price',
        'total_price',
        'design_services',
        'client_designs',
        'design_comment',
        'weight',
        'props',
    ];

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
