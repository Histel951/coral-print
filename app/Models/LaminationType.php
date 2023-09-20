<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class LaminationType extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['id', 'name'];

    protected array $allowedSorts = ['id', 'name', 'created_at', 'updated_at'];

    public function laminations(): BelongsToMany
    {
        return $this->belongsToMany(Lamination::class, 'pivot_lamination_types', 'lamination_type_id');
    }
}
