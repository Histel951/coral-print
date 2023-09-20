<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'email_complain',
        'phone',
        'phone_link',
        'discount_value',
        'address_link_1',
        'address_link_scheme_1',
        'address_link_2',
        'yandex_review_link',
        'yandex_review_rate',
        'yandex_review_quantity',
        'google_review_link',
        'google_review_rate',
        'google_review_quantity',
        'instagram_review_link',
        'instagram_link',
        'vk_link',
        'bank_details',
        'created_at',
        'updated_at',
    ];
}
