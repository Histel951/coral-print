<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobPrices extends Model
{
    use HasFactory;

    protected $table = 'coral_job_prices';

    protected $fillable = ['list_meters', 'circulation', 'price', 'fixed_sum', 'percent', 'charge', 'job_type_id'];

    public function jobType(): HasOne
    {
        return $this->hasOne(JobTypes::class, 'id', 'job_type_id');
    }
}
