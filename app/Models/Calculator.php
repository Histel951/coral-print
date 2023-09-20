<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property int $min_price
 * @property CalculatorType $calculatorType
 * @property CalculatorType $calculatedCalculatorType
 * @property BelongsToMany|PrintForm|Collection $forms
 * @property BelongsToMany|PrintSize|Collection $print_sizes
 * @property BelongsToMany|PrintModel|Collection $prints
 * @property PrintForm $printForm
 * @property BelongsToMany|SpeciesTypes|Collection $specie_types
 * @property BelongsToMany|CalculatorFieldsConfig|Collection $fields
 * @property BelongsToMany|CalculatorCheckboxConfig|Collection $checkboxes
 * @property HasMany|BlockSelectFieldConfig|Collection $block_select_field
 * @property array $parameters
 * @property Material|BelongsToMany|Collection $materials
 * @property BelongsToMany $color
 * @property BelongsToMany $winding_categories
 * @property Collection $colors
 */
class Calculator extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Attachable;

    //    protected $dateFormat = 'U';

    protected $fillable = [
        'name',
        'description',
        'image_id',
        'min_price',
        'active',
        'config_id',
        'calculator_type_id',
        'sequence',
        'width_without_print',
        'parameters',
        'calculator_page_id',
        'svg_id',
        'calculated_calculator_type_id',
        'print_form_id',
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'description',
        'image_id',
        'min_price',
        'active',
        'config_id',
        'calculator_type_id',
        'sequence',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'calculator_type_id',
        'min_price',
        'created_at',
        'updated_at',
        'sequence',
    ];

    protected $casts = [
        'active' => 'boolean',
        'parameters' => 'array',
    ];

    public function calculatedCalculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculated_calculator_type_id', 'id');
    }

    public function checks(): BelongsToMany
    {
        return $this->belongsToMany(Check::class, 'pivot_calculator_checks', 'calculator_id');
    }

    public function pivotAdditionalWorks(): BelongsToMany
    {
        return $this->belongsToMany(PivotWorkAdditional::class, 'pivot_work_additional', 'additional_work_id');
    }

    public function additionalWorks(): BelongsToMany
    {
        return $this->belongsToMany(PivotWorkAdditional::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }

    public function scopeActive(Builder $query): Builder
    {
        $query->where('active', true);

        return $query;
    }

    public function configs(): HasMany
    {
        return $this->hasMany(CalculatorConfig::class);
    }

    public function prints(): BelongsToMany
    {
        return $this->belongsToMany(PrintModel::class, 'pivot_calculator_prints', 'calculator_id', 'print_id');
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id', 'id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'pivot_calculator_materials', 'calculator_id');
    }

    public function materialType(): HasOne
    {
        return $this->hasOne(MaterialType::class);
    }

    public function designs(): HasMany
    {
        return $this->hasMany(Design::class);
    }

    public function previews(): HasMany
    {
        return $this->hasMany(Preview::class);
    }

    public function cuttings(): BelongsToMany
    {
        return $this->belongsToMany(Cutting::class, 'pivot_calculator_cuttings', 'calculator_id');
    }

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(
            CalculatorConfigCondition::class,
            'pivot_calculator_config_conditions',
            'calculator_id',
        );
    }

    public function foilings(): BelongsToMany
    {
        return $this->belongsToMany(Foiling::class, 'pivot_calculator_foilings', 'calculator_id');
    }

    public function foilingColors(): HasMany
    {
        return $this->hasMany(FoilingColors::class);
    }

    public function holes(): BelongsToMany
    {
        return $this->belongsToMany(Hole::class, 'pivot_calculator_holes', 'calculator_id');
    }

    public function standardFields(): HasMany
    {
        return $this->hasMany(CalculatorStandardList::class);
    }

    public function scopeTypeConfigs(int $calculatorId): Builder
    {
        $calculator = self::find($calculatorId);
        return CalculatorTypeConfig::where('calculator_type_id', $calculator->calculator_type_id);
    }

    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(PrintForm::class, 'pivot_calculator_print_forms', 'calculator_id');
    }

    public function scopeTypeConfigsByName(int $calculatorId, string $name): Builder
    {
        $calculator = self::find($calculatorId);
        return CalculatorTypeConfig::where('calculator_type_id', $calculator->calculator_type_id)->where('name', $name);
    }

    public function printPositions(): HasMany
    {
        return $this->hasMany(PrintPosition::class);
    }

    public function colorTypes(): BelongsToMany
    {
        return $this->belongsToMany(ColorType::class, 'calculator_color_type', 'calculator_id');
    }

    public function laminations(): BelongsToMany
    {
        return $this->belongsToMany(Lamination::class, 'pivot_calculator_laminations', 'calculator_id');
    }

    public function colorsByType(string $name): HasOne
    {
        return $this->hasOne(ColorType::class)->where('name', $name);
    }

    public function checkboxes(): BelongsToMany
    {
        return $this->belongsToMany(
            CalculatorCheckboxConfig::class,
            'pivot_calculator_checkbox_configs',
            'calculator_id',
        );
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorFieldsConfig::class, 'pivot_calculator_fields_configs', 'calculator_id');
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'pivot_calculator_colors', 'calculator_id', 'color_id');
    }

    public function specieTypes(): BelongsToMany
    {
        return $this->belongsToMany(SpecieType::class, 'pivot_calculator_specie_types', 'calculator_id');
    }

    public function fieldsConfig(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorFieldsConfig::class, 'pivot_calculator_fields_configs', 'calculator_id');
    }

    public function routeProps(): HasMany
    {
        return $this->hasMany(CalculatorRouteProps::class);
    }

    public function calculatorSubs(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorSub::class, 'pivot_calculator_subs', 'calculator_id');
    }

    public function blockSelectField(): HasMany
    {
        return $this->hasMany(BlockSelectFieldConfig::class);
    }

    public function sprintPosition(): BelongsToMany
    {
        return $this->belongsToMany(SprintPosition::class, 'pivot_calculator_sprint_positions', 'calculator_id');
    }

    public function plastic(): BelongsToMany
    {
        return $this->belongsToMany(Plastic::class, 'pivot_calculator_plastics', 'calculator_id');
    }

    public function embossings(): BelongsToMany
    {
        return $this->belongsToMany(
            EmbossingType::class,
            'pivot_calculator_embossings',
            'calculator_id',
            'embossing_id',
        );
    }

    public function colorCounts(): BelongsToMany
    {
        return $this->belongsToMany(ColorCount::class, 'pivot_calculator_color_counts', 'calculator_id');
    }

    public function departure(): HasOne
    {
        return $this->hasOne(Departure::class);
    }

    public function printSizes(): BelongsToMany
    {
        return $this->belongsToMany(PrintSize::class, 'pivot_calculator_print_sizes', 'calculator_id');
    }

    public function printForm(): BelongsTo
    {
        return $this->belongsTo(PrintForm::class, 'print_form_id', 'id');
    }

    public function bolts(): BelongsToMany
    {
        return $this->belongsToMany(Bolt::class, 'pivot_calculator_bolts', 'calculator_id');
    }

    public function restrictions(): HasMany
    {
        return $this->hasMany(CalculatorRestriction::class, 'calculator_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(CalculatorPage::class, 'calculator_page_id', 'id');
    }

    public function windingCategories(): BelongsToMany
    {
        return $this->belongsToMany(WindingCategory::class, 'calculators_winding_categories', 'calculator_id');
    }

    public function modelTextDataMessage(): BelongsToMany
    {
        return $this->belongsToMany(ModelTextDataMessage::class, 'calculator_model_text_data_message', 'calculator_id');
    }

    public function fieldsSequence(): HasMany
    {
        return $this->hasMany(FormFieldsSequence::class, 'calculator_id', 'id');
    }
}
