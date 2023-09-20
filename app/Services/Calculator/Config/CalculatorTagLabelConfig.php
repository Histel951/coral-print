<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Models\PrintForm;
use App\Models\Ribbon;
use App\Repositories\Color\ColorPaintRepositoryInterface;
use App\Repositories\Knifes\RapportKnifeRepositoryInterface;
use App\Services\Calculator\CalculatorDepsInterface;
use App\Services\Calculator\CalculatorRoute;
use App\Services\Calculator\CalculatorService;
use App\Services\Calculator\FieldsService;
use App\Services\Calculator\FieldTrait;
use App\Services\ModelTextMessage;
use App\Services\Tooltip;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CalculatorTagLabelConfig implements CalculatorConfigInterface
{
    use FieldTrait;

    /**
     * Калькулятор для подтягивания и формирования конфигов
     * @var Calculator
     */
    private Calculator $calculator;

    /**
     * Формирует массив конфигов
     * @var ConfigBuilder
     */
    private ConfigBuilder $configBuilder;

    /**
     * Поля калькулятора
     * @var FieldsService
     */
    private FieldsService $fieldsService;

    /**
     * Материалы калькулятора
     * @var MaterialService
     */
    private MaterialService $materialService;

    /**
     * Подсказки калькулятора
     * @var Tooltip
     */
    private Tooltip $tooltip;

    /**
     * Роуты калькулятора
     * @var CalculatorRoute
     */
    private CalculatorRoute $calculatorRoute;

    /**
     * Возвращает текст для данных в зависимости от модели
     * @var ModelTextMessage
     */
    private ModelTextMessage $modelTextMessage;

    /**
     * Отображение значений в зависимости от других
     * @var CalculatorDepsInterface|mixed
     */
    private CalculatorDepsInterface $calculatorDeps;

    /**
     * Репозиторий ножей
     * @var RapportKnifeRepositoryInterface
     */
    private RapportKnifeRepositoryInterface $knifeRepository;

    /**
     * Репозиторий цветов и красок
     * @var ColorPaintRepositoryInterface
     */
    private ColorPaintRepositoryInterface $colorPaintRepository;

    /**
     * @param Calculator $calculator
     * @throws BindingResolutionException
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;

        $this->configBuilder = app()->make(ConfigBuilder::class);

        $this->fieldsService = app()->make(FieldsService::class, [
            'calculator' => $calculator,
        ]);

        $this->materialService = app()->make(CalculatorService::class, [
            'calculator' => $calculator
        ])->material();

        $this->tooltip = app()->make(Tooltip::class, [
            'calculator' => $calculator,
        ]);

        $this->calculatorRoute = app()->make(CalculatorRoute::class, [
            'calculator' => $calculator,
        ]);

        $this->modelTextMessage = app()->make(ModelTextMessage::class, [
            'calculator' => $calculator,
        ]);

        $this->knifeRepository = app()->make(RapportKnifeRepositoryInterface::class);
        $this->calculatorDeps = app()->make(CalculatorDepsInterface::class);
        $this->colorPaintRepository = app()->make(ColorPaintRepositoryInterface::class);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = []): array
    {
        return $this->configBuilder
            ->standard(
                calculator: $this->calculator,
                fields: $this->fieldsService->fields(),
                checkboxes: $this->fieldsService->checkboxes(),
                routes: $this->calculatorRoute->getRoutes($this->materialService->designPrices()),
                data: $this->getData($parameters),
                deps: $this->deps(),
                validators: $this->materialService->validators(),
                tooltips: $this->tooltip->getTooltips()
            )
            ->getConfig();
    }

    private function deps(): array
    {
        $isRibbonCalculator =
            isset($this->calculator->parameters['is_ribbon']) && $this->calculator->parameters['is_ribbon'];

        if ($isRibbonCalculator) {
            Ribbon::all()->each(fn (Ribbon $ribbon) => $this->calculatorDeps->setDep(
                conditions: [
                    'ribbon' => $ribbon->id
                ],
                data: $this->materialStruct($ribbon->materials()),
                changedFieldName: 'material_select'
            ));
        }

        PrintForm::all()->each(fn (PrintForm $printForm) => $this->calculatorDeps->setDep(
            conditions: [
                'form' => $printForm->id
            ],
            data: $this->knifeRepository->knifes($this->calculator, $printForm),
            changedFieldName: 'knife'
        ));

        $isDummy = isset($this->calculator->parameters['is_dummy']) && $this->calculator->parameters['is_dummy'];

        if ($isDummy) {
            $this->calculatorDeps->setDep(
                conditions: [
                    'dummy' => 1
                ],
                data: $this->colorPaintRepository->getColorPaintForField(
                    $this->calculator,
                    fn (BelongsToMany $colors) => $colors->where('is_empty', true)
                ),
                changedFieldName: 'color_paints'
            );

            $this->calculatorDeps->setDep(
                conditions: [
                    'dummy' => 0
                ],
                data: $this->colorPaintRepository->getColorPaintForField(
                    $this->calculator,
                    fn (BelongsToMany $colors) => $colors->where('is_empty', false)
                ),
                changedFieldName: 'color_paints'
            );
        }

        return $this->calculatorDeps->get();
    }

    /**
     * Формирование массива с данными для полей
     * @param array $parameters
     * @return array
     */
    private function getData(array $parameters = []): array
    {
        $fieldsData['material'] = $this->materialService->materials(['print_type' => $printType ?? null]);
        $printType = $parameters['print_type'] ?? $this->calculator->prints?->first()?->id;

        $fieldsData['print_type'] = $this->materialService->prints();
        $fieldsData['cutting'] = $this->materialService->cuttings();
        $fieldsData['width-height'] = $this->calculator->calculatorType?->printSizes ?? [];
        $fieldsData['lam'] = $this->materialService->laminations(['print_type' => $printType ?? null]);
        $fieldsData['foiling'] = $this->materialService->foilings();
        $fieldsData['form'] = $this->materialService->forms();
        $fieldsData['knife'] = $this->knifeRepository->knifes($this->calculator, $this->calculator->printForm);
        $fieldsData['color_paints'] = $this->colorPaintRepository->getColorPaintForField($this->calculator);
        $fieldsData['location'] = $this->calculator->windingCategories()->with([
            'windings' => fn (BelongsToMany $winding) => $winding->with(['image', 'preview'])
        ])->get();
        $fieldsData['ribbon'] = Ribbon::all();

        foreach ($fieldsData['location'] as $categoryWinding) {
            $categoryWinding['items'] = $categoryWinding['windings'];
            unset($categoryWinding['windings']);
        }

        return $fieldsData;
    }
}
