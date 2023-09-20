<?php

namespace App\Models;

use App\Services\ReviewService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $fillable = ['name', 'email', 'title', 'comment', 'calculator_type_id', 'rate', 'status'];

    protected $allowedSorts = ['id', 'name', 'email', 'rate', 'status', 'created_at', 'updated_at'];

    protected $allowedFilters = [
        'created_at',
        'id',
        'name',
        'email',
        'title',
        'comment',
        'calculator_type_id',
        'rate',
        'status',
        'updated_at',
    ];

    public function scopeIsNew(Builder $query): Builder
    {
        return $query->where('status', ReviewService::STATUS_NEW);
    }

    public function setEmailAttribute(string $email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class)->withDefault();
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(FileUpload::class, 'fileable')->withDefault();
    }

    public function promocode(): HasOne
    {
        return $this->hasOne(Promocode::class)->withDefault();
    }
}
