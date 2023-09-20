<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property Calculator $calculator
 * @property int $form_id
 * @property PrintForm $form
 * @property int $cutting_id
 * @property Cutting $cutting
 * @property string $svg_id
 * @property int $height
 * @property int $width
 */
class Preview extends Model
{
    use HasFactory;
    use Attachable;
    use Filterable;
    use AsSource;

    protected $fillable = [
        'image',
        'calculator_id',
        'calculator_type_id',
        'cutting_id',
        'form_id',
        'is_volume',
        'is_mounting_film',
        'sequence',
        'is_changeable',
        'dependence',
        'is_split',
        'description',
        'print_size_id',
        'coefficient_h',
        'coefficient_w',
        'height',
        'width',
        'preview_bracer_id',
        'svg_id',
        'is_rounding_corners',
        'form_type',
        'color_count_id',
        'folds',
    ];

    protected array $allowedSorts = [
        'id',
        'calculator_id',
        'calculator_type_id',
        'cutting_id',
        'form_id',
        'is_volume',
        'is_mounting_film',
    ];

    protected array $allowedFilters = [
        'id',
        'calculator_id',
        'calculator_type_id',
        'cutting_id',
        'form_id',
        'is_volume',
        'is_mounting_film',
    ];

    public function colorCount(): BelongsTo
    {
        return $this->belongsTo(ColorCount::class, 'color_count_id', 'id');
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id', 'id');
    }

    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class, 'cutting_id', 'id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(PrintForm::class, 'form_id', 'id');
    }

    public function previewImage(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image')->withDefault();
    }

    public function printSize(): BelongsTo
    {
        return $this->belongsTo(PrintSize::class, 'print_size_id', 'id');
    }

    public function bracer(): BelongsTo
    {
        return $this->belongsTo(PreviewBracer::class, 'preview_bracer_id', 'id');
    }

    public function previewPrintSizePixels(): HasMany
    {
        return $this->hasMany(PreviewPrintSizePixel::class, 'preview_id', 'id');
    }
}
