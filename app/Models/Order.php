<?php

namespace App\Models;

use App\Services\OrderService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Orchid\Filters\Filterable;

class Order extends Model
{
    use Filterable;

    public const TABLE = 'orders';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'email',
        'message',
        'phone',
        'payment_type_id',
        'delivery_type_id',
        'department_id',
        'company_id',
        'file_upload_id',
        'price',
        'delivery_price',
        'discount',
        'order_uuid',
        'delivery_address',
    ];

    protected $allowedSorts = ['id', 'status', 'created_at', 'updated_at'];

    protected $allowedFilters = ['created_at', 'name', 'email', 'message', 'status', 'updated_at'];

    public function scopeIsNew(Builder $query): Builder
    {
        return $query->where('status', OrderService::STATUS_NEW);
    }
    public function setEmailAttribute(string $email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(FileUpload::class, 'fileable');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }
}
