<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlockSelectFieldConfig;
use App\Models\BlockSelectFieldConfigTypes;
use App\Models\Calculator;
use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorConfig;
use App\Models\CalculatorConfigCondition;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorRouteProps;
use App\Models\CalculatorSub;
use App\Models\CalculatorType;
use App\Models\CalculatorTypeConfig;
use App\Models\CalculatorTypeRoute;
use App\Models\Color;
use App\Models\ColorCount;
use App\Models\ColorPaint;
use App\Models\Cutting;
use App\Models\CuttingType;
use App\Models\Departure;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\DesignPrice;
use App\Models\DesignSubcategory;
use App\Models\EmbossingType;
use App\Models\File as FileModel;
use App\Models\FoilingColor;
use App\Models\FormField;
use App\Models\Lamination;
use App\Models\LaminationType;
use App\Models\Material;
use App\Models\Materials;
use App\Models\MaterialType;
use App\Models\PivotCalculatorBlockSelectFields;
use App\Models\PivotCalculatorCheckboxConfig;
use App\Models\PivotCalculatorColor;
use App\Models\PivotCalculatorColorCount;
use App\Models\PivotCalculatorConfigCondition;
use App\Models\PivotCalculatorCutting;
use App\Models\PivotCalculatorEmbossing;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorFoiling;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorMaterial;
use App\Models\PivotCalculatorPlastic;
use App\Models\PivotCalculatorPrintForm;
use App\Models\PivotCalculatorPrints;
use App\Models\PivotCalculatorSpecieType;
use App\Models\PivotCalculatorSprintPosition;
use App\Models\PivotCalculatorSub;
use App\Models\PivotFoilingColor;
use App\Models\PivotLaminationType;
use App\Models\PivotWorkAdditional;
use App\Models\PivotWorkAdditionalPrice;
use App\Models\Plastic;
use App\Models\PrintModel;
use App\Models\PrintPosition;
use App\Models\PrintSize;
use App\Models\PrintSpecie;
use App\Models\PrintType;
use App\Models\SpecieType;
use App\Models\SpecieTypePaint;
use App\Models\SpecieTypePrice;
use App\Models\SprintPosition;
use App\Models\WorkAdditional;
use App\Models\WorkAdditionalPrice;
use App\Models\WorkAdditionalType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\File;
use stdClass;

//sail php artisan migrate:rollback && sail php artisan migrate && sail php artisan db:seed --class=UserSeeder && sail php artisan db:seed --class=ContentsSeeder && sail php artisan db:seed --class=SettingsSeeder &&  sail php artisan db:seed --class=DepartmentsSeeder && sail php artisan db:seed --class=NewStructSeed

class NewStructSeed extends Seeder
{
    /**
     * Таблички новой структурны
     * @var array|string[]
     */
    protected array $tables = [
        'calculators',
        'calculator_types',
        'foilings',
        'foiling_colors',
        'print_forms',
        'print_sizes',
        'print_species',
        'print_types',
        'prints',
        'design_categories',
        'design_subcategories',
        'designs',
        'design_prices',
        'lamination_types',
        'laminations',
        'cutting_types',
        'cuttings',
        'materials',
        'material_types',
        'material_sub_types',
        'material_categories',
        'calculator_configs',
        'calculator_type_configs',
        'global_configs',
        'rapport_knifes',
        'rapports',
        'colors',
        'color_types',
        'color_paints',
        'print_positions',
        'work_additionals',
        'work_additional_prices',
        'work_additional_types',
        'pivot_work_additionals',
        'specie_types',
        'specie_type_paints',
        'specie_type_prices',
        'pivot_calculator_materials',
        'pivot_calculator_laminations',
        'pivot_calculator_cuttings',
        'pivot_calculator_prints',
        'pivot_lamination_types',
        'pivot_calculator_foilings',
        'pivot_calculator_config_conditions',
        'calculator_config_conditions',
        'calculator_checkbox_configs',
        'pivot_calculator_checkbox_configs',
        'calculator_fields_configs',
        'pivot_calculator_fields_configs',
        'calculator_route_props',
        'pivot_calculator_fields_configs',
        'previews',
        'files'
    ];

    /**
     * Тип калькуляторов стикеры
     * @var CalculatorType|Builder
     */
    private CalculatorType|Builder $stickersCalculatorType;

    /**
     * @var CalculatorType|Builder $catalogCalculatorType
     */
    private CalculatorType|Builder $catalogCalculatorType;

    /**
     * Стикеры на стекло
     * @var Calculator|Builder
     */
    private Calculator|Builder $glassesStickersCalculator;

    /**
     * Надписи и аппликации
     * @var Calculator|Builder
     */
    private Calculator|Builder $inscriptionsApplicationsCalculator;

    /**
     * Объемные наклейки todo: самый сделанный калькулятор, ориентироваться на него
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickers3DCalculator;

    /**
     * гарантийные стикеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $warrantyStickers;

    /**
     * Круглые наклейки с логотипом
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersRoundLogoCalculator;

    /**
     * Простые наклейки на бумаге
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersPaperCalculator;

    /**
     * Стикеры с печатью белым
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersWhitePrintDCalculator;

    /**
     * Наклейки с фольгой
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersFoilCalculator;

    /**
     * Наклейки на машину
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersCarCalculator;

    /**
     * Графика на стену
     * @var Calculator|Builder
     */
    private Calculator|Builder $graphicWallCalculator;

    /**
     * Прямоугольные стикеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersRectCalculator;

    /**
     * Фигурные стикеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersFigCalculator;

    /**
     * Наборы стикеров
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersSetCalculator;

    /**
     * Овальные стикеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $stickersOvalCalculator;

    /**
     * Тип калькуляторов визитки
     * @var CalculatorType|Builder $businessCardCalculatorType
     */
    private CalculatorType|Builder $businessCardCalculatorType;

    /**
     * Простые
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardSimpleCalculator;

    /**
     * С фольгированием
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardFoilingCalculator;

    /**
     * На прозрачном пластике
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardTransparentPlasticCalculator;

    /**
     * Круглые
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardCircleCalculator;

    /**
     * Сложной формы
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardComplexCalculator;

    /**
     * VIP
     * @var Calculator|Builder
     */
    private Calculator|Builder $businessCardVIPCalculator;

    /**
     * Тип калькуляторов бирки
     * @var CalculatorType|Builder $labelsCalculatorType
     */
    private CalculatorType|Builder $labelsCalculatorType;

    /**
     * Простые
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsSimpleCalculator;

    /**
     * Круглые
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsCircleCalculator;

    /**
     * Сложной формы
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsComplexCalculator;

    /**
     * Простые воблеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsSimpleWobblersCalculator;

    /**
     * Круглые воблеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsCircleWobblersCalculator;

    /**
     * Сложные воблеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsComplexWobblersCalculator;

    /**
     * Хенгеры
     * @var Calculator|Builder
     */
    private Calculator|Builder $labelsHangersCalculator;


    public function __construct()
    {
        foreach ($this->tables as $table) {
            DB::delete("delete from {$table};");
        }

        $this->stickersCalculatorType = CalculatorType::query()->create([
            'id' => 3814,
            'name' => 'stickers'
        ]);

        $this->catalogCalculatorType = CalculatorType::query()->create([
            'id' => 3854,
            'name' => 'catalogs'
        ]);

        // todo: перенести все статические данные указанные в StickersConfigHelper и связать с калькуляторами для отображения vue
        $this->glassesStickersCalculator = Calculator::query()->create([
            'id' => 3823,
            'name' => 'Стикеры на стекло',
            'description' => 'Стикеры на стекло',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->inscriptionsApplicationsCalculator = Calculator::query()->create([
            'id' => 3822,
            'name' => 'Надписи и аппликации',
            'description' => 'Надписи и аппликации',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickers3DCalculator = Calculator::query()->create([
            'id' => 3829,
            'name' => 'Объемные наклейки',
            'description' => 'Объемные наклейки',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersRoundLogoCalculator = Calculator::query()->create([
            'id' => 3815,
            'name' => 'Круглые наклейки с логотипом',
            'description' => 'Круглые наклейки с логотипом',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersRectCalculator = Calculator::query()->create([
            'id' => 3816,
            'name' => 'Прямоугольные стикеры',
            'description' => 'Прямоугольные стикеры',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersFigCalculator = Calculator::query()->create([
            'id' => 3817,
            'name' => 'Фигурные стикеры',
            'description' => 'Фигурные стикеры',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersSetCalculator = Calculator::query()->create([
            'id' => 3818,
            'name' => 'Наборы стикеров',
            'description' => 'Наборы стикеров',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersOvalCalculator = Calculator::query()->create([
            'id' => 3827,
            'name' => 'Овальные стикеры',
            'description' => 'Овальные стикеры',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->calculatorConfigs($this->stickers3DCalculator);

        $this->warrantyStickers = Calculator::query()->create([
            'id' => 3830,
            'name' => 'Гарантийные стикеры',
            'description' => 'Гарантийные стикеры',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersWhitePrintDCalculator = Calculator::query()->create([
            'id' => 3819,
            'name' => 'Стикеры с печатью белым',
            'description' => 'Стикеры с печатью белым',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersFoilCalculator = Calculator::query()->create([
            'id' => 3821,
            'name' => 'Наклейки с фольгой',
            'description' => 'Наклейки с фольгой',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersCarCalculator = Calculator::query()->create([
            'id' => 3820,
            'name' => 'Наклейки на машину',
            'description' => 'Наклейки на машину',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->graphicWallCalculator = Calculator::query()->create([
            'id' => 3824,
            'name' => 'Графика на стену',
            'description' => 'Графика на стену',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->stickersPaperCalculator = Calculator::query()->create([
            'id' => 3826,
            'name' => 'Простые наклейки на бумаге',
            'description' => 'Простые наклейки на бумаге',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->stickersCalculatorType->getKey()
        ]);

        $this->businessCardCalculatorType = CalculatorType::query()->create([
            'name' => 'businessCards',
        ]);

        $this->businessCardSimpleCalculator = Calculator::query()->create([
            'name' => 'Простые',
            'description' => 'Простые',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        $this->businessCardFoilingCalculator = Calculator::query()->create([
            'name' => 'С фольгированием',
            'description' => 'С фольгированием',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        $this->businessCardTransparentPlasticCalculator = Calculator::query()->create([
            'name' => 'На прозрачном пластике',
            'description' => 'На прозрачном пластике',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        $this->businessCardCircleCalculator = Calculator::query()->create([
            'name' => 'Круглые',
            'description' => 'Круглые',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        $this->businessCardComplexCalculator = Calculator::query()->create([
            'name' => 'Сложной формы',
            'description' => 'Сложной формы',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        $this->businessCardVIPCalculator = Calculator::query()->create([
            'name' => 'VIP',
            'description' => 'VIP',
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
        ]);

        /*$this->labelsCalculatorType = CalculatorType::query()->create([
            'name' => 'labels',
        ]);

        $this->labelsSimpleCalculator = Calculator::query()->create([
            'name' => 'Простые бирки',
            'description' => 'Простые бирки',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsCircleCalculator = Calculator::query()->create([
            'name' => 'Круглые бирки',
            'description' => 'Круглые бирки',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsComplexCalculator = Calculator::query()->create([
            'name' => 'Бирки сложной формы',
            'description' => 'Бирки сложной формы',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsSimpleWobblersCalculator = Calculator::query()->create([
            'name' => 'Простые воблеры',
            'description' => 'Простые воблеры',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsCircleWobblersCalculator = Calculator::query()->create([
            'name' => 'Круглые воблеры',
            'description' => 'Круглые воблеры',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsComplexWobblersCalculator = Calculator::query()->create([
            'name' => 'Воблеры сложной формы',
            'description' => 'Воблеры сложной формы',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);

        $this->labelsHangersCalculator = Calculator::query()->create([
            'name' => 'Хенгеры',
            'description' => 'Хенгеры',
            'calculator_type_id' => $this->labelsCalculatorType->getKey(),
        ]);*/

        Calculator::query()->create([
            'id' => 3855,
            'name' => 'Каталоги на скобах',
            'description' => 'Каталоги на скобах',
            'min_price' => 990,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey(),
            'parameters' => [
                'is_wide' => true,
                'is_low_pages' => true
            ]
        ]);

        Calculator::query()->create([
            'id' => 3856,
            'name' => 'Каталоги на пружине',
            'description' => 'Каталоги на пружине',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey()
        ]);

        Calculator::query()->create([
            'id' => 3866,
            'name' => 'Каталоги на клею (КБС)',
            'description' => 'Каталоги на клею (КБС)',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey(),
            'parameters' => [
                'is_wide' => true,
                'is_adhesive' => true
            ]
        ]);

        Calculator::query()->create([
            'id' => 3857,
            'name' => 'Брошюры на болтах',
            'description' => 'Брошюры на болтах',
            'min_price' => 30,
            'active' => true,
//            'calculator_type_id' => $this->catalogCalculatorType->getKey()
        ]);

        Calculator::query()->create([
            'id' => 3858,
            'name' => 'Презентации',
            'description' => 'Презентации',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey()
        ]);

        Calculator::query()->create([
            'id' => 3859,
            'name' => 'Блокноты',
            'description' => 'Блокноты',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey(),
            'parameters' => [
                'is_notepads' => true
            ]
        ]);

        Calculator::query()->create([
            'id' => 3860,
            'name' => 'Тетради',
            'description' => 'Тетради',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->catalogCalculatorType->getKey(),
            'parameters' => [
                'is_wide' => true,
                'is_low_pages' => true
            ]
        ]);
    }

    private function embossings(): void
    {
        $embosings = [
            'none' => 'Без тиснения',
            'gold' => 'Золото',
            'silver' => 'Серебро',
        ];

        $embosingsCalcs = [
            'none' => [
                $this->businessCardTransparentPlasticCalculator->getKey(),
                $this->businessCardVIPCalculator->getKey(),
            ],
            'gold' => [
                $this->businessCardTransparentPlasticCalculator->getKey(),
                $this->businessCardVIPCalculator->getKey()
            ],
            'silver' => [
                $this->businessCardTransparentPlasticCalculator->getKey(),
                $this->businessCardVIPCalculator->getKey()
            ],
        ];

        foreach ($embosings as $type => $embosing) {
            $newEmbosing = EmbossingType::query()->create([
                'name' => $embosing,
                'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
            ]);

            foreach ($embosingsCalcs[$type] as $embosingsCalc) {
                PivotCalculatorEmbossing::query()->create([
                    'calculator_id' => $embosingsCalc,
                    'embossing_id' => $newEmbosing->getKey(),
                ]);
            }
        }
    }

    private function colorCounts()
    {
        $colorCounts = [
            'Без печати',
            'Один цвет',
            'Два цвета',
            'Три цвета',
            'Четыре цвета',
            'Пять цветов',
            'Шесть цвевов',
            'Семь цветов',
            'Восемь цветов',
        ];

        $calcs = [
            $this->businessCardTransparentPlasticCalculator->getKey(),
            $this->businessCardVIPCalculator->getKey(),
        ];

        foreach ($colorCounts as $colorCount) {
            $model = ColorCount::query()->create([
                'name' => $colorCount,
            ]);

            foreach ($calcs as $calc) {
                PivotCalculatorColorCount::query()->create([
                    'calculator_id' => $calc,
                    'color_count_id' => $model->getKey(),
                ]);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::insert("insert into material_categories (id, name) select id, name from coral_material_categories");

        $this->printTables();
        $this->globalConfig();
        $this->calculatorPrints();
        $this->foilings();
        $this->calculatorTypeConfigs($this->stickersCalculatorType);
        $this->calculatorTypeRoutes($this->stickersCalculatorType);
        $this->prints();
        $this->departure();
        $this->colors();
        $this->additionalWork($this->stickersCalculatorType);
        $this->knifes();
        $this->laminations();
        $this->cuttings($this->stickersCalculatorType);
        $this->designs($this->stickersCalculatorType);
        $this->materials();
        $this->speciesTypes();

        $this->setPreviewFormImages();
        $this->complexFormConditions();
        $this->calculatorCheckboxes();
        $this->calculatorFields();
        $this->setRoutesForStickers();

        $this->calculatorImages();
        $this->foilingColors();
        $this->pageSelect();
        $this->calculatorSub();
        $this->sprintPosition();

        $this->embossings();
        $this->colorsWorkAdditional();
        $this->colorCounts();

        $this->previews($this->stickersCalculatorType);
        // поскольку как обычно всё забито статически
        $printSpeciePrintType = [
            21 => 14,
            35 => 15,
            24 => 14
        ];
        $this->previews($this->stickersCalculatorType);

        DB::table('specie_types')->select()->get()->map(function ($item) use ($printSpeciePrintType) {
            if (isset($printSpeciePrintType[$item->id])) {
                PrintSpecie::find($item->print_specie_id)->update([
                    'print_type_id' => $printSpeciePrintType[$item->id]
                ]);
            }
        });
    }

    protected function fieldsListIds(int $listId): Collection
    {
        $result = collect(DB::select("select * from `coral_calc_standard_lists` where `id` = {$listId} limit 1"))->first();
        return collect(explode(',', $result->ids));
    }

    protected function fieldsOption(int $listId): Collection
    {
        $listId = implode(',', $this->fieldsListIds($listId)->toArray());
        return collect(DB::select("select * from `coral_calc_fields_list` where `id` in ($listId);"));
    }

    private function foilings(): void
    {
        DB::insert("insert into foilings(id, name)
                            select id, name from coral_calc_fields_list where calc_fields_id = 4;");

        $calculatorFoilings = [
            3821 => [
                'foilings' => [23, 24],
                'print_ids' => null
            ],
            3818 => [
                'foilings' => [22, 23, 24],
                'print_ids' => [15]
            ],
        ];

        foreach ($calculatorFoilings as $calculatorId => $foilingItem) {
            if (is_null($foilingItem['print_ids'])) {
                foreach ($foilingItem['foilings'] as $foiling) {
                    PivotCalculatorFoiling::query()->create([
                        'calculator_id' => $calculatorId,
                        'foiling_id' => $foiling
                    ]);
                }
            } else {
                foreach ($foilingItem['print_ids'] as $print_id) {
                    foreach ($foilingItem['foilings'] as $foiling) {
                        PivotCalculatorFoiling::query()->create([
                            'calculator_id' => $calculatorId,
                            'foiling_id' => $foiling,
                            'print_id' => $print_id
                        ]);
                    }
                }
            }
        }
    }

    private function calculatorPrints(): void
    {
        // calculator => [prints]
        // [3855, 3856, 3866, 3857, 3858, 3859, 3860]
        $printsCalculator = [
//            3829 => [14, 17],
            3815 => [14, 15],
            3816 => [14, 15],
            3827 => [14, 15],
            3817 => [14, 15],
            3818 => [14, 15],
            3820 => [14, 17],
            3824 => [14, 17],
            3823 => [14, 17],
            3822 => [14, 17],
            3819 => [14],
            3830 => [14],
            3829 => [14],
            3842 => [14],
            3826 => [15],
            3821 => [15],
            3844 => [15],
            $this->businessCardFoilingCalculator->getKey() => [124, 125, 126],
        ];

        foreach ($printsCalculator as $calculatorId => $prints) {
            foreach ($prints as $printId) {
                PivotCalculatorPrints::query()->create([
                    'calculator_id' => $calculatorId,
                    'print_id' => $printId
                ]);
            }
        }
    }

    public function speciesTypes(): void
    {
        DB::table('coral_species_types')->select()->get()->map(function (stdClass $type) {
            $newType = SpecieType::query()->create([
                'id' => $type->id,
                'name' => $type->name,
                'type_name' => $type->alias,
                'print_specie_id' => $type->print_specie_id,
                'index_name' => $type->index,
                'height' => $type->height,
                'width' => $type->width,
                'type' => $type->type,
                'duplex' => $type->duplex ?: null,
                'value_id' => $type->value_id
            ]);

            if ($type->id == 21) {
                $whiteSpecieType = PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3819,
                    'specie_type_id' => $newType->getKey()
                ]);

                SpecieType::find($whiteSpecieType->specie_type_id)->update([
                    'is_white_print' => true
                ]);

                $whiteSpecieType = PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3842,
                    'specie_type_id' => $newType->getKey()
                ]);

                SpecieType::find($whiteSpecieType->specie_type_id)->update([
                    'is_white_print' => true
                ]);
            } elseif ($type->id == 35) {
                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3826,
                    'specie_type_id' => $newType->getKey()
                ]);

                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3821,
                    'specie_type_id' => $newType->getKey()
                ]);

                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3844,
                    'specie_type_id' => $newType->getKey()
                ]);
            } elseif ($type->id == 23) {
                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3830,
                    'specie_type_id' => $newType->getKey()
                ]);

                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => 3829,
                    'specie_type_id' => $newType->getKey()
                ]);
            }

            DB::table('coral_species_types_prices')->where('species_types_id', $newType->getKey())->get()
                ->map(function (stdClass $typePrice) use ($newType) {
                    SpecieTypePrice::query()->create([
                        'quantity' => $typePrice->quantity,
                        'price' => $typePrice->price,
                        'overprice' => $typePrice->overprice,
                        'species_type_id' => $newType->getKey()
                    ]);
                });

            DB::table('coral_species_types_paints')->where('species_types_id', $newType->getKey())->get()
                ->map(function (stdClass $typePaints) use ($newType) {
                    SpecieTypePaint::query()->create([
                        'id' => $typePaints->id,
                        'quantity' => $typePaints->quantity,
                        'paint1' => $typePaints->paint1,
                        'paint2' => $typePaints->paint2,
                        'paint3' => $typePaints->paint3,
                        'paint4' => $typePaints->paint4,
                        'paint5' => $typePaints->paint5,
                        'paint6' => $typePaints->paint6,
                        'paint7' => $typePaints->paint7,
                        'paint8' => $typePaints->paint8,
                        'overprice' => $typePaints->overprice,
                        'specie_type_id' => $typePaints->species_types_id
                    ]);
                });
        });

        // calculator => [print_id => specie_id]
        $calculatorSpecieTypes = [
            3815 => [[14 => 23], [15 => 35]],
            3816 => [[14 => 23], [15 => 35]],
            3827 => [[14 => 23], [15 => 35]],
            3817 => [[14 => 23], [15 => 35]],
            3818 => [[14 => 23], [15 => 35], [14 => 21]],
            3820 => [[14 => 23], [14 => 21]],
            3824 => [[14 => 23], [14 => 21]],
            3823 => [[14 => 23], [14 => 21]],
            3822 => [[14 => 23], [14 => 21]],

            $this->businessCardSimpleCalculator->getKey() => [null => [30]],
            $this->businessCardCircleCalculator->getKey() => [null => [30]],
            $this->businessCardComplexCalculator->getKey() => [null => [30]],
            $this->businessCardTransparentPlasticCalculator->getKey() => [null => [45]],
            $this->businessCardVIPCalculator->getKey() => [ null => [45]],
            $this->businessCardFoilingCalculator->getKey() => [[125 => 30], [126 => 30]],
        ];

        foreach ($calculatorSpecieTypes as $calculatorId => $items) {
            foreach ($items as $printSpecie) {
                foreach ($printSpecie as $print_id => $specie_type) {
                    PivotCalculatorSpecieType::query()->create([
                        'calculator_id' => $calculatorId,
                        'specie_type_id' => $specie_type,
                        'print_id' => $print_id
                    ]);
                }
            }
        }
    }

    public function printTables(): void
    {
        $printPositionImages = [
            'up' => '1644239587up.svg',
            'left' => '1644239800left.svg',
            'right' => '1644239804right.svg',
            'down' => '1644240224down.svg',
            'up-reverse' => '1644241340up-reverse.svg',
            'down-reverse' => '1644241345down-reverse.svg',
            'left-reverse' => '1644241351left-reverse.svg',
            'right-reverse' => '1644241356right-reverse.svg'
        ];

        $this->fieldsOption(23)->map(function ($printPosition) use ($printPositionImages) {
            $image = $printPositionImages[$printPosition->alias];

            $newImageFile = FileModel::query()->create([
                'name' => $image,
                'extension' => 'svg',
                'path' => "/images/calc_previews/print_position/{$image}"
            ]);

            PrintPosition::query()->create([
                'id' => $printPosition->id,
                'name' => $printPosition->name,
                'type' => $printPosition->alias,
                'type_name' => $printPosition->adds,
                'image' => $newImageFile->getKey()
            ]);
        });

        DB::insert("insert into print_forms(id, name, calculator_type_id) select id, name, calc_category_id
                                                from coral_calc_fields_list where calc_fields_id = 10;");

        $calculatorForms = [
            3830 => [54, 55, 56, 57],
            3829 => [54, 55, 56, 57],
            3819 => [54, 55, 56, 57],
            3821 => [54, 55, 56, 57],

            $this->businessCardFoilingCalculator->getKey() => [54, 55, 56, 57],
        ];

        foreach ($calculatorForms as $calculatorId => $formIds) {
            foreach ($formIds as $formId) {
                PivotCalculatorPrintForm::query()->create([
                    'calculator_id' => $calculatorId,
                    'print_form_id' => $formId
                ]);
            }
        }

        DB::insert("insert into print_sizes (id, name, short_name, height, width, calculator_type_id)
    select
        id,
        name,
        adds,
        SUBSTRING_INDEX(ccfl.adds, 'x', 1),
        SUBSTRING_INDEX(ccfl.adds, 'x', -1),
        calc_category_id
    from coral_calc_fields_list as ccfl where calc_fields_id = 6;");

        $catalogSizes = [
            [
                'h' => 105,
                'w' => 148,
                'name' => 'A6'
            ],
            [
                'h' => 148,
                'w' => 105,
                'name' => 'A6'
            ],
            [
                'h' => 148,
                'w' => 210,
                'name' => 'A5'
            ],
            [
                'h' => 210,
                'w' => 148,
                'name' => 'A5'
            ],
            [
                'h' => 210,
                'w' => 297,
                'name' => 'A4'
            ],
            [
                'h' => 297,
                'w' => 210,
                'name' => 'A4'
            ],
            [
                'h' => 297,
                'w' => 420,
                'name' => 'A3'
            ],
            [
                'h' => 420,
                'w' => 297,
                'name' => 'A3'
            ]
        ];

        foreach ($catalogSizes as $size) {
            PrintSize::query()->create([
                'name' => "{$size['name']} ({$size['h']}x{$size['w']})",
                'calculator_type_id' => 3854,
                'height' => $size['h'],
                'width' => $size['w'],
                'short_name' => "{$size['h']}x{$size['w']}"
            ]);
        }

//        DB::insert("insert into print_sizes (name, short_name, height, width, calculator_type_id)
//    select
//        CONCAT(SUBSTRING_INDEX(ccfl.name, ' ', 1), ' ', '(', SUBSTRING_INDEX(ccfl.adds, 'x', -1), 'x', SUBSTRING_INDEX(ccfl.adds, 'x', 1), 'мм)'),
//        adds,
//        SUBSTRING_INDEX(ccfl.adds, 'x', -1),
//        SUBSTRING_INDEX(ccfl.adds, 'x', 1),
//        3854
//    from coral_calc_fields_list as ccfl where calc_fields_id = 6;");

        // print_species
        DB::insert("insert into print_species(id, name, volume, max_size, print_type_id)
                            select id, name, volume, 100, 1 from coral_print_species;");



        DB::insert("insert into print_types (id, name, calculator_type_id, print_specie_id)
                            select id, name, calc_category_id, 1 from coral_calc_fields_list where calc_fields_id = 14;");

        DB::table('print_sizes')->insert(
            [
                [
                    'name' => '90x50',
                    'short_name' => '90x50',
                    'width' => '90',
                    'height' => '50',
                    'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
                ],
                [
                    'name' => '88x55',
                    'short_name' => '88x55',
                    'width' => '88',
                    'height' => '55',
                    'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
            ]
        ]
        );
    }

    private function knifes(): void
    {
        DB::insert("insert into rapports (id, name, rapport_length)
                            select id, rapport_name, CAST(REPLACE(rapport_length, ',', '.') as DECIMAL(8,2)) from coral_rapports");

        DB::insert("insert into rapport_knifes (
                            id,
                            rapport_id,
                            knife_number,
                            print_form_id,
                            width,
                            height,
                            count_rapport,
                            count_rows,
                            radius,
                            row_space,
                            line_space,
                            print_height,
                            price,
                            price_percent,
                            marking,
                            isset_knife,
                            description,
                            dummy,
                            knife_number_summary
                            ) select
                                  id,
                                  rapport_id,
                                  IF(knife_number = '', 0, knife_number),
                                  form,
                                  width,
                                  height,
                                  count_rapport,
                                  count_rows,
                                  IF(radius = '', 0, radius),
                                  IF(row_space = '', 0, row_space),
                                  CAST(REPLACE(line_space, ',', '.') as DECIMAL(8,2)),
                                  print_height,
                                  price,
                                  price_percent,
                                  marking,
                                  isset_knife,
                                  description,
                                  dummy,
                                  knife_number_summary
                              from coral_rapport_knives");
    }

    /**
     * Статически забитые данные o departure из статики старого проекта но перенесённые в базу
     * @return void
     */
    private function departure(): void
    {
        // cutting_id => departureValue
        $departures = [
            2 => 5,
            3 => 10,
            4 => 10
        ];

        foreach ($departures as $cuttingId => $departure) {
            Departure::query()->create([
                'value' => $departure,
                'cutting_id' => $cuttingId
            ]);
        }

        $departuresCalcs = [
            [
                'calculator_id' => $this->businessCardCircleCalculator->getKey(),
                'value' => 10,
            ],
            [
                'calculator_id' => $this->businessCardComplexCalculator->getKey(),
                'value' => 10,
            ],
        ];

        $departuresPrintForms = [
            [
                'print_form_id' => 54,
                'value' => 10,
            ],
            [
                'print_form_id' => 56,
                'value' => 10,
            ],
            [
                'print_form_id' => 57,
                'value' => 10,
            ],
        ];

        Departure::query()->insert($departuresCalcs);
        Departure::query()->insert($departuresPrintForms);
    }

    private function additionalWork(CalculatorType|Builder $calculatorType)
    {
        // todo: допилить подтягивание доп работ
        DB::insert("insert into formulas (name, value) select alias, name from coral_formulas");

        DB::table('formulas')->whereIn('id', [7, 6, 4])->update([
            'is_use_volume' => true
        ]);

        DB::table('coral_additional_jobs')->select()->get()->map(function (stdClass $workType) use ($calculatorType) {
            $newWorkType = WorkAdditionalType::query()->create([
                'id' => $workType->id,
                'name' => $workType->name,
                'calculator_type_id' => $calculatorType->getKey()
            ]);

            DB::table('coral_job_types')->where('job_id', $workType->id)->select()->get()->map(function (stdClass $work) use ($workType) {
                $newWork = WorkAdditional::query()->create([
                    'id' => $work->id,
                    'name' => $work->name,
                    'type_name' => $work->alias,
                    'work_additional_type_id' => $work->job_id,
                    'color' => "#{$work->color}",
                    'code' => $work->code,
                    'formula_id' => $work->formula_id,
                    'weight' => $work->weight,
                    'volume' => $work->volume,
//                    'calculator_id' => $calculator->getKey()
                ]);

                DB::table('coral_job_prices')->where('job_type_id', $work->id)->select()->get()->map(function ($price) use ($newWork) {
                    $newWorkAdditionalPrice = WorkAdditionalPrice::query()->create([
                        'id' => $price->id,
                        'list_meters' => $price->list_meters,
                        'circulation' => $price->circulation,
                        'price' => $price->price,
                        'fixed_sum' => $price->fixed_sum,
                        'percent' => $price->percent,
                        'charge' => $price->charge,
//                        'work_additional_id' => $newWork->getKey()
                    ]);

                    PivotWorkAdditionalPrice::query()->create([
                        'work_additional_id' => $newWork->getKey(),
                        'work_additional_price_id' => $newWorkAdditionalPrice->getKey()
                    ]);
                });
            });
        });

        // статические данные от старого проекта - хардкод
        // переношу в базу нового
        $staticOldProjectData = [
            'print_type_id_&&_calculator_id' => [
                [
                    'calculator_id' => [3817, 3840],
                    'works' => [48]
                ],
                [
                    'calculator_id' => [3818],
                    'works' => [49, 52],
                    'print_type_id' => 14
                ],
                [
                    'calculator_id' => [3818],
                    'works' => [49, 52],
                    'is_white_print' => true
                ],
                /*                [
                                    'calculator_id' => [3818],
                                    'works' => [50, 57]
                                ],*/
                [
                    'calculator_id' => [null],
                    'works' => [54],
                    'print_type_id' => 15
                ],
                [
                    'calculator_id' => [3829],
                    'works' => [43, 44]
                ],
                [
                    'calculator_id' => [3829],
                    'works' => [45],
                    'is_complex_form' => true
                ],
                /*                [
                                    'calculator_id' => [null],
                                    'print_type_id' => 15,
                                    'works' => [32]
                                ],*/
                [
                    'calculator_id' => [3818],
                    'works' => [48, 51]
                ],
                [
                    'calculator_id' => [3818],
                    'print_type_id' => 14,
                    'works' => [52]
                ],
                [
                    'calculator_id' => [3818],
                    'print_type_id' => 15,
                    'works' => [57, 50]
                ],
            ],
            'lamination' => [
                [
                    'lamination_id' => [46, 47],
                    'works' => [39]
                ],
                [
                    'lamination_id' => [48, 49],
                    'works' => [38]
                ],
                /*            [
                                'lamination_id' => [48, 49],
                                'works' => [38]
                            ],*/
                [
                    'lamination_id' => [50, 51],
                    'works' => [40]
                ],
                [
                    'lamination_id' => [58, 59],
                    'works' => [28]
                ],
                [
                    'lamination_id' => [60, 61],
                    'works' => [35]
                ],
                [
                    'lamination_id' => [73],
                    'works' => [37]
                ],
                [
                    'lamination_id' => [46, 47, 48, 49, 50, 51],
                    'works' => [42]
                ],
                [
                    'lamination_id' => [58, 59, 60, 61, 73],
                    'works' => [32]
                ],
                [
                    'lamination_id' => [118],
                    'works' => [36]
                ],
                [
                    'lamination_id' => [119, 120],
                    'works' => [29]
                ],
                [
                    'lamination_id' => [121],
                    'works' => [30]
                ],
                [
                    'lamination_id' => [117, 118, 119, 120, 121],
                    'works' => [31]
                ],

            ],
            'cutting_&&_print_type' => [
                [
                    'print_type_id' => 15,
                    'cutting_id' => 1,
                    'works' => [50, 51],
                ],
                /*                [
                                    'print_type_id' => 15,
                                    'cutting_id' => 1,
                                    'works' => [50, 51],
                                ],*/
                [
                    'print_type_id' => 15,
                    'cutting_id' => 2,
                    'works' => [50, 57, 51],
                ],
                [
                    'print_type_id' => 14,
                    'cutting_id' => 3,
                    'works' => [46, 51],
                ],
                [
                    'print_type_id' => 15,
                    'cutting_id' => 3,
                    'works' => [46, 51],
                ],
                [
                    'print_type_id' => 14,
                    'cutting_id' => 4,
                    'works' => [47, 49, 51],
                ],
                [
                    'print_type_id' => 15,
                    'cutting_id' => 4,
                    'works' => [47, 49, 51],
                ],
                [
                    'print_type_id' => 17,
                    'cutting_id' => 1,
                    'works' => [49, 51],
                ],
                [
                    'print_type_id' => 14,
                    'cutting_id' => 1,
                    'works' => [49, 51],
                ],
                [
                    'print_type_id' => 17,
                    'cutting_id' => 2,
                    'works' => [49, 51, 52],
                ],
                [
                    'print_type_id' => 14,
                    'cutting_id' => 2,
                    'works' => [49, 51, 52],
                ],
                [
                    'print_type_id' => 15,
                    'cutting_id' => 6,
                    'works' => [57],
                ],
            ],
            'calculator_&&_foiling' => [
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'calculator_id' => [3821, 3844, 3818],
                    'works' => [77, 32, 37],
                    'foiling_id' => 23
                ],
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'calculator_id' => [3821, 3844, 3818],
                    'works' => [77, 32, 37],
                    'foiling_id' => 24
                ],
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'calculator_id' => [3821, 3844, 3818],
                    'works' => [78],
                    'foiling_id' => 23
                ],
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'calculator_id' => [3821, 3844, 3818],
                    'works' => [79],
                    'foiling_id' => 24
                ],
                /*               [
                                   'is_mounting_film' => null,
                                   'is_small_objects' => null,
                                   'is_complex_form' => null,
                                   'print_form_id' => 57,
                                   'calculator_id' => [null],
                                   'is_volume' => true,
                                   'works' => [43, 45],
                                   'foiling_id' => null
                               ],*/
                /*             [
                                 'is_mounting_film' => null,
                                 'is_small_objects' => null,
                                 'is_complex_form' => true,
                                 'print_form_id' => null,
                                 'calculator_id' => [null],
                                 'is_volume' => true,
                                 'works' => [43, 45],
                                 'foiling_id' => null
                             ],*/
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'is_volume' => null,
                    'calculator_id' => [null],
                    'print_form_id' => 57,
                    'works' => [48],
                    'foiling_id' => null
                ],
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => true,
                    'is_volume' => null,
                    'calculator_id' => [null],
                    'print_form_id' => null,
                    'works' => [48],
                    'foiling_id' => null
                ],
                [
                    'is_mounting_film' => null,
                    'is_small_objects' => null,
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'foiling_id' => null,
                    'is_volume' => true,
                    'calculator_id' => [null],
                    'works' => [43, 44],
                ],
                [
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'is_small_objects' => null,
                    'is_mounting_film' => true,
                    'calculator_id' => [null],
                    'works' => [41],
                    'foiling_id' => null
                ],
                [
                    'is_complex_form' => null,
                    'print_form_id' => null,
                    'is_volume' => null,
                    'is_mounting_film' => true,
                    'is_small_objects' => true,
                    'calculator_id' => [null],
                    'works' => [86],
                    'foiling_id' => null
                ],
            ],
            'calculator_catalogs' => [
                [
                    'calculator_sub_id' => 1,
                    'works' => [32, 28],
                    'lamination_id' =>112
                ],
                [
                    'calculator_sub_id' => 1,
                    'works' => [32, 28],
                    'lamination_id' => 114
                ],
                [
                    'calculator_sub_id' => 1,
                    'works' => [32, 28],
                    'lamination_id' => 113,
                    'repeats' => [28 => 2]
                ],
                [
                    'calculator_sub_id' => 1,
                    'works' => [32, 28],
                    'lamination_id' => 115
                ],
                [
                    'calculator_sub_id' => 1,
                    'works' => [32, 37],
                    'lamination_id' => 116
                ],
                [
                    'calculator_id' => [3866],
                    'calculator_sub_id' => 1,
                    'works' => [54, 67, 68, 21, 18, 57, 62, 64, 16, 17]
                ],
                [
                    'calculator_id' => [3860, 3855],
                    'calculator_sub_id' => 1,
                    'works' => [54, 67, 68, 21, 18, 57, 62, 64]
                ],
                [
                    'calculator_id' => [3856, 3858],
                    'calculator_sub_id' => 1,
                    'works' => [54, 57, 12, 13, 14]
                ],
                [
                    'calculator_id' => [3856, 3858, 3859],
                    'calculator_sub_id' => 3,
                    'works' => [57]
                ],
                [
                    'calculator_id' => [3859],
                    'calculator_sub_id' => 3,
                    'works' => []
                ],
                [
                    'calculator_id' => [3859],
                    'calculator_sub_id' => 1,
                    'works' => [54, 57, 12, 13, 14]
                ],
                [
                    'calculator_sub_id' => 1,
                    'works' => [77, 79]
                ],
                [
                    'calculator_sub_id' => 1,
                    'is_varnish' => true,
                    'works' => [84, 85]
                ],
                [
                    'calculator_sub_id' => 2,
                    'calculator_id' => [3860],
                    'works' => [54]
                ],
                [
                    'calculator_sub_id' => 2,
                    'calculator_id' => [3859],
                    'works' => [54]
                ],
                [
                    'calculator_sub_id' => 2,
                    'calculator_id' => [3855, 3856, 3866, 3858],
                    'works' => [54, 57]
                ],
                [
                    'calculator_sub_id' => 2,
                    'calculator_id' => [3859, 3860],
                    'works' => [57]
                ],
                [
                    'calculator_sub_id' => 3,
                    'print_type_id' => 124,
                    'works' => [54]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 112,
                    'works' => [32, 28]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 114,
                    'works' => [32, 28]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 113,
                    'works' => [32, 28]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 115,
                    'works' => [32, 28]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 116,
                    'works' => [32, 37]
                ],
                [
                    'calculator_sub_id' => 3,
                    'lamination_id' => 117,
                    'works' => [32, 37]
                ],
                [
                    'calculator_sub_id' => 1,
                    'foiling_id' => 23,
                    'works' => [77, 79]
                ],
                [
                    'calculator_sub_id' => 1,
                    'foiling_id' => 24,
                    'works' => [77, 79]
                ],
//                [
//                    'calculator_sub_id' => 1,
//                    'foiling_id' => 24,
//                    'foiling_color_id' => 63,
//                    'works' => [null]
//                ],
//                [
//                    'calculator_sub_id' => 1,
//                    'foiling_id' => 23,
//                    'foiling_color_id' => 63,
//                    'works' => [null]
//                ],
            ]
        ];

        foreach ($staticOldProjectData['print_type_id_&&_calculator_id'] as $item) {
            foreach ($item['calculator_id'] as $calculatorId) {
                foreach ($item['works'] as $workId) {
                    $newObject = [...$item, 'calculator_id' => $calculatorId, 'work_additional_id' => $workId];
                    unset($newObject['works']);
                    PivotWorkAdditional::query()->create($newObject);
                }
            }
        }

        foreach ($staticOldProjectData['lamination'] as $item) {
            foreach ($item['lamination_id'] as $laminationId) {
                foreach ($item['works'] as $workId) {
                    $newObject = [...$item, 'lamination_id' => $laminationId,  'work_additional_id' => $workId];
                    unset($newObject['works']);
                    PivotWorkAdditional::query()->create($newObject);
                }
            }
        }

        foreach ($staticOldProjectData['cutting_&&_print_type'] as $item) {
            foreach ($item['works'] as $workId) {
                $newObject = [...$item, 'work_additional_id' => $workId];
                unset($newObject['works']);
                PivotWorkAdditional::query()->create($newObject);
            }
        }

        foreach ($staticOldProjectData['calculator_&&_foiling'] as $item) {
            if (!$item['calculator_id'][0]) {
                foreach ($item['works'] as $workId) {
                    $newObject = [...$item,  'work_additional_id' => $workId];
                    unset($newObject['works']);
                    unset($newObject['calculator_id']);
                    PivotWorkAdditional::query()->create($newObject);
                }

                continue;
            }

            foreach ($item['calculator_id'] as $calculatorId) {
                foreach ($item['works'] as $workId) {
                    $newObject = [...$item, 'calculator_id' => $calculatorId,  'work_additional_id' => $workId];
                    unset($newObject['works']);
                    PivotWorkAdditional::query()->create($newObject);
                }
            }
        }

        foreach ($staticOldProjectData['calculator_catalogs'] as $item) {
            if (isset($item['calculator_id'])) {
                foreach ($item['calculator_id'] as $calculatorId) {
                    foreach ($item['works'] as $workId) {
                        $newObject = [...$item, 'calculator_id' => $calculatorId,  'work_additional_id' => $workId];

                        if (isset($item['repeats'][$workId])) {
                            $newObject['repeat'] = $item['repeats'][$workId];
                        }

                        unset($newObject['repeats']);
                        unset($newObject['works']);
                        PivotWorkAdditional::query()->create($newObject);
                    }
                }
            } else {
                foreach ($item['works'] as $workId) {
                    $newObject = [...$item, 'work_additional_id' => $workId];

                    if (isset($item['repeats'][$workId])) {
                        $newObject['repeat'] = $item['repeats'][$workId];
                    }

                    unset($newObject['repeats']);
                    unset($newObject['works']);
                    PivotWorkAdditional::query()->create($newObject);
                }
            }
        }



        $businessCardParams = [
/*
            [
                'calculator_id' => [$this->businessCardFoilingCalculator->getKey()],
                'print_form_id' => [54, 56],
                'work_additional_id' => [46, 51],
            ],
            [
                'calculator_id' => [$this->businessCardFoilingCalculator->getKey()],
                'print_form_id' => [57],
                'work_additional_id' => [46, 48, 51],
            ],*/

            [
                'calculator_id' => [
                    $this->businessCardSimpleCalculator->getKey(),
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_rounding_corners' => [true],
                'work_additional_id' => [65, 66],
            ],
            [
                'calculator_id' => [
                    $this->businessCardFoilingCalculator->getKey(),
                ],
                'is_rounding_corners' => [true],
                'work_additional_id' => [65, 66],
            ],
            [
                'calculator_id' => [
                    $this->businessCardFoilingCalculator->getKey(),
                ],
                'foiling_face' => [true],
                'work_additional_id' => [77, 79],
            ],
            [
                'calculator_id' => [
                    $this->businessCardFoilingCalculator->getKey(),
                ],
                'foiling_back' => [true],
                'work_additional_id' => [77, 79],
            ],
            [
                'calculator_id' => [
                    $this->businessCardSimpleCalculator->getKey(),
                ],
                'work_additional_id' => [53, 56],
            ],
            [
                'calculator_id' => [
                    $this->businessCardCircleCalculator->getKey(),
                ],
                'work_additional_id' => [46, 51, 53],
            ],
            [
                'calculator_id' => [
                    $this->businessCardComplexCalculator->getKey(),
                ],
                'work_additional_id' => [46, 48, 51, 53],
            ],
            [
                'calculator_id' => [
                    $this->businessCardFoilingCalculator->getKey(),
                ],
                'work_additional_id' => [28, 28, 32, 53, 56],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'work_additional_id' => [82, 88],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'embossing_face' => [true],
                'work_additional_id' => [93, 147],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'embossing_back' => [true],
                'work_additional_id' => [93, 147],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'embossing_face2' => [true],
                'work_additional_id' => [93, 147],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'embossing_back2' => [true],
                'work_additional_id' => [93, 147],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_thermal_rise_face' => [true],
                'work_additional_id' => [95],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_thermal_rise_back' => [true],
                'work_additional_id' => [95],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_varnish_face' => [true],
                'work_additional_id' => [94],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_varnish_back' => [true],
                'work_additional_id' => [94],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_congregation' => [true],
                'work_additional_id' => [146, 147],
            ],
            [
                'calculator_id' => [
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey(),
                ],
                'is_congregation' => [true],
                'is_cliche' => [true],
                'work_additional_id' => [144],
            ],
            [
                'is_thermal_rise_face' => [true],
                'work_additional_id' => [131],
            ],
            [
                'is_thermal_rise_back' => [true],
                'work_additional_id' => [131],
            ],
            [
                'is_varnish_face' => [true],
                'work_additional_id' => [131],
            ],
            [
                'is_varnish_back' => [true],
                'work_additional_id' => [131],
            ],
            [
                'is_cliche' => [true],
                'is_congregation' => [false],
                'work_additional_id' => [96],
            ],
        ];

        foreach ($businessCardParams as $params) {
            $collection = collect($params);
            $values = $collection->values()->map(fn ($v) => collect($v));
            $rows = $values->shift()->crossJoin(...$values)->map(fn ($v) => array_combine($collection->keys()->toArray(), $v))->toArray();

            PivotWorkAdditional::query()->insert($rows);
        }
    }

    private function colors()
    {
        // получение flex цветов из старой таблицы

        DB::table("coral_flex_colors")->select('id', 'name', 'paints')->get()
            ->map(function (stdClass $color) {
                $newColor = new Color();
                $newColor->id = $color->id;
                $newColor->name = $color->name;
                $newColor->save();

                DB::table('coral_flex_paints')->select('id', 'name', 'consumption', 'price', 'price_percent')->get()
                    ->map(function (stdClass $oldPaint) use ($newColor) {
                        if ($paint = ColorPaint::find($oldPaint->id)) {
                            $newColor->paints()->attach($paint);
                        } else {
                            $paint = ColorPaint::query()->create([
                                'id' => $oldPaint->id,
                                'name' => $oldPaint->name,
                                'consumption' => $oldPaint->consumption,
                                'price' => $oldPaint->price,
                                'price_percent' => $oldPaint->price_percent
                            ]);
                            $newColor->paints()->attach($paint->getKey());
                        }
                    });
            });

        // print_id => color
        $chromaPaints = [
            124 => 'Без печати',
            125 => 'Односторонние цветные',
            126 => 'Двухсторонние цветные',
            127 => 'Односторонние черно-белая',
            128 => 'Двухсторонние черно-белая'
        ];

        foreach ($chromaPaints as $printId => $paintName) {
            Color::query()->create([
                'name' => $paintName,
                'print_id' => $printId
            ]);
        }

        $pivotChromaPaintsCalculator = [
            [
                'calculator' => 3855,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3855,
                'colors' => [11, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => 3856,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3856,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => 3856,
                'colors' => [9, 10, 11, 12, 13],
                'calculator_sub' => 3
            ],
            [
                'calculator' => 3866,
                'colors' => [10, 11],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3866,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => 3858,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3858,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => 3858,
                'colors' => [9, 10, 11, 12, 13],
                'calculator_sub' => 3
            ],
            [
                'calculator' => 3859,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3859,
                'colors' => [9, 10, 11, 12, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => 3859,
                'colors' => [9, 10, 11, 12, 13],
                'calculator_sub' => 3
            ],
            [
                'calculator' => 3860,
                'colors' => [10, 11, 12, 13],
                'calculator_sub' => 1
            ],
            [
                'calculator' => 3860,
                'colors' => [9, 11, 13],
                'calculator_sub' => 2
            ],
            [
                'calculator' => $this->businessCardSimpleCalculator->getKey(),
                'colors' =>  [14, 15],
            ],
            [
                'calculator' => $this->businessCardCircleCalculator->getKey(),
                'colors' =>  [14, 15],
            ],
            [
                'calculator' => $this->businessCardComplexCalculator->getKey(),
                'colors' =>  [14, 15],
            ],
        ];

        foreach ($pivotChromaPaintsCalculator as $item) {
            foreach ($item['colors'] as $colorId) {
                PivotCalculatorColor::query()->create([
                    'calculator_id' => $item['calculator'],
                    'color_id' => $colorId,
                    'calculator_sub_id' => $item['calculator_sub'] ?? null,
                ]);
            }
        }
        Color::query()->insert([
            [
                'name' => 'Одна сторона',
            ],
            [
                'name' => 'Две стороны',
            ],
        ]);
    }

    private function materials(): void
    {
        $materials = [
            25 => MaterialType::query()->create([
                'name' => 'thermal_labels',
                'type_name' => 'Термоэтикетки',
            ]),
            26 => MaterialType::query()->create([
                'name' => 'standard',
                'type_name' => 'Стандартный',
            ]),
            28 => MaterialType::query()->create([
                'name' => 'material_standart_list',
                'type_name' => 'Материалы стандартный список'
            ]),
            17 => MaterialType::query()->create([
                'name' => 'silver_and_gold_labels',
                'type_name' => 'Cеребряные и золотые этикетки',
            ]),
            16 => MaterialType::query()->create([
                'name' => 'volume',
                'type_name' => 'Материалы фольга объемная (только пленки)',
            ]),
            6 => MaterialType::query()->create([
                'name' => 'foiling',
                'type_name' => 'Материалы Фольга',
            ]),
            5 => MaterialType::query()->create([
                'name' => 'white_print',
                'type_name' => 'Материалы УФ печать',
            ]),
            1 => MaterialType::query()->create([
                'name' => 'inkjet',
                'type_name' => 'Материалы струйные',
            ]),
            2 => MaterialType::query()->create([
                'name' => 'laser',
                'type_name' => 'Материалы лазер',
            ]),
            3 => MaterialType::query()->create([
                'name' => 'guaranty',
                'type_name' => 'Материалы гарантийные стикеры',
            ]),
            4 => MaterialType::query()->create([
                'name' => 'simple_paper',
                'type_name' => 'Материалы простые наклейки',
            ]),
        ];

        DB::insert("insert into material_sub_types(name, cost_price, extra_change, price, sequence, material_id, color, hex)
                            select name, cmt.cost_price, cmt.extra_change, cmt.price, cmt.sequence, cmt.material_id, cmt.color, CAST(cm.hex as signed)
                            from coral_material_types cmt
                                left join coral_materials cm
                                    on cmt.material_id = cm.id");

        $coralMaterialIds = [];
        foreach ($materials as $listId => $materialType) {
            $typeMaterials = $this->fieldsListIds($listId)->toArray();
            $coralMaterialIds[] = $typeMaterials;
            DB::table('coral_materials')->whereIn('id', $typeMaterials)->select()->get()
                ->map(function ($material) use ($materialType) {
                    if ($material) {
                        if (!Material::find($material->id)) {
                            Material::query()->create([
                                'id' => $material->id,
                                'name' => $material->title,
                                'type_name' => $material->type_name,
                                'sequence' => $material->sequence,
                                'desc' => $material->desc,
                                'width' => $material->width,
                                'weight' => $material->weight,
                                'is_hex' => (bool) $material->hex,
                                'price' => (float) $material->cost_price + ($material->cost_price * ($material->extra_change / 100)),
                                'cost_price' => (float) $material->cost_price,
                                'price_percent' => (float) $material->extra_change,
                                'material_type_id' => $materialType->getKey(),
                                'print_specie_id' => $material->print_specie_id,
                                'material_category_id' => $material->material_categories_id
                            ]);
                        }
                    }
                });
        }

        $coralNotTypeMaterials = Materials::whereNotIn('id', Arr::collapse($coralMaterialIds))->get();
        if ($coralNotTypeMaterials) {
            $coralNotTypeMaterials->map(function ($material) {
                Material::query()->create([
                    'id' => $material->id,
                    'name' => $material->title,
                    'type_name' => $material->type_name,
                    'sequence' => $material->sequence,
                    'desc' => $material->desc,
                    'width' => $material->width,
                    'weight' => $material->weight,
                    'is_hex' => (bool) $material->hex,
                    'price' => (float) $material->price,
                    'cost_price' => (float) $material->cost_price,
                    'extra_change' => (float) $material->extra_change,
                    'print_specie_id' => $material->print_specie_id,
                    'material_category_id' => $material->material_categories_id
                ]);
            });
        }

        $materialFlexType = MaterialType::query()->create([
            'name' => 'flex',
            'type_name' => 'Флекса',
        ]);

        $flexMaterials = DB::table('coral_flex_materials')->select(
            'id',
            'type',
            'name',
            'article',
            'min_meters',
            'weight',
            'price',
            'price_percent',
            'show',
            'sequence',
            'volume'
        )->get();

        $flexMaterials->map(function (stdClass $flexMaterial) use ($materialFlexType) {
            $typeName = null;
            switch ($flexMaterial->type) {
                case 1:
                    $typeName = 'Пленка';
                    break;
                case 2:
                    $typeName = 'Бумага';
                    break;
                case 3:
                    $typeName = 'Термо';
                    break;
                case 4:
                    $typeName = 'Специальные';
                    break;
            }

            Material::query()->create([
                'name' => $flexMaterial->name,
                'type_name' => $typeName,
                'sequence' => $flexMaterial->sequence,
                'weight' => $flexMaterial->weight,
                'price' => (float) $flexMaterial->price,
                'cost_price' => 0,
                'extra_change' => 0,
                'article' => $flexMaterial->article,
                'min_meters' => $flexMaterial->min_meters ?: null,
                'price_percent' => $flexMaterial->price_percent,
                'volume' => $flexMaterial->volume,
                'is_show' => $flexMaterial->show,
                'material_type_id' => $materialFlexType->getKey()
            ]);
        });

        // строит таблички зависимости много ко многим, к табличкам калькуляторов - материалов
        // по статически забитым данным взятым из старого проекта
        // которые тоже забиты статически
//        $manyToManyCalculator = [
//            [
//                'calculators' => [/*3815, 3816, 3827, 3817, 3818, 3820, 3824, 3823, 3822, 3829*/],
//                'materials' => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74]
//            ],
//            [
//                'calculators' => [/*3830*/],
//                'materials' => [64]
//            ],
//            [
//                'calculators' => [3821],
//                'materials' => [47, 48, 49, 54, 77, 140]
//            ]
//        ];
//
        $standartMaterials = [
            14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
            15 => [48, 49, 77, 140, 50, 51, 52],
        ];
//
//        foreach ($manyToManyCalculator as $item) {
//            foreach ($item['calculators'] as $calculatorId) {
//                foreach ($item['materials'] as $materialId) {
//                    PivotCalculatorMaterial::query()->create([
//                        'calculator_id' => $calculatorId,
//                        'material_id' => $materialId
//                    ]);
//                }
//            }
//        }

        $calculatorMaterials = [
            3815 => $standartMaterials,
            3816 => $standartMaterials,
            3827 => $standartMaterials,
            2826 => [15 => [48]],
            3817 => $standartMaterials,
            3818 => $standartMaterials,
            3819 => [14 => [61, 22]],
            3821 => [15 => [48, 49, 77, 140, 50, 141]],

            3820 => [
                [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
                14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
            ],
            3824 => [
                [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
                14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74]
            ],
            3823 => [
                [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
                14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74]
            ],
            3822 => [
                [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74],
                14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74]
            ],
            3829 => [14 => [47, 53, 54, 55, 142, 76, 56, 65, 66, 72, 71, 69, 67, 73, 74]],
            3830 => [14 => [64]],
            3826 => [15 => [48]],
        ];

        foreach ($calculatorMaterials as $calculatorId => $calculatorMaterial) {
            foreach ($calculatorMaterial as $type => $materials) {
                foreach ($materials as $material) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'material_id' => $material,
                        'print_id' => $type ?: null,
                    ]);
                }
            }
        }

        $whitePrintMaterials = [
            3820 => [61, 22]
        ];

        foreach ($whitePrintMaterials as $calculatorId => $materials) {
            foreach ($materials as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'is_white_print' => true,
                    'print_id' => 14
                ]);
            }
        }

        $materialCalcs = [
            $this->businessCardSimpleCalculator->getKey() => [46, 79, 82, 84, 85, 86, 87, 88, 89],
            $this->businessCardFoilingCalculator->getKey() => [46,93,94,95,96,97],
            $this->businessCardTransparentPlasticCalculator->getKey() => [98],
            $this->businessCardCircleCalculator->getKey() => [46, 79, 82, 84, 85, 86, 87, 88, 89],
            $this->businessCardComplexCalculator->getKey() => [46, 79, 82, 84, 85, 86, 87, 88, 89],
            $this->businessCardVIPCalculator->getKey() => [93,94,95,96,97],
        ];

        $prints = [null, 124, 125, 126];
        foreach ($prints as $print) {
            foreach ($materialCalcs as $calcId => $materials) {
                foreach ($materials as $material) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calcId,
                        'material_id' => $material,
                        'print_id' => $print,
                    ]);
                }
            }
        }
    }

    private function prints(): void
    {
        $prints = [
            14 => PrintType::query()->create([
                'name' => 'Типы печати стандартный',
                'calculator_type_id' => $this->stickersCalculatorType->getKey()
            ]),
            15 => PrintType::query()->create([
                'name' => 'Тип печати (машина, стекло, апликации, стена)',
                'calculator_type_id' => $this->stickersCalculatorType->getKey()
            ]),
            35 => PrintType::query()->create([
                'name' => 'Тип печати стандартный',
                'calculator_type_id' => $this->stickersCalculatorType->getKey()
            ])
        ];

        foreach ($prints as $listId => $printType) {
            $this->fieldsOption($listId)->map(function ($item) use ($printType) {
                if (!PrintModel::find($item->id)) {
                    PrintModel::query()->create([
                        'id' => $item->id,
                        'name' => $item->name,
                        'print_type_id' => $printType->getKey()
                    ]);
                }
            });
        }
    }

    private function laminations(): void
    {
        // listId => type
        $laminations = [
            7 => LaminationType::query()->create([
                'name' => 'Ламинация струйная',
            ]),

            8 => LaminationType::query()->create([
                'name' => 'Ламинация лазерная'
            ]),
            29 => LaminationType::query()->create([
                'name' => 'Ламинация стандартный'
            ])
        ];

        foreach ($laminations as $listId => $laminationType) {
            $this->fieldsOption($listId)->map(function ($item) use ($laminationType) {
                PivotLaminationType::query()->create([
                    'lamination_id' => $item->id,
                    'lamination_type_id' => $laminationType->getKey()
                ]);

                if (!Lamination::find($item->id)) {
                    $newLamination = Lamination::query()->create([
                        'id' => $item->id,
                        'name' => $item->name
                    ]);
                    if ($item->id == 47
                        or $item->id == 46
                        or $item->id == 48
                        or $item->id == 49
                        or $item->id == 50
                        or $item->id == 51
                    ) {
                        /*                    PivotCalculatorLamination::query()->create([
                                                'lamination_id' => $newLamination->getKey(),
                                                'calculator_id' => 3816
                                            ]);

                                            if ($item->id == 47
                                                or $item->id == 46
                                                or $item->id == 48
                                                or $item->id == 49
                                                or $item->id == 50
                                                or $item->id == 51
                                                or $item->id == 45
                                            ) {
                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3816
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3815
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3827
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3817
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3818
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3821
                                                ]);
                                            PivotCalculatorLamination::query()->create([
                                                'lamination_id' => $newLamination->getKey(),
                                                'calculator_id' => 3820
                                            ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3820
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3824
                                                ]);

                                                PivotCalculatorLamination::query()->create([
                                                    'lamination_id' => $newLamination->getKey(),
                                                    'calculator_id' => 3823
                                                ]);
                                            }
                                            PivotCalculatorLamination::query()->create([
                                                'lamination_id' => $newLamination->getKey(),
                                                'calculator_id' => 3823
                                            ]);*/
                    }
                }
            });
        }


        $defaultlInkjetLaminations = [45, 46, 47, 48, 49, 50, 51];
        $defaultLaserLaminations = [45, 58, 59, 60, 61, 73];

        $calculatorLaminations = [
            3815 => [14 => $defaultlInkjetLaminations, 15 => $defaultLaserLaminations],
            3816 => [14 => $defaultlInkjetLaminations, 15 => $defaultLaserLaminations],
            3827 => [14 => $defaultlInkjetLaminations, 15 => $defaultLaserLaminations],
            3817 => [14 => $defaultlInkjetLaminations, 15 => $defaultLaserLaminations],
            3818 => [14 => $defaultlInkjetLaminations, 15 => $defaultLaserLaminations],
            3821 => [$defaultLaserLaminations],
            3820 => [$defaultlInkjetLaminations],
            3824 => [$defaultlInkjetLaminations],
            3823 => [$defaultlInkjetLaminations],
            3822 => [$defaultlInkjetLaminations],
        ];

        foreach ($calculatorLaminations as $calculatorId => $calculatorLamination) {
            foreach ($calculatorLamination as $type => $laminations) {
                foreach ($laminations as $lamination) {
                    PivotCalculatorLamination::query()->create([
                        'calculator_id' => $calculatorId,
                        'lamination_id' => $lamination,
                        'print_id' => $type ?: null,
                    ]);
                }
            }
        }
        $laminations = [
            'none' => 'Без ламинации',
            'soft_touch_30' => 'Soft Touch (30 мкр) 1+1',
            'mat_75' => 'Матовая (75 мкр) 1+1',
            'glossy_75' => 'Глянцевая (75 мкр) 1+1',
            'mat_125' => 'Матовая (125 мкр) 1+1',
        ];
        $laminationCalcs = [
            'none' => [
                $this->businessCardSimpleCalculator->getKey(),
                $this->businessCardFoilingCalculator->getKey(),
                $this->businessCardComplexCalculator->getKey(),
                $this->businessCardTransparentPlasticCalculator->getKey(),
                $this->businessCardVIPCalculator->getKey(),
            ],
            'soft_touch_30' => [
                $this->businessCardSimpleCalculator->getKey(),
                $this->businessCardFoilingCalculator->getKey(),
                $this->businessCardComplexCalculator->getKey(),
            ],
            'mat_75' => [
                $this->businessCardSimpleCalculator->getKey(),
                $this->businessCardFoilingCalculator->getKey(),
                $this->businessCardComplexCalculator->getKey(),
            ],
            'glossy_75' => [
                $this->businessCardSimpleCalculator->getKey(),
                $this->businessCardFoilingCalculator->getKey(),
                $this->businessCardComplexCalculator->getKey(),
            ],
            'mat_125' => [
                $this->businessCardSimpleCalculator->getKey(),
                $this->businessCardCircleCalculator->getKey(),
            ],
        ];

        foreach ($laminations as $type => $lamination) {
            if ($type != 'none') {
                $newLamination = Lamination::query()->create([
                    'name' => $lamination,
                ]);
            } else {
                $newLamination = Lamination::find(45);
            }

            foreach ($laminationCalcs[$type] as $laminationCalc) {
                PivotCalculatorLamination::query()->create([
                    'calculator_id' => $laminationCalc,
                    'lamination_id' => $newLamination->getKey(),
                ]);
            }
        }
    }

    private function designs(CalculatorType|Builder $calculator): void
    {
        $designCategory = DesignCategory::query()->create([
            'name' => 'stickers design'
        ]);

        $designSubCategory = DesignSubcategory::query()->create([
            'name' => 'stickers design sub',
            'design_category_id' => $designCategory->getKey()
        ]);

        $design = Design::query()->create([
            'name' => 'stickers',
            'calculator_type_id' => $calculator->getKey(),
            'design_subcategory_id' => $designSubCategory->getKey()
        ]);

        $stickerDesignPrices = collect(DB::select("select * from coral_site_tmplvar_contentvalues where contentid = 3057;")); // stickers
        $labelsDesignPrices = collect(DB::select("select * from coral_site_tmplvar_contentvalues where contentid = 3702;")); // labels

        $designPriceSeed = function (Collection $designPrices, Design|Builder $design): void {
            $designPrices->map(function ($designPrice) use ($design) {
                $designPricesValue = json_decode($designPrice->value, true);
                if (isset($designPricesValue['fieldValue'])) {
                    $designPricesValue = collect($designPricesValue['fieldValue']);
                    $designPricesValue->map(function ($price) use ($design) {
                        $value = (int) $price['p1'];

                        DesignPrice::query()->create([
                            'name' => $price['title'],
                            'value' => $value,
                            'design_id' => $design->getKey()
                        ]);
                    });
                }
            });
        };

        $designPriceSeed($stickerDesignPrices, $design);
        $designPriceSeed($labelsDesignPrices, $design);
    }

    private function cuttings(CalculatorType|Builder $calculatorType): void
    {
        // listId => type
        $cuttings = [
            9 => CuttingType::query()->create([
                'name' => 'Нарезка стандарная',
                'calculator_type_id' => $calculatorType->getKey()
            ]),

            10 => CuttingType::query()->create([
                'name' => 'Нарезка (машина, стекло, апликации, стена)',
                'calculator_type_id' => $calculatorType->getKey()
            ]),

            11 => CuttingType::query()->create([
                'name' => 'Нарезка объемные наклейки',
                'calculator_type_id' => $calculatorType->getKey()
            ]),

            12 => CuttingType::query()->create([
                'name' => 'Нарезка простые наклейки',
                'calculator_type_id' => $calculatorType->getKey()
            ]),

            13 => CuttingType::query()->create([
                'name' => 'Нарезка гарантийные',
                'calculator_type_id' => $calculatorType->getKey()
            ])
        ];

        // todo: узнать что такое "departure" - штука которая просто умножает цену на себя
        foreach ($cuttings as $listId => $cuttingType) {
            $this->fieldsOption($listId)->map(function ($item) use ($cuttingType, $listId, $calculatorType) {
                $isVolume = $listId === 11;
                if (!Cutting::find($item->id)) {
                    Cutting::query()->create([
                        'id' => $item->id,
                        'name' => $item->name,
                        'cutting_type_id' => $cuttingType->getKey(),
                        'is_volume' => $isVolume,
                        'calculator_type_id' => $calculatorType->getKey()
                    ]);
                }
            });
        }

        // calculator => cuttings
        $calculatorCuttings = [
            3815 => [1, 2, 3, 4],
            3816 => [1, 2, 3, 4],
            3827 => [1, 2, 3, 4],
            3817 => [1, 2, 3, 4],
            3818 => [],
            3819 => [1, 2, 3, 4],
            3821 => [1, 2, 3, 4],
            3820 => [1, 2, 5],
            3824 => [1, 2, 5],
            3823 => [1, 2, 5],
            3822 => [1, 2, 5],
            3829 => [1, 2, 4],
            3830 => [1],
            3826 => [6],
        ];

        foreach ($calculatorCuttings as $calculatorId => $cuttings) {
            foreach ($cuttings as $cutting) {
                PivotCalculatorCutting::query()->create([
                    'calculator_id' => $calculatorId,
                    'cutting_id' => $cutting
                ]);
            }
        }
    }

    public function calculatorTypeConfigs(CalculatorType|Builder $calculatorType): void
    {
        CalculatorTypeConfig::query()->create([
            'calculator_type_id' => $this->catalogCalculatorType->getKey(),
            'name' => 'validators',
            'value' => [
                "rules" => [
                    "product_count_types" => [
                        [
                            "validator" => "number"
                        ],
                        [
                            "validator" => "min",
                            "param" => 100
                        ]
                    ],
                    "width" => [
                        [
                            "validator" => "number"
                        ]
                    ],
                    "height" => [
                        [
                            "validator" => "number"
                        ]
                    ]
                ]
            ]
        ]);

        if ($calculatorType->name === 'stickers') {
            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'validators',
                'value' => [
                    "rules" => [
                        "product_count_types" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 100
                            ]
                        ],
                        "width" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 1100,
                                "message" => "Значение не доопустимо большое"
                            ]
                        ],
                        "height" => [
                            [
                                "validator" => "number"
                            ],
                            [
                                "validator" => "min",
                                "param" => 5,
                                "message" => "Значение не доопустимо маленькое"
                            ],
                            [
                                "validator" => "max",
                                "param" => 1100,
                                "message" => "Значение не доопустимо маленькое"
                            ]
                        ]
                    ],
                    "conditions" => [
                        [
                            "field" => "print_type",
                            "val" => 14,
                            "rules" => [
                                "width" => [
                                    [
                                        "validator" => "number"
                                    ],
                                    [
                                        "validator" => "min",
                                        "param" => 5,
                                        "message" => "Значение не доопустимо маленькое"
                                    ],
                                    [
                                        "validator" => "max",
                                        "param" => 1100,
                                        "message" => "Значение не доопустимо большое"
                                    ]
                                ],
                                "height" => [
                                    [
                                        "validator" => "number"
                                    ],
                                    [
                                        "validator" => "min",
                                        "param" => 5,
                                        "message" => "Значение не доопустимо маленькое"
                                    ],
                                    [
                                        "validator" => "max",
                                        "param" => 1100,
                                        "message" => "Значение не доопустимо большое"
                                    ]
                                ]
                            ]
                        ],
                        [
                            "field" => "print_type",
                            "val" => 15,
                            "rules" => [
                                "width" => [
                                    [
                                        "validator" => "number"
                                    ],
                                    [
                                        "validator" => "min",
                                        "param" => 5,
                                        "message" => "Значение не доопустимо маленькое"
                                    ],
                                    [
                                        "validator" => "max",
                                        "param" => 300,
                                        "message" => "Значение не доопустимо большое"
                                    ]
                                ],
                                "height" => [
                                    [
                                        "validator" => "number"
                                    ],
                                    [
                                        "validator" => "min",
                                        "param" => 5,
                                        "message" => "Значение не доопустимо маленькое"
                                    ],
                                    [
                                        "validator" => "max",
                                        "param" => 430,
                                        "message" => "Значение не доопустимо большое"
                                    ]
                                ]
                            ]
                        ]
                    ]

                ]
            ]);

            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'fields',
                'value' => [
//                    'print_type',
                    'width_height',
                    'product_count_types',
                    'material',
                    'lam',
                    'cutting',
                    'form',
                    'foiling',
                ]
            ]);

            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'image_deps',
                'value' => [
                    'cutting'
                ]
            ]);
        } elseif ($calculatorType->name === 'labels') {
            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'validators',
                'value' => [
                    "product_count" => [
                        [
                            "validator" => "number"
                        ],
                        [
                            "validator" => "min",
                            "param" => 100
                        ]
                    ]
                ]
            ]);

            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'fields',
                'value' => [
                    'knife',
                    'product_count',
                    'material_flex',
                    'color',
                    'print_position'
                ]
            ]);

            CalculatorTypeConfig::query()->create([
                'calculator_type_id' => $calculatorType->getKey(),
                'name' => 'image_deps',
                'value' => [
                    'print_position',
                    'knife'
                ]
            ]);
        }
    }

    public function calculatorTypeRoutes(CalculatorType|Builder $calculatorType): void
    {
//        if ($calculatorType->name === 'stickers') { todo: перенести норм роуты как на бою
        CalculatorTypeRoute::query()->create([
            'calculator_type_id' => $calculatorType->getKey(),
            'name' => 'form_schema_routes',
            'route' => 'calc.new.count',
            'params' => [
                'calc_category_id' => 'id',
                'type' => 'id'
            ]
        ]);

        CalculatorTypeRoute::query()->create([
            'calculator_type_id' => $calculatorType->getKey(),
            'name' => 'form_schema_routes',
            'route' => 'calculator.types',
            'params' => [
                'calc_category_id' => 'id',
                'type' => 'id'
            ],
            'services' => [
                'design' => 'design'
            ],
            'deps' => ['image', 'image 1', 'image 2']
        ]);
//        }
    }

    public function globalConfig(): void
    {
        $fields = [
            "diameter" => [
                "type" => "input",
                "default" => 50,
                "formField" => "diameter",
                "label" => "Диаметр",
                "numbersOnly" => true,
                "postText" => "мм",
                "labelModalLink" => "",
            ],
            "width_height" => [
                "type" => "width-height",
                "formWidthField" => "width",
                "formHeightField" => "height",
                "label" => "Размер",
                "labelInnerText" => "(↔✗↕)",
                "labelModalLink" => "",
                "info" => []
            ],
            "product_count" => [
                "type" => "input",
                "default" => 300,
                "numbersOnly" => true,
                "postText" => "шт",
                "formField" => "product_count",
                "label" => "Количество"
            ],
            "sleeve_quantity" => [
                "type" => "input",
                "default" => 0,
                "numbersOnly" => true,
                "postText" => "шт",
                "formField" => "sleeve_quantity",
                "label" => "Втулок"
            ],
            "product_count_types" => [
                "type" => "count",
                "default" => 300,
                "formCountField" => "product_count",
                "formTypesField" => "quantity_types",
                "label" => "Количество",
                "labelInnerText" => "",
                "labelModalLink" => "",
                "info" => false
            ],
            "material" => [
                "type" => "material",
                "formMaterialField" => "material",
                "formColorField" => "material_color",
                "label" => "Материал",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "material-modal",
                "dataField" => "material",
                "info" => false
            ],
            "foiling" => [
                "type" => "radio-material",
                "formMaterialField" => "foiling",
                "formColorField" => "foiling_color",
                "label" => "Фольга",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling-modal",
                "dataField" => "foiling",
                "info" => false
            ],
            "lam" => [
                "type" => "select",
                "dataField" => "lam",
                "formField" => "lam",
                "default" => 'none',
                "label" => "Ламинация",
                "postText" => "",
                "labelModalLink" => "lam-modal",
                "info" => false,
                "deps" => false,
                "url" => ""
            ],
            "cutting" => [
                "type" => "select",
                "formField" => "cutting",
                "dataField" => "cutting",
                "label" => "Нарезка",
                "postText" => "",
                "labelModalLink" => "cutting-modal",
                "info" => false,
                "deps" => false,
                "url" => ""
            ],
            "form" => [
                "type" => "select",
                "formField" => "form",
                "dataField" => "form",
                "label" => "Форма",
            ],
            "print_type" => [
                "type" => "radio-btns",
                "formField" => "print_type"
            ],
            "knife" => [
                "type" => "select",
                "formField" => "knife",
                "dataField" => "knife",
                "label" => "Размер",
            ],
            "material_category" => [
                "type" => "select",
                "formField" => "material",
                "dataField" => "material",
                "category" => true,
                "label" => "Материал",
            ],
            "color" => [
                "type" => "select",
                "formField" => "color",
                "dataField" => "color",
                "label" => "Цветность",
            ],
            "color_cover" => [
                "type" => "select",
                "formField" => "color_cover",
                "dataField" => "color_cover",
                "label" => "Цветность обложка",
            ],
            "color_block" => [
                "type" => "select",
                "formField" => "color_block",
                "dataField" => "color_block",
                "label" => "Цветность блок",
            ],
            "color_substrate" => [
                "type" => "select",
                "formField" => "color_substrate",
                "dataField" => "color_substrate",
                "label" => "Цветность подложка",
            ],
            "ribbon" => [
                "type" => "select",
                "formField" => "ribbon",
                "dataField" => "ribbon",
                "label" => "Риббон",
            ],
            "print_position" => [
                "type" => "select",
                "formField" => "print_position",
                "dataField" => "print_position",
                "label" => "Рассположение",
            ],


            //catalog
            "spring" => [
                "type" => "select",
                "formField" => "spring",
                "label" => "Пружина"
            ],
            "material_wrapper" => [
                "type" => 'block_select',
                'formField' => 'block_select',
            ],
            "page_count" => [
                "type" => "input",
                "default" => 8,
                "numbersOnly" => true,
                "postText" => "не включая обложку и подложку",
                "formField" => "page_count",
                "label" => "Страниц"
            ],
            "list_count" => [
                "type" => "input",
                "default" => 8,
                "numbersOnly" => true,
                "postText" => "не включая обложку и подложку",
                "formField" => "page_count",
                "label" => "Листов"
            ],
            "page_select" => [
                "type" => "select",
                "formField" => "page_count",
                "label" => "Страниц"
            ],
            "material_cover" => [
                "type" => "material",
                "formMaterialField" => "material_cover",
                "formColorField" => "material_cover_color",
                "label" => "Материал обложка",
                "labelModalLink" => "material-cover-modal",
                "dataField" => "material_cover",
            ],
            "material_block" => [
                "type" => "material",
                "formMaterialField" => "material_block",
                "formColorField" => "material_block_color",
                "label" => "Материал блок",
                "labelModalLink" => "material-block-modal",
                "dataField" => "material_block"
            ],
            "material_substrate" => [
                "type" => "material",
                "formMaterialField" => "material_substrate",
                "formColorField" => "material_substrate_color",
                "label" => "Материал подложка",
                "labelModalLink" => "material-substrate-modal",
                "dataField" => "material_substrate"
            ],
            "print_type_cover" => [
                "type" => "select",
                "formField" => "print_type_cover",
                "label" => "Печать обложка",
            ],
            "print_type_block" => [
                "type" => "select",
                "formField" => "print_type_block",
                "label" => "Печать блок",
            ],
            "print_type_substrate" => [
                "type" => "select",
                "formField" => "print_type_substrate",
                "label" => "Печать подложка",
            ],
            "lam_cover" => [
                "type" => "select",
                "formField" => "lam_cover",
                "label" => "Ламинация обложка"
            ],
            "lam_substrate" => [
                "type" => "select",
                "formField" => "lam_substrate",
                "label" => "Ламинация подложка"
            ],
            "plastic_substrate" => [
                "type" => "select",
                "formField" => "plastic_substrate",
                "label" => "Пластик подложка"
            ],
            "foiling_color" => [
                "type" => "select",
                "formField" => "foiling_color",
                "label" => "Фольга"
            ],
            "varnish" => [
                "formField" => "varnish",
                "label" => "Лак",
                "labelModalLink" => "varnish-modal",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "plastic_cover" => [
                "type" => "checkbox",
                "formField" => "plastic_cover",
                "labelModalLink" => "plastic-cover-modal",
                "info" => false,
                "checked" => false,
                "label" => "Прозрачный пластик"
            ],

            //businessCard
            "foiling_face" => [
                "type" => "select",
                "formField" => "foiling_face",
                "label" => "Фольга лицо",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling_face-modal",
                "dataField" => "foiling_face",
                "info" => false
            ],
            "foiling_back" => [
                "type" => "select",
                "formField" => "foiling_back",
                "label" => "Фольга оборот",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling_back-modal",
                "dataField" => "foiling_back",
                "info" => false
            ],
            "print_type_select" => [
                "type" => "select",
                "formField" => "print_type",
                "dataField" => "print_type",
                "label" => "Печать",
            ],
            "color_count_face" => [
                "type" => "select-color",
                "defaultId" => 1,
                "formField" => "color_count_face",
                "dataField" => "color_count_face",
                "label" => "Цвет лицо",
            ],
            "color_count_back" => [
                "type" => "select-color",
                "formField" => "color_count_back",
                "dataField" => "color_count_back",
                "label" => "Цвет оборот",
            ],

            //checkboxes
            "white_print" => [
                "formField" => "white_print",
                "label" => "Печать белым",
                "labelModalLink" => "",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"],
            "complex_form" => [
                "formField" => "complex_form",
                "label" => "Сложная форма",
                "labelModalLink" => "",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "volume" => [
                "formField" => "volume",
                "label" => "Сделать объемной",
                "labelModalLink" => "volume-modal",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "reverse_sticker" => [
                "formField" => "reverse_sticker",
                "label" => "Обратная наклейка",
                "labelModalLink" => "reverse-sticker-modal",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "mounting_film" => [
                "formField" => "mounting_film",
                "label" => "Монтажная пленка",
                "labelModalLink" => "mounting-film-modal",
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "small_objects" => [
                "formField" => "small_objects",
                "label" => "Сложная выборка",
                "labelModalLink" => "small-objects-modal",
                "conditions" => [
                    'readonly' => [["field" => "mounting_film", "value" => false, "checked" => false]],
                ],
                "info" => false,
                "checked" => false,
                "type" => "checkbox"
            ],
            "sprint_position" => [
                'formField' => 'sprint_position',
                'label' => 'Пружина',
                'type' => 'radio-check-btn'
            ],
            "foiling_cover" => [
                "type" => "radio-material",
                "formMaterialField" => "foiling",
                "formColorField" => "foiling_color_cover",
                "label" => "Фольга обложка",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling-modal",
                "dataField" => "foiling",
                "info" => false
            ],
            "foiling_block" => [
                "type" => "radio-material",
                "formMaterialField" => "foiling",
                "formColorField" => "foiling_color",
                "label" => "Фольга блок",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling-modal",
                "dataField" => "foiling",
                "info" => false
            ],
            "foiling_substrate" => [
                "type" => "radio-material",
                "formMaterialField" => "foiling",
                "formColorField" => "foiling_color",
                "label" => "Фольга подложка",
                "labelInnerText" => "", // text with different color in label
                "postText" => "",
                "labelModalLink" => "foiling-modal",
                "dataField" => "foiling",
                "info" => false
            ],
            "rounding_corners" => [
                "formField" => "rounding_corners",
                "label" => "Скругление углов",
                "labelModalLink" => "rounding-corners-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "cliche" => [
                "formField" => "cliche",
                "label" => "Заказать клише",
                "labelModalLink" => "cliche-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "thermal_rise_face" => [
                "formField" => "thermal_rise_face",
                "label" => "Объем. лак лицо",
                "labelModalLink" => "thermal_rise_face-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "thermal_rise_back" => [
                "formField" => "thermal_rise_back",
                "label" => "Объем. лак оборот",
                "labelModalLink" => "thermal_rise_back-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "varnish_face" => [
                "formField" => "varnish_face",
                "label" => "Лак лицо",
                "labelModalLink" => "varnish_face-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "varnish_back" => [
                "formField" => "varnish_back",
                "label" => "Лак оборот",
                "labelModalLink" => "varnish_back-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "congregation" => [
                "formField" => "congregation",
                "label" => "Конгрев",
                "labelModalLink" => "congregation-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "embossing_face" => [
                "type" => "select",
                "formField" => "embossing_face",
                "dataField" => "embossing_face",
                "label" => "Тиснение лицо"
            ],
            "embossing_back" => [
                "type" => "select",
                "formField" => "embossing_back",
                "dataField" => "embossing_back",
                "label" => "Тиснение оборот"
            ],
            "embossing_face2" => [
                "type" => "select",
                "formField" => "embossing_face2",
                "dataField" => "embossing_face2",
                "label" => "Тиснение лицо"
            ],
            "embossing_back2" => [
                "type" => "select",
                "formField" => "embossing_back2",
                "dataField" => "embossing_back2",
                "label" => "Тиснение оборот"
            ],
/*            "folded" => [
                "formField" => "folded",
                "label" => "Изделие со сложением",
                "labelModalLink" => "folded-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],*/
        ];

        foreach ($fields as $name => $field) {
            $parameters = $field;
            unset($parameters['type']);

            FormField::query()->create([
                'type' => $field['type'],
                'name' => $name,
                'parameters' => $parameters
            ]);
        }

        $blockSelectPivot = [
            3858 => [
                [
                    'field_id' => 33,
                    'block_select_config' => 1,
                    'config' => [
                        'calculator_sub_id' => 1
                    ],
                    'type_name' => 'Обложка'
                ],
                [
                    'field_id' => 19,
                    'block_select_config' => 2,
                    'config' => [
                        'calculator_sub_id' => 1
                    ],
                    'type_name' => 'Блок'
                ],
                [
                    'field_id' => 19,
                    'block_select_config' => 3,
                    'config' => [
                        'calculator_sub_id' => 2
                    ],
                    'type_name' => 'Подложка',
                ],
//                [
//                    'field_id' => 40,
//                    'block_select_config' => 2,
//                ],
            ],
        ];

        foreach ($blockSelectPivot as $calculatorId => $items) {
            foreach ($items as $item) {
                if (isset($item['config'])) {
                    BlockSelectFieldConfigTypes::query()->create([
                        'name' => $item['type_name']
                    ]);

//                    $blockSelectConfig = BlockSelectFieldConfig::query()->create([
//                        'calculator_id' => $calculatorId,
//                        'block_select_field_config_type_id' => $blockSelectConfigType->getKey(),
//                        ...$item['config']
//                    ]);
                }


//                PivotCalculatorBlockSelectFields::query()->create([
//                    'form_field_id' => $item['field_id'],
//                    'block_select_field_config_id' => (isset($blockSelectConfig)) ? $blockSelectConfig->getKey() : $item['block_select_config']
//                ]);
            }
        }

        $selectBlockFields = [
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3855,
                'fields' => [25, 15, 31, 49, 35]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3855,
                'fields' => [26, 16]
            ],
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3856,
                'fields' => [25, 15, 31, 49, 35]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3856,
                'fields' => [26, 16]
            ],
            [
                'block_select_field_config_type_id' => 3,
                'active' => true,
                'calculator_sub_id' => 3,
                'calculator_id' => 3856,
                'fields' => [27, 17, 32]
            ],
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3866,
                'fields' => [25, 15, 31, 49, 35]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3866,
                'fields' => [26, 16]
            ],
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3858,
                'fields' => [25, 15, 31, 49, 35, 36]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3858,
                'fields' => [26, 16]
            ],
            [
                'block_select_field_config_type_id' => 3,
                'active' => true,
                'calculator_sub_id' => 3,
                'calculator_id' => 3858,
                'fields' => [33, 27, 17, 32]
            ],
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3859,
                'fields' => [25, 15, 31, 49, 35]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3859,
                'fields' => [26, 16]
            ],
            [
                'block_select_field_config_type_id' => 3,
                'active' => true,
                'calculator_sub_id' => 3,
                'calculator_id' => 3859,
                'fields' => [27, 17, 32]
            ],
            // --------------------------------------------------
            [
                'block_select_field_config_type_id' => 1,
                'active' => true,
                'calculator_sub_id' => 1,
                'calculator_id' => 3860,
                'fields' => [25, 15, 31, 49, 35]
            ],
            [
                'block_select_field_config_type_id' => 2,
                'active' => true,
                'calculator_sub_id' => 2,
                'calculator_id' => 3860,
                'fields' => [26, 16]
                ]
            ];

        foreach ($selectBlockFields as $blockField) {
            $fields = $blockField['fields'];
            unset($blockField['fields']);

            $newConfig = BlockSelectFieldConfig::query()->create($blockField);

            foreach ($fields as $fieldId) {
                PivotCalculatorBlockSelectFields::query()->create([
                    'block_select_field_config_id' => $newConfig->getKey(),
                    'form_field_id' => $fieldId
                ]);
            }
        }
    }

    public function calculatorConfigs(Calculator|Builder $calculator): void
    {
        $this->heightPrintForm(3829);
        $this->heightPrintForm(3830);
        $this->heightPrintForm(3819);

        CalculatorConfig::query()->create([
            'calculator_id' => 3829,
            'name' => 'checkboxes',
            'value' => ['white_print']
        ]);

        CalculatorConfig::query()->create([
            'calculator_id' => 3829,
            'name' => 'additional_fields',
//            'value' => ['diameter', 'print_type'] // todo: не ставить лишние поля, потому что отваливается подсчёт и Vue
            'value' => ['diameter']
        ]);

        // Наклейки с фольгой
        $this->heightPrintForm(3821);
        CalculatorConfig::query()->create([
            'calculator_id' => 3821,
            'name' => 'checkboxes',
            'value' => ['volume']
        ]);

        CalculatorConfig::query()->create([
            'calculator_id' => 3821,
            'name' => 'additional_fields',
            'value' => ['diameter']
        ]);

        // Надписи и аппликации
//        CalculatorConfig::query()->create([
//
//        ]);

        //
        CalculatorConfig::query()->create([
            'calculator_id' => 3820,
            'name' => 'additional_fields',
            'value' => ['print_type']
        ]);

        CalculatorConfig::query()->create([
            'calculator_id' => $calculator->getKey(),
            'name' => 'fields_config',
            'value' => [ // todo: понять для чего конкретно нужны URL и придумать как подставлять их на бэкэнде
                'material' => [
                    'url' => '$materialsUrl',
                    'deps' => ['print_type']
                ],
                'lam' => [
                    'url' => '$lamsUrl',
                    'deps' => ['print_type']
                ],
                'width_height' => [
                    'predefinedValues' => true,
                    'labelInnerText' => '',
                    'label' => 'Размер листа',
                ],
                'foiling' => [
                    "conditions" => [
                        "visible" => [
                            ["field" => "print_type", "value" => 15]
                        ]
                    ]
                ]
            ]
        ]);
    }

    private function complexFormConditions(): void
    {
        $calculatorConditions = [
            'complex_form' => [
                'calculators' => [3820, 3824, 2823, 3822],
                'type' => 'checkboxes',
                'condition' => [
                    "checked" => [["field" => "mounting_film", "value" => true]],
                    "readonly" => [["field" => "mounting_film", "value" => true]]
                ]
            ],
            'cutting' => [
                'calculators' => [3820, 3824, 2823, 3822],
                'type' => 'fields',
                'condition' => [
                    "selected" => [["field" => "mounting_film", "value" => true, "selected_value" => 2]],
                    "readonly" => [["field" => "mounting_film", "value" => true]]
                ]
            ],
            'white_print' => [
                'calculators' => [3820, 2823, 3818],
                'type' => 'checkboxes',
                'condition' => [
                    "visible" => [["field" => "print_type", "value" => 14]] // print_id => 14 Струйная печать
                ]
            ],
            'lamination' => [
                'calculators' => [3820, 3824, 2823, 3822],
                'type' => 'fields',
                'is_additional' => true,
                'condition' => [
                    "selected" => [["field" => "reverse_sticker", "value" => true, "selected_value" => 47]],
                    "readonly" => [["field" => "reverse_sticker", "value" => true]],
                    "visible" => [["field" => "print_type", "value" => 14]]
                ]
            ]
        ];

        foreach ($calculatorConditions as $conditionName => $conditionItems) {
            $newCondition = CalculatorConfigCondition::query()->create([
                'name' => $conditionName,
                'type' => $conditionItems['type'],
                'condition' => $conditionItems['condition']
            ]);

            foreach ($conditionItems['calculators'] as $calculatorId) {
                PivotCalculatorConfigCondition::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_config_condition_id' => $newCondition->getKey()
                ]);
            }
        }
    }

    private function calculatorFields(): void
    {
        // calculatorId => fields
        $calculatorFields = [
            [
                'calculators' => [3815, 3838],
                'type' => 'fields',
                'value' => ['print_type', 'diameter', 'product_count_types', 'material', 'lam', 'cutting']
            ],
            [
                'calculators' => [3818],
                'type' => 'fields',
                'value' => ['print_type', 'width_height', 'product_count_types', 'material', 'lam', 'foiling']
            ],
            [
                'calculators' => [3819, 3842],
                'type' => 'fields',
                'value' => ['width_height', 'diameter', 'product_count_types', 'form', 'material', 'cutting']
            ],
            [
                'calculators' => [3821, 3844],
                'type' => 'fields',
                'value' => ['width_height', 'diameter', 'product_count_types', 'form', 'material', 'foiling', 'lam', 'cutting']
            ],
            [
                'calculators' => [3826],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'material', 'cutting']
            ],
            [
                'calculators' => [3829, 3830],
                'type' => 'fields',
                'value' => ['diameter', 'width_height', 'form', 'product_count_types', 'material', 'cutting']
            ],
            [
                'calculators' => [3820, 3824, 3823],
                'type' => 'fields',
                'value' => ['print_type', 'width_height', 'product_count_types', 'material', 'lam', 'cutting']
            ],
            [
                'calculators' => [3822],
                'type' => 'fields',
                'value' => ['print_type', 'width_height', 'product_count_types', 'material', 'cutting']
            ],
            [
                'calculators' => [3826],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'material', 'cutting']
            ],
            [
                'calculators' => [3816, 3817],
                'type' => 'fields',
                'value' => ['print_type', 'width_height', 'product_count_types', 'material', 'lam', 'cutting']
            ],
            [
                'calculators' => [3856, 3859, 3866],
                'type' => 'fields',
                'value' => ['width_height', 'page_count', 'product_count', 'material_wrapper']
            ],
            [
                'calculators' => [3855, 3857, 3860],
                'type' => 'fields',
                'value' => ['width_height', 'page_select', 'product_count', 'material_wrapper']
            ],
            [
                'calculators' => [3858],
                'type' => 'fields',
                'value' => ['sprint_position', 'width_height', 'page_count', 'product_count', 'material_wrapper']
            ],
            [
                'calculators' => [3859],
                'type' => 'fields',
                'value' => ['list_count', 'material_wrapper']
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858, 3859, 3860],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        'predefinedValues' => true,
                        'labelInnerText' => '',
                ]]
            ],
            [
                'calculators' => [3827],
                'type' => 'fields',
                'value' => ['print_type', 'width_height', 'product_count_types', 'material', 'lam', 'cutting']
            ],
            [
                'calculators' => [3815, 3818, 3827, 3816, 3817, 3826, 3822, 3820, 3824, 3823, 3829, 3821, 3844, 3819, 3842, 3838],
                'type' => 'fields_options',
                'value' => [
                    'material' => [
                        'url' => route('calculator.materials'), // todo: придумать как связать url, скорее всего с табличкой calculator_routes
                        'deps' => ['print_type']
                    ],
                    'lam' => [
                        'url' => route('calculator.laminations'),
                        'deps' => ['print_type']
                    ],
                ]
            ],
            [
                'calculators' => [3818],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        'predefinedValues' => true,
                        'labelInnerText' => '',
                        'label' => 'Размер листа',
                    ],
                    'foiling' => [
                        "conditions" => [
                            "visible" => [
                                ["field" => "print_type", "value" => 15]
                            ]
                        ]
                    ],
                    'material' => [
                        'deps' => ['foiling', 'white_print']
                    ]
                ]
            ],
            [
                'calculators' => [3818],
                'type' => 'checkboxes_options',
                'value' => [
                    'white_print' => [
                        'conditions' => [
                            "visible" => [["field" => "print_type", "value" => 14]] // print_id => 14 Струйная печать
                        ]
                    ],
                ]
            ],
            [
                'calculators' => [3820, 3824, 3823, 3822],
                'type' => 'fields_options',
                'value' => [
                    'cutting' => [
                        'conditions' => [
                            'readonly' => [['field' => 'mounting_film', 'value' => 1, 'selected_value' => 2]],
                            'selected' => [['field' => 'mounting_film', 'value' => 1, 'selected_value' => 2]],
                        ]
                    ],
                    'lam' => [
                        'conditions' => [
                            'readonly' => [['field' => 'reverse_sticker', 'value' => 1]],
                            'selected' => [['field' => 'reverse_sticker', 'value' => 1, 'selected_value' => 47]],
                            'visible' => [['field' => 'print_type', 'value' => 14]]
                        ]
                    ]
                ]
            ],
            [
                'calculators' => [3820, 3824, 3823, 3822],
                'type' => 'checkboxes_options',
                'value' => [
                    'white_print' => [
                        'conditions' => [
                            "visible" => [["field" => "print_type", "value" => 14]] // print_id => 14 Струйная печать
                        ]
                    ],
                    'complex_form' => [
                        'conditions' => [
                            'checked' => [['field' => 'mounting_film', 'value' => true]],
                            'readonly' => [['field' => 'mounting_film', 'value' => true]]
                        ]
                    ]
                ]
            ],
            [
                'calculators' => [3819, 3842],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "defaultWidth" => 50,
                        "defaultHeight" => 50,
                        "conditions" => [
                            "hidden" => [["field" => "form", "value" => 54]],
                        ]],
                    'diameter' => ["conditions" => [
                        "visible" => [["field" => "form", "value" => 54]],
                    ]],
                    'cutting' => [
                        'url' => route('calculator.cuttings'), // todo: придумать как связать url, скорее всего с табличкой calculator_routes
                        'deps' => ['volume']
                    ]
                ]
            ],
            [
                'calculators' => [3821, 3844],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "conditions" => [
                            "hidden" => [["field" => "form", "value" => 54]],
                        ]],
                    'diameter' => ["conditions" => [
                        "visible" => [["field" => "form", "value" => 54]],
                    ]],
                    'material' => [
                        'url' => route('calculator.materials'),
                        'deps' => ['volume']
                    ],
                    'cutting' => [
                        'url' => route('calculator.cuttings'),
                        'deps' => ['volume']
                    ]
                ]
            ],
            [
                'calculators' => [3820, 3824, 3823, 3822],
                'type' => 'fields_options',
                'value' => [
                    'material' => [
                        'url' => '',
                        'deps' => ['white_print']
                    ],
                ]
            ],
            [
                'calculators' => [3826],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        'predefinedValues' => true,
                        'labelInnerText' => '',
                        'label' => 'Размер листа',
                    ],
                ]
            ],
            [
                'calculators' => [3830],
                'type' => 'fields_options',
                'value' => []
            ],
            [
                'calculators' => [3830, 3829, 3821, 3819],
                'type' => 'fields_options',
                'value' => [
                    'diameter' => [
                        "conditions" => [
                            "visible" => [["field" => "form", "value" => 54]],
                        ]
                    ]
                ]
            ],
            [
                'calculators' => [$this->businessCardSimpleCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'material', 'color', 'lam',]
            ],
            [
                'calculators' => [$this->businessCardFoilingCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'print_type_select', 'material', 'lam',
                    'foiling_face', 'foiling_back', 'form']
            ],
            [
                'calculators' => [$this->businessCardTransparentPlasticCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'foiling_face', 'foiling_back', 'color_count_face', 'color_count_back', 'form', 'embossing_face', 'embossing_back', 'embossing_face2', 'embossing_back2']
            ],
            [
                'calculators' => [$this->businessCardCircleCalculator->getKey()],
                'type' => 'fields',
                'value' => ['diameter', 'product_count_types', 'material', 'color', 'lam']
            ],
            [
                'calculators' => [$this->businessCardComplexCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'material', 'color', 'lam']
            ],
            [
                'calculators' => [$this->businessCardVIPCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'material', 'color_count_face', 'color_count_back', 'form', 'embossing_face', 'embossing_back', 'embossing_face2', 'embossing_back2']
            ],
            [
                'calculators' => [
                    $this->businessCardSimpleCalculator->getKey(),
                    $this->businessCardFoilingCalculator->getKey(),
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardComplexCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey()
                ],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        'predefinedValues' => true,
                        'labelInnerText' => '',
                        'label' => 'Размер в развороте',
                    ],
                ]
            ],

          [
                'calculators' => [
                    $this->businessCardSimpleCalculator->getKey(),
                    $this->businessCardFoilingCalculator->getKey(),
                    $this->businessCardTransparentPlasticCalculator->getKey(),
                    $this->businessCardCircleCalculator->getKey(),
                    $this->businessCardComplexCalculator->getKey(),
                    $this->businessCardVIPCalculator->getKey()
                ],
                'type' => 'fields_options',
                'value' => [
                    'product_count_types' => [
                        'type' => 'select',
                        'default' => 50,
                        'predefinedValues' => true,
                        'dataField' => 'product_count',
                        'formField' => 'product_count',
                        'labelInnerText' => '',
                        'label' => 'Количество',
                    ],
                ]
            ],
            [
                'calculators' => [
                    $this->businessCardCircleCalculator->getKey(),
                ],
                'type' => 'fields_options',
                'value' => [
                    'diameter' => [
                        'default' => 90,
                    ],
                ]
            ],
/*            [
                'calculators' => [$this->labelsSimpleCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsCircleCalculator->getKey()],
                'type' => 'fields',
                'value' => ['diameter', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsComplexCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsSimpleWobblersCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsCircleWobblersCalculator->getKey()],
                'type' => 'fields',
                'value' => ['diameter', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsComplexWobblersCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->labelsHangersCalculator->getKey()],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],*/
        ];

        foreach ($calculatorFields as $item) {
            $newFieldConfig = CalculatorFieldsConfig::query()->create([
                'value' => $item['value'],
                'type' => $item['type']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorFieldsConfig::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_fields_config_id' => $newFieldConfig->getKey()
                ]);
            }
        }
    }

    // для отображения чекбоксов на фронте
    private function calculatorCheckboxes(): void
    {
        $calculatorCheckboxes = [
            [
                'checkboxes' => ['white_print'],
                'calculators' => [3818]
            ],
            [
                'checkboxes' => ['volume', 'reverse_sticker'],
                'calculators' => [3819, 3842]
            ],
            [
                'checkboxes' => ['volume'],
                'calculators' => [3821, 3844]
            ],
            [
                'checkboxes' => ['complex_form', 'mounting_film'],
                'calculators' => [3824]
            ],
            [
                'checkboxes' => ['complex_form', 'mounting_film', 'reverse_sticker', 'small_objects'],
                'calculators' => [3822]
            ],
            [
                'checkboxes' => ['complex_form', 'mounting_film', 'reverse_sticker', 'white_print'],
                'calculators' => [3820, 3823]
            ],
            [
                'checkboxes' => ['white_print'],
                'calculators' => [3829]
            ],
            [
                'calculators' => [$this->businessCardSimpleCalculator->getKey()],
                'checkboxes' => ['rounding_corners'],
            ],
            [
                'calculators' => [$this->businessCardTransparentPlasticCalculator->getKey()],
                'checkboxes' => ['rounding_corners', 'cliche', 'thermal_rise_face', 'thermal_rise_back', 'varnish_face', 'varnish_back'],
            ],
            [
                'calculators' => [$this->businessCardVIPCalculator->getKey()],
                'checkboxes' => ['rounding_corners', 'congregation', 'cliche', 'thermal_rise_face', 'thermal_rise_back', 'varnish_face', 'varnish_back'],
            ],
    /*        [
                'calculators' => [$this->labelsSimpleCalculator->getKey()],
                'checkboxes' => ['rounding_corners', 'folded'],
            ],
            [
                'calculators' => [$this->labelsSimpleWobblersCalculator->getKey()],
                'checkboxes' => ['rounding_corners', 'folded'],
            ],*/
        ];

        foreach ($calculatorCheckboxes as $item) {
            $newCheckboxesConfig = CalculatorCheckboxConfig::query()->create([
                'value' => $item['checkboxes']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorCheckboxConfig::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_checkbox_config_id' => $newCheckboxesConfig->getKey()
                ]);
            }
        }
    }

    private function heightPrintForm(int $calculatorId)
    {
        CalculatorConfig::query()->create([
            'calculator_id' => $calculatorId,
            'name' => 'height_width_condition',
            'value' => [
                "hidden" => [["field" => "form", "value" => 54]],
            ]
        ]);

        CalculatorConfig::query()->create([
            'calculator_id' => $calculatorId,
            'name' => 'diameter_condition',
            'value' => [
                "visible" => [["field" => "form", "value" => 54]],
            ]
        ]);
    }

    private function foilingColors(): void
    {
        // потому что нет таблицы в бэкапе базы
        $foilingColorsData = json_decode('[
              {
                "id": 23,
                "title": "Только фольга",
                "types": [
                   {
                    "id": 63,
                    "name": "Без фольги"
                   },
                  {
                    "id": 64,
                    "name": "Глянцевое золото (220)",
                    "image": "images/foilings/gold.svg",
                    "image_name": "gold.svg"
                  },
                  {
                    "id": 65,
                    "name": "Глянцевое серебро (Alufin)",
                    "image": "images/foilings/2.svg",
                    "image_name": "2.svg"
                  },
                  {
                    "id": 66,
                    "name": "Бронза металлик (334)",
                    "image": "images/foilings/3.svg",
                    "image_name": "3.svg"
                  },
                  {
                    "id": 67,
                    "name": "Красный металлик (392)",
                    "image": "images/foilings/4.svg",
                    "image_name": "4.svg"
                  },
                  {
                    "id": 68,
                    "name": "Малиновый металлик (360)",
                    "image": "images/foilings/5.svg",
                    "image_name": "5.svg"
                  },
                  {
                    "id": 69,
                    "name": "Титан металлик (377)",
                    "image": "images/foilings/6.svg",
                    "image_name": "6.svg"
                  },
                  {
                    "id": 70,
                    "name": "Салатовый металлик (390)",
                    "image": "images/foilings/7.svg",
                    "image_name": "7.svg"
                  },
                  {
                    "id": 71,
                    "name": "Синий металлик (391)",
                    "image": "images/foilings/8.svg",
                    "image_name": "8.svg"
                  },
                  {
                    "id": 72,
                    "name": "Лазерный хром (Metal Laser)",
                    "image": "images/foilings/9.svg",
                    "image_name": "9.svg"
                  }
                ]
              },
              {
                "id": 24,
                "title": "Фольга с печатью",
                "types": [
                   {
                    "id": 63,
                    "name": "Без фольги"
                   },
                  {
                    "id": 64,
                    "name": "Глянцевое золото (220)",
                    "image": "images/foilings/gold.svg",
                    "image_name": "gold.svg"
                  },
                  {
                    "id": 65,
                    "name": "Глянцевое серебро (Alufin)",
                    "image": "images/foilings/2.svg",
                    "image_name": "2.svg"
                  },
                  {
                    "id": 66,
                    "name": "Бронза металлик (334)",
                    "image": "images/foilings/3.svg",
                    "image_name": "3.svg"
                  },
                  {
                    "id": 67,
                    "name": "Красный металлик (392)",
                    "image": "images/foilings/4.svg",
                    "image_name": "4.svg"
                  },
                  {
                    "id": 68,
                    "name": "Малиновый металлик (360)",
                    "image": "images/foilings/5.svg",
                    "image_name": "5.svg"
                  },
                  {
                    "id": 69,
                    "name": "Титан металлик (377)",
                    "image": "images/foilings/6.svg",
                    "image_name": "6.svg"
                  },
                  {
                    "id": 70,
                    "name": "Салатовый металлик (390)",
                    "image": "images/foilings/7.svg",
                    "image_name": "7.svg"
                  },
                  {
                    "id": 71,
                    "name": "Синий металлик (391)",
                    "image": "images/foilings/8.svg",
                    "image_name": "8.svg"
                  },
                  {
                    "id": 72,
                    "name": "Лазерный хром (Metal Laser)",
                    "image": "images/foilings/9.svg",
                    "image_name": "9.svg"
                  }
                ]
              }
            ]', true);

        foreach ($foilingColorsData as $foiling) {
            foreach ($foiling['types'] as $foilingColor) {
                if (!FoilingColor::find($foilingColor['id'])) {
                    $newFoilingColor = [
                        'id' => $foilingColor['id'],
                        'name' => $foilingColor['name']
                    ];

                    if (isset($foilingColor['image'])) {
                        $file = new UploadedFile(public_path($foilingColor['image']), $foilingColor['image_name']);
                        $attachment = (new File($file))->load();

                        $newFoilingColor['image_id'] = $attachment->getKey();
                    }

                    $newColor = FoilingColor::query()->create($newFoilingColor);

                    DB::table('pivot_calculator_type_foiling_color')->insert([
                        'calculator_type_id' => $this->catalogCalculatorType->getKey(),
                        'foiling_color_id' => $newColor->getKey()
                    ]);
                }

                PivotFoilingColor::query()->create([
                    'foiling_id' => $foiling['id'],
                    'foiling_color_id' => $foilingColor['id']
                ]);
            }
        }


        DB::table('pivot_calculator_type_foiling_color')->insert([
            'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
            'foiling_color_id' => 63,
        ]);

        $foilingColors = ["Золото глянцевое", "Золото сатиновое", "Серебро глянцевое", "Серебро сатиновое", "Бронза металлик","Медь металлик", "Красный металлик", "Малиновый металлик", "Розовый металлик", "Фиолетовый металлик", "Синий металлик", "Голубой металлик", "Бирюза металлик", "Изумрудный металлик", "Зелёный металлик"];
        foreach ($foilingColors as $foilingColor) {
            $newColor = FoilingColor::query()->create([
                'name' => $foilingColor,
            ]);

            DB::table('pivot_calculator_type_foiling_color')->insert([
                'calculator_type_id' => $this->businessCardCalculatorType->getKey(),
                'foiling_color_id' => $newColor->getKey()
            ]);
        }
    }

    private function calculatorImages()
    {
        $calculatorImage = [
            3815 => [
                'name' => 'sticker-round-with-logo-1.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-round-with-logo-1.svg'
            ],
            3816 => [
                'name' => 'sticker-rectangle.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-rectangle.svg'
            ],
            3827 => [
                'name' => 'icon-stiker-oval.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/icon-stiker-oval.svg'
            ],
            3817 => [
                'name' => 'sticker-contoured.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-contoured.svg'
            ],
            3818 => [
                'name' => 'sticker-set.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-set.svg'
            ],
            3819 => [
                'name' => 'sticker-white-on-transparency.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-white-on-transparency.svg'
            ],
            3821 => [
                'name' => 'sticker-foil.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-foil.svg'
            ],
            3820 => [
                'name' => 'sticker-car.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-car.svg'
            ],
            3824 => [
                'name' => 'sticker-on-wall.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-on-wall.svg'
            ],
            3823 => [
                'name' => 'sticker-on-glass.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-on-glass.svg'
            ],
            3822 => [
                'name' => 'sticker-applications.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-applications.svg'
            ],
            3829 => [
                'name' => 'sticker-convex.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-convex.svg'
            ],
            3830 => [
                'name' => 'sticker-warranty.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-warranty.svg'
            ],
            3826 => [
                'name' => 'sticker-simple-on-white-paper.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/sticker-simple-on-white-paper.svg'
            ],
            3855 => [
                'name' => 'Icon-Catalog-Clamps.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Catalog-Clamps.svg'
            ],
            3856 => [
                'name' => 'Icon-Catalog-Spring.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Catalog-Spring.svg'
            ],
            3866 => [
                'name' => 'Icon-Catalog-Glue.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Catalog-Glue.svg'
            ],
            3857 => [
                'name' => 'Icon-Catalog-Screw.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Catalog-Screw.svg'
            ],
            3858 => [
                'name' => 'Icon-Presentations.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Presentations.svg'
            ],
            3859 => [
                'name' => 'Icon-Notepads.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Notepads.svg'
            ],
            3860 => [
                'name' => 'Icon-Notepads (1).svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-Notepads (1).svg'
            ],
            $this->businessCardSimpleCalculator->getKey() => [
                'name' => 'Icon-BC-regular.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-regular.svg',
            ],
            $this->businessCardFoilingCalculator->getKey() => [
                'name' => 'Icon-BC-with-foil.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-with-foil.svg',
            ],
            $this->businessCardTransparentPlasticCalculator->getKey() => [
                'name' => 'Icon-BC-plastic.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-plastic.svg',
            ],
            $this->businessCardCircleCalculator->getKey() => [
                'name' => 'Icon-BC-round.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-round.svg',
            ],
            $this->businessCardComplexCalculator->getKey() => [
                'name' => 'Icon-BC-complex-form.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-complex-form.svg',
            ],
            $this->businessCardVIPCalculator->getKey() => [
                'name' => 'Icon-BC-VIP.svg',
                'extension' => 'svg',
                'path' => 'images/calculators/Icon-BC-VIP.svg',
            ],
        ];

        foreach ($calculatorImage as $calculatorId => $item) {
            $file = new UploadedFile(public_path($item['path']), $item['name']);
            $attachment = (new File($file))->load();

            Calculator::find($calculatorId)->update([
                'image_id' => $attachment->getKey()
            ]);
        }
    }

    public function setRoutesForStickers(): void
    {
        $calculatorTypeRoutes = [
            "insert into calculator_type_routes (name, route, params, calculator_type_id)
            values ('mainImg', 'calc.new.preview', '{\"calc_category_id\": \"id\"}', {$this->stickersCalculatorType->id});",
            "insert into calculator_type_routes(name, route, params, calculator_type_id)
            values ('count', 'calc.new.count', '{\"calc_category_id\": \"id\", \"type\": \"id\"}', {$this->stickersCalculatorType->id});"
        ];

        foreach ($calculatorTypeRoutes as $route) {
            DB::insert($route);
        }
    }

    public function previews($stickersCalculatorType)
    {
        $lastId = FileModel::latest('id')->first() ? FileModel::latest('id')->first()['id'] : 0;
        $paths = $this->getPreviewFullPaths(public_path().'/images/calc_previews/'.$stickersCalculatorType->getKey());

        $fileRows = [];
        $previewRows = [];

        foreach ($paths as $key => $path) {
            $fileRows[] = [
                'name' => 'preview.svg',
                'extension' => 'svg',
                'path' => $path.'/preview.svg',
                'user_id' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

            ];

            $explodePath = explode('/', str_replace('images/calc_previews/', '', $path));

            if (count($explodePath) > 3) {
                list($calcType, $calcId, $cutting, $formId) = $explodePath;
            } elseif (count($explodePath) > 2) {
                $formId = null;
                list($calcType, $calcId, $cutting) = $explodePath;
            } else {
                $formId = null;
                $cutting = null;
                list($calcType, $calcId) = $explodePath;
            }

            $previewRows[] = [
                'image' => $lastId + $key + 1,
                'calculator_type_id' => $calcType,
                'calculator_id' => $calcId,
                'cutting_id' => is_numeric($cutting) ? $cutting : null,
                'form_id' => is_numeric($formId) ? $formId : null,
                'is_volume' => str_contains($path, 'volume'),
                'is_mounting_film' => str_contains($path, 'mounting_film'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('files')->insert($fileRows);
        DB::table('previews')->insert($previewRows);
    }

    protected function getPreviewFullPaths(string $path): array
    {
        static $result = [];

        if (is_dir($path)) {
            $dir = opendir($path);
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..') {
                    $this->getPreviewFullPaths($path.'/'.$file);
                }
            }
        } else {
            $resultPath = str_replace('/preview.svg', '', str_replace(base_path(), '', $path));
            $resultPath = str_replace('/public/', '', $resultPath);
            $result[] = $resultPath;
        }

        return $result;
    }

    public function setPreviewFormImages()
    {
        $calculatorRoutesProps = [
            [
                'calculators' => [3819, 3821, 3844],
                'value' => ["cutting", "form", "volume"],
                'name' => 'deps',
                'calculator_type_route_id' => 3
            ],
            [
                'calculators' => [3818],
                'value' => [],
                'name' => 'deps',
                'calculator_type_route_id' => 3
            ],
            [
                'calculators' => [3820, 3824, 3823, 3822],
                'value' => ['cutting', 'mounting_film'],
                'name' => 'deps',
                'calculator_type_route_id' => 3
            ],
            [
                'calculators' => [3830, 3826],
                'value' => ['cutting', 'form'],
                'name' => 'deps',
                'calculator_type_route_id' => 3
            ],
        ];

        foreach ($calculatorRoutesProps as $prop) {
            foreach ($prop['calculators'] as $calculatorId) {
                unset($prop['calculators']);
                CalculatorRouteProps::query()->create(['calculator_id' => $calculatorId, ...$prop]);
            }
        }
    }

    private function pageSelect(): void
    {
        $ids = DB::table('coral_calc_standard_lists')->where('id', 32)->select()->first()->ids;
        $ids = explode(',', $ids);

        DB::table('coral_calc_fields_list')->whereIn('id', $ids)->select()->get()->map(function ($item) {
            DB::table('page_selects')->insert([
                'id' => $item->adds,
                'name' => $item->name,
                'calculator_type_id' => $this->catalogCalculatorType->getKey()
            ]);
        });
    }

    private function calculatorSub(): void
    {
        $calculatorSub = [
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860, 3866],
                'name' => 'cover'
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860, 3866],
                'name' => 'block'
            ],
            [
                'calculators' => [3856, 3858, 3859],
                'name' => 'substrate'
            ]
        ];

        foreach ($calculatorSub as $item) {
            $newCalculatorSub = CalculatorSub::query()->create([
                'name' => $item['name']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorFoiling::query()->create([
                    'calculator_sub_id' => $newCalculatorSub->getKey(),
                    'print_id' => 124,
                    'calculator_id' => $calculatorId,
                    'foiling_id' => 23
                ]);

                PivotCalculatorSub::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_sub_id' => $newCalculatorSub->getKey()
                ]);
            }
        }

        // laminations
        $catalogLaminations = [111,112,113,114,115,116,117];

        $catalogLaminations = [
            3855 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations]],
            3856 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations, 3 => $catalogLaminations]],
            3866 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations]],
            3857 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations, 3 => $catalogLaminations]],
            3858 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations, 3 => $catalogLaminations]],
            3859 => ['print' => 124, 'calculator_sub' => [1 => [112, 113], 3 => $catalogLaminations]],
            3860 => ['print' => 124, 'calculator_sub' => [1 => $catalogLaminations]],
        ];

        foreach ($catalogLaminations as $calculatorId => $item) {
            foreach ($item['calculator_sub'] as $calculatorSubId => $laminations) {
                foreach ($laminations as $lamination) {
                    PivotCalculatorLamination::query()->create([
                        'calculator_id' => $calculatorId,
                        'lamination_id' => $lamination,
                        'print_id' => $item['print'] ?? null,
                        'calculator_sub_id' => $calculatorSubId
                    ]);
                }
            }
        }

        $materials = [
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858, 3859, 3860],
                'materials' => [26,27,28,29,30,37,38],
                'calculator_sub' => 1
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858, 3859, 3860],
                'materials' => [26,27,28,29,30,37,38],
                'calculator_sub' => 2
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858, 3859, 3860],
                'materials' => [26,27,28,29,30,45,46],
                'calculator_sub' => 3
            ]
        ];

        foreach ($materials as $material) {
            foreach ($material['calculators'] as $calculatorId) {
                foreach ($material['materials'] as $materialId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'material_id' => $materialId,
                        'calculator_sub_id' => $material['calculator_sub']
                    ]);
                }
            }
        }

        $calculatorPrints = [
            3855 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3856 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3866 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3857 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3858 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3859 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
            3860 => ['prints' => [124 => 0, 125 => 30, 126 => 30, 127 => 31, 128 => 31], 'calculator_subs' => [1, 2]],
        ];

        foreach ($calculatorPrints as $calculatorId => $item) {
            foreach ($item['calculator_subs'] as $calculatorSubId) {
                foreach ($item['prints'] as $printId => $specieTypeId) {
                    PivotCalculatorPrints::query()->create([
                        'calculator_sub_id' => $calculatorSubId,
                        'print_id' => $printId,
                        'calculator_id' => $calculatorId
                    ]);
                }
            }
        }

        $calculatorSpecieType = [
            // default values ---------------------
            [
                'calculators' => [3866, 3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 30,
                'print_id' => null,
                'sub_id' => 1
            ],
            [
                'calculators' => [3866, 3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 30,
                'print_id' => null,
                'sub_id' => 2
            ],
            [
                'calculators' => [3866, 3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 30,
                'print_id' => null,
                'sub_id' => 3
            ],
            // ---------------------
            [
                'calculators' => [3866],
                'specie_type' => 0,
                'print_id' => 124,
                'sub_id' => 1
            ],
            [
                'calculators' => [3866],
                'specie_type' => 30,
                'print_id' => 125,
                'sub_id' => 1
            ],
            [
                'calculators' => [3866],
                'specie_type' => 30,
                'print_id' => 126,
                'sub_id' => 1,
                'is_duplex' => true
            ],
            [
                'calculators' => [3866],
                'specie_type' => 36,
                'print_id' => 127,
                'sub_id' => 1
            ],
            [
                'calculators' => [3866],
                'specie_type' => 36,
                'print_id' => 128,
                'sub_id' => 1,
                'is_duplex' => true
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 0,
                'print_id' => 124,
                'sub_id' => 1
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 30,
                'print_id' => 125,
                'sub_id' => 1,
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 30,
                'print_id' => 126,
                'sub_id' => 1,
                'is_duplex' => true
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 31,
                'print_id' => 127,
                'sub_id' => 1
            ],
            [
                'calculators' => [3855, 3856, 3857, 3858, 3859, 3860],
                'specie_type' => 31,
                'print_id' => 128,
                'sub_id' => 1,
                'is_duplex' => true
            ],
            [
                'calculators' => [3859, 3860],
                'specie_type' => 0,
                'print_id' => 124,
                'sub_id' => 2
            ],
            [
                'calculators' => [3859, 3860],
                'specie_type' => 33,
                'print_id' => 125,
                'sub_id' => 2
            ],
            [
                'calculators' => [3859, 3860],
                'specie_type' => 33,
                'print_id' => 126,
                'sub_id' => 2,
                'is_duplex' => true
            ],
            [
                'calculators' => [3859, 3860],
                'specie_type' => 34,
                'print_id' => 127,
                'sub_id' => 2
            ],
            [
                'calculators' => [3859, 3860],
                'specie_type' => 34,
                'print_id' => 128,
                'sub_id' => 2,
                'is_duplex' => true
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858],
                'specie_type' => 0,
                'print_id' => 124,
                'sub_id' => 2
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858],
                'specie_type' => 30,
                'print_id' => 125,
                'sub_id' => 2
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858],
                'specie_type' => 30,
                'print_id' => 126,
                'sub_id' => 2,
                'is_duplex' => true
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858],
                'specie_type' => 31,
                'print_id' => 127,
                'sub_id' => 2
            ],
            [
                'calculators' => [3855, 3856, 3866, 3857, 3858],
                'specie_type' => 31,
                'print_id' => 128,
                'sub_id' => 2,
                'is_duplex' => true
            ],
            [
                'calculators' => [3859],
                'specie_type' => 0,
                'print_id' => 124,
                'sub_id' => 3
            ],
            [
                'calculators' => [3859],
                'specie_type' => 30,
                'print_id' => 125,
                'sub_id' => 3
            ],
            [
                'calculators' => [3859],
                'specie_type' => 30,
                'print_id' => 126,
                'sub_id' => 3,
                'is_duplex' => true
            ],
            [
                'calculators' => [3859],
                'specie_type' => 31,
                'print_id' => 127,
                'sub_id' => 3
            ],
            [
                'calculators' => [3859],
                'specie_type' => 31,
                'print_id' => 128,
                'sub_id' => 3,
                'is_duplex' => true
            ],
        ];

        foreach ($calculatorSpecieType as $item) {
            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => $calculatorId,
                    'specie_type_id' => $item['specie_type'],
                    'print_id' => $item['print_id'],
                    'calculator_sub_id' => $item['sub_id'],
                    'is_duplex' => $item['is_duplex'] ?? false
                ]);
            }
        }

        // 3585

        $noPlastic = Plastic::query()->create([
            'name' => 'Без пластика'
        ]);

        $withPlastic = Plastic::query()->create([
            'name' => 'С пластиком'
        ]);

        $onlyPlastic = Plastic::query()->create([
            'name' => 'Только пластик'
        ]);

        $plastics = [
            [
                'calculator_id' => 3858,
                'plastics' => [$noPlastic->getKey(), $withPlastic->getKey(), $onlyPlastic->getKey()],
                'calculator_sub' => 3
            ]
        ];

        foreach ($plastics as $item) {
            foreach ($item['plastics'] as $plastic) {
                PivotCalculatorPlastic::query()->create([
                    'calculator_id' => $item['calculator_id'],
                    'calculator_sub_id' => $item['calculator_sub'],
                    'plastic_id' => $plastic
                ]);
            }
        }

        $pivotWorkAdditionalPlastic = [
            [
                'calculator_sub_id' => 3,
                'plastic' => [1, 2],
                'work_additional_id' => 54
            ]
        ];

        foreach ($pivotWorkAdditionalPlastic as $item) {
            foreach ($item['plastic'] as $plasticId) {
                PivotWorkAdditional::query()->create([
                    'plastic_id' => $plasticId,
                    'calculator_sub_id' => $item['calculator_sub_id'],
                    'work_additional_id' => $item['work_additional_id']
                ]);
            }
        }
    }

    private function sprintPosition()
    {
        $sprintPositions = [
            [
                'name' => 'Сверху',
                'calculators' => [3858]
            ],
            [
                'name' => 'Слева',
                'calculators' => [3858]
            ]
        ];

        foreach ($sprintPositions as $position) {
            $newPosition = SprintPosition::query()->create([
                'name' => $position['name']
            ]);

            foreach ($position['calculators'] as $calculatorId) {
                PivotCalculatorSprintPosition::query()->create([
                    'calculator_id' => $calculatorId,
                    'sprint_position_id' => $newPosition->getKey()
                ]);
            }
        }
    }

    private function colorsWorkAdditional(): void
    {
        $colorsWorks = [
            10 => 54,
            11 => 54,
            12 => 54,
            13 => 54
        ];

        foreach ($colorsWorks as $colorId => $workAdditionalId) {
            PivotWorkAdditional::query()->create([
                'color_id' => $colorId,
                'work_additional_id' => $workAdditionalId
            ]);
        }
    }
}
