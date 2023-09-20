<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property int $sequence
 * @property BelongsToMany|Calculator $calculator
 * @property Attachment $spec_icon
 * @property BelongsToMany|FoilingColor|Collection $colors
 */
class Foiling extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['name', 'sequence', 'is_none', 'is_congregation', 'spec_icon_id'];

    protected array $allowedFilters = ['id', 'name'];

    protected array $allowedSorts = ['id', 'created_at', 'updated_at'];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_foilings', 'foiling_id');
    }

    public function specIcon(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'spec_icon_id')->withDefault();
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(FoilingColor::class, 'pivot_foiling_colors', 'foiling_id');
    }

    public function additionalWorks(): HasMany
    {
        return $this->hasMany(WorkAdditional::class, 'foiling_id', 'id');
    }
}
