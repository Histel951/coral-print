<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class DesignPrice extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name', 'value', 'design_id', 'sort'];

    protected array $allowedFilters = ['id', 'name', 'value', 'design_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'value', 'design_id', 'created_at', 'updated_at'];

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class, 'design_id', 'id');
    }
}
