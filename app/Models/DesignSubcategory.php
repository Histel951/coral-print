<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class DesignSubcategory extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name', 'design_category_id'];

    protected array $allowedFilters = ['name', 'design_category_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['name', 'design_category_id', 'created_at', 'updated_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(DesignCategory::class, 'design_category_id', 'id');
    }
}
