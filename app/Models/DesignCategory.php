<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class DesignCategory extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;

    protected $fillable = ['name'];

    protected array $allowedFilters = ['id', 'name', 'value', 'design_id', 'created_at', 'updated_at'];

    protected array $allowedSorts = ['id', 'value', 'created_at', 'updated_at'];
}
