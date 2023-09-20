<?php

namespace App\Models;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property Tooltip|Collection $tooltips
 * @property Calculator|Collection $calculators
 * @property string $name
 * @property int $id
 */
class CalculatorType extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'id',
        'name',
        'calculator_type_page_id',
        'calculator_type_preview_option_id',
        'show_print_type',
        'review_title',
    ];

    protected array $allowedFilters = ['id', 'name'];

    protected array $allowedSorts = ['id', 'updated_at', 'created_at'];

    public function foilings(): HasMany
    {
        return $this->hasMany(Foiling::class);
    }

    public function printSizes(): HasMany
    {
        return $this->hasMany(PrintSize::class);
    }

    public function printTypes(): HasMany
    {
        return $this->hasMany(PrintType::class);
    }

    public function printForms(): HasMany
    {
        return $this->hasMany(PrintForm::class);
    }

    public function cuttings(): HasMany
    {
        return $this->hasMany(Cutting::class);
    }

    public function calculators(): HasMany
    {
        return $this->hasMany(Calculator::class, 'calculator_type_id', 'id');
    }

    public function additionalWorks(): HasMany
    {
        return $this->hasMany(WorkAdditional::class, 'calculator_type_id', 'id');
    }

    public function configs(): HasMany
    {
        return $this->hasMany(CalculatorTypeConfig::class, 'calculator_type_id', 'id');
    }

    public function designs(): HasMany
    {
        return $this->hasMany(Design::class, 'calculator_type_id', 'id');
    }

    public function routes(): HasMany
    {
        return $this->hasMany(CalculatorTypeRoute::class, 'calculator_type_id', 'id');
    }

    public function foilingColors(): BelongsToMany
    {
        return $this->belongsToMany(FoilingColor::class, 'pivot_calculator_type_foiling_color', 'calculator_type_id');
    }

    public function foilingColorsWithoutNone(): BelongsToMany
    {
        return $this->belongsToMany(
            FoilingColor::class,
            'pivot_calculator_type_foiling_color',
            'calculator_type_id',
        )->wherePivot('foiling_color_id', '!=', 63);
    }

    public function pageSelect(): HasMany
    {
        return $this->hasMany(PageSelect::class);
    }

    public function tooltips(): HasMany
    {
        return $this->hasMany(Tooltip::class)->where('is_active', true);
    }

    public function advantages(): HasMany
    {
        return $this->hasMany(Advantages::class);
    }

    public function previewOptions(): BelongsTo
    {
        return $this->belongsTo(CalculatorTypePreviewOption::class, 'calculator_type_preview_option_id', 'id');
    }

    public function galleryCategories(): HasMany
    {
        return $this->hasMany(GalleryCategory::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
