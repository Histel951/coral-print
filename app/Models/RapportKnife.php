<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property int $rapport_id
 * @property Rapport $rapport
 * @property int $radius
 * @property Attachment $image
 * @property Attachment $image_small
 * @property bool $isset_knife
 * @property string $knife_number_summary
 * @property PrintForm $printForm
 * @property bool $dummy
 */
class RapportKnife extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Attachable;

    protected $table = 'rapport_knifes';

    protected $fillable = [
        'rapport_id',
        'knife_number',
        'print_form_id',
        'width',
        'height',
        'count_rapport',
        'count_rows',
        'radius',
        'row_space',
        'line_space',
        'print_height',
        'price',
        'price_percent',
        'marking',
        'isset_knife',
        'image_id',
        'dummy',
        'knife_number_summary',
        'image_small',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'knife_number',
        'width',
        'height',
        'count_rapport',
        'count_rows',
        'radius',
        'row_space',
        'print_height',
        'price',
        'price_percent',
        'created_at',
        'updated_at',
    ];

    protected array $allowedFilters = [
        'rapport_id',
        'knife_number',
        'print_form_id',
        'width',
        'height',
        'count_rapport',
        'count_rows',
        'radius',
        'row_space',
        'line_space',
        'print_height',
        'price',
        'price_percent',
        'marking',
        'isset_knife',
        'image_id',
        'dummy',
        'knife_number_summary',
        'image_small',
    ];

    protected $casts = [
        'dummy' => 'boolean',
        'isset_knife' => 'boolean',
    ];

    public function rapport(): HasOne
    {
        return $this->hasOne(Rapport::class, 'id', 'rapport_id');
    }

    public function printForm(): HasOne
    {
        return $this->hasOne(PrintForm::class, 'id', 'print_form_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id')->withDefault();
    }

    public function imageSmall(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_small')->withDefault();
    }
}
