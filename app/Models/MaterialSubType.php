<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * coral_material_types из старой базы но с другим названием таблицы
 * потому что старое нелогичное и material_types уже есть в новой
 */
class MaterialSubType extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'cost_price',
        'extra_change',
        'price',
        'image_id',
        'sequence',
        'material_id',
        'color',
        'hex',
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'cost_price',
        'extra_change',
        'price',
        'image_id',
        'sequence',
        'material_id',
        'color',
        'hex',
        'created_at',
        'updated_at',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'cost_price',
        'extra_change',
        'price',
        'image_id',
        'sequence',
        'material_id',
        'color',
        'hex',
        'created_at',
        'updated_at',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }
}
