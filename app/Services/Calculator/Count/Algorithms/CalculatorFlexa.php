<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Models\Color;
use App\Models\ColorPaint;
use App\Models\ExchangeRate;
use App\Models\Material;
use App\Models\PrintForm;
use App\Models\RapportKnife;
use App\Models\Calculator as CalculatorModel;
use App\Models\Ribbon;
use App\Services\CustomConfigs;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;

class CalculatorFlexa
{
    use LoggerTrait;
    use WorkAdditionalSetter;

    /**
     * Общий массив подсчёта
     * @var array
     */
    private array $calculable = [];

    /**
     * Цена евро в рублях
     * @var float
     */
    private float $euro;

    /**
     * Пользовательские статические настройки раздела
     * @var CustomConfigs
     */
    private readonly CustomConfigs $configs;

    /**
     * @param CalculatorModel $calculator
     * @throws BindingResolutionException
     */
    public function __construct(private readonly CalculatorModel $calculator)
    {
        $cacheKey = cache_key('calculator:flex:euro');

        $this->euro = Cache::tags(['calculator', 'flex', 'euro'])->remember(
            key: $cacheKey,
            ttl: now()->addWeek(),
            callback: fn () => ExchangeRate::where('name', 'eur')->first()?->value ?? 65,
        );

        $this->configs = app()->make(CustomConfigs::class);
    }

    /**
     * Цена за единицу печати
     * @return float
     */
    public function getItemPrice(): float
    {
        $totalPrice = $this->getPriceByKey('total_price_first_circulation');

        if ($totalPrice < $this->calculator->min_price) {
            return $this->calculator->min_price / $this->calculable['quantity'];
        }

        return $this->getPriceByKey('total_price_first_circulation_item');
    }

    /**
     * Возвращает цену при заказе повторного тиража
     * @return float
     */
    public function getRepeatCirculationPrice(): float
    {
        return $this->getPriceByKey('total_price_repeat_circulation_item');
    }

    /**
     * Общая стоимость печати
     * @return float
     */
    public function getTotalPrice(): float
    {
        $totalPrice = $this->getPriceByKey('total_price_first_circulation');

        if ($totalPrice < $this->calculator->min_price) {
            $totalPrice = $this->calculator->min_price;
        }

        return $totalPrice;
    }

    /**
     * Возвращает цену по ключу, если ключа нет, то производит подсчёт
     * @param string $keyName
     * @return float
     */
    private function getPriceByKey(string $keyName): float
    {
        if (!isset($this->calculable[$keyName])) {
            $this->calculate();
        }

        return (float) $this->calculable[$keyName];
    }

    /**
     * @param int|null $formId
     * @return void
     */
    public function setForm(int $formId = null): void
    {
        if ($formId) {
            $this->calculable['form'] = $formId;
            $this->calculable['knife_form'] = PrintForm::query()->find($formId)->name;
        } else {
            $this->calculable['form'] = $this->calculator->printForm->id;
            $this->calculable['knife_form'] = $this->calculator->printForm->name;
        }
    }

    /**
     * Метод подсчёта всех цен, копипаст кусков кода со старого проекта
     * @return void
     */
    private function calculate(): void
    {
        $this->calculable['knife_form'] = $this->calculator->printForm->name;
        $this->calculable['total_cost_price'] =
            $this->calculable['material_cost_price_rub_total'] + $this->calculable['print_cost_price_rub'];
        $this->calculable['total_cost_price_first_circulation'] =
            $this->calculable['total_cost_price'] +
            $this->calculable['add_print_cost_price_rub'] +
            $this->calculable['add_knife_cost_price'] / ($this->calculable['knife']['isset_knife'] ? 5 : 1) +
            $this->calculable['add_printed_forms_rub'] +
            ($this->calculable['sleeve_cost_price_rub'] ?? 0);
        $this->calculable['total_cost_price_repeat_circulation'] =
            $this->calculable['total_cost_price'] +
            $this->calculable['add_print_cost_price_rub'] +
            ($this->calculable['sleeve_cost_price_rub'] ?? 0);

        $first_knife_price = $this->calculable['knife']['isset_knife']
            ? $this->calculable['add_knife_price'] / 5
            : $this->calculable['add_knife_price'];
        $this->calculable['material_length_adds'] = ceil(
            $this->calculable['running_meters'] + $this->calculable['quantity_colors'] * $this->calculable['makeready'],
        );

        $this->calculable['square_meters_adds'] =
            ($this->calculable['material_length_adds'] * $this->calculable['knife']['print_height']) / 1000;
        $this->calculable['total_price_first_circulation_item'] =
            ceil(
                round(
                    (($this->calculable['material_price_rub_total'] +
                        ($this->calculable['thermo_print'] ?? 0) +
                        $this->calculable['print_price_rub'] +
                        $this->calculable['add_print_price_rub'] +
                        $first_knife_price +
                        $this->calculable['add_printed_forms_rub'] +
                        ($this->calculable['sleeve_cost_price_rub'] ?? 0)) /
                        $this->calculable['quantity']) *
                        100,
                    2,
                ),
            ) / 100;

        $this->calculable['total_price_first_circulation'] =
            $this->calculable['total_price_first_circulation_item'] * $this->calculable['quantity'];
        $this->calculable['total_price_repeat_circulation_item'] =
            ceil(
                round(
                    (($this->calculable['material_price_rub_total'] +
                        $this->calculable['print_price_rub'] +
                        $this->calculable['add_print_price_rub'] +
                        ($this->calculable['thermo_print'] ?? 0) +
                        ($this->calculable['sleeve_cost_price_rub'] ?? 0) +
                        ceil(round(($this->calculable['add_knife_price'] / 5) * 100, 2)) / 100 +
                        ceil(round(($this->calculable['add_printed_forms_rub'] / 2) * 100, 2)) / 100) /
                        $this->calculable['quantity']) *
                        100,
                    2,
                ),
            ) / 100;
        $this->calculable['total_price_repeat_circulation'] =
            $this->calculable['total_price_repeat_circulation_item'] * $this->calculable['quantity'];
        if (intval($this->configs->get('min_price')) > $this->calculable['total_price_first_circulation']) {
            $this->calculable['total_price_first_circulation_item'] = round(
                $this->configs->get('min_price') / $this->calculable['quantity'],
                2,
            );
            $this->calculable['total_price_repeat_circulation_item'] =
                $this->calculable['total_price_first_circulation_item'];
            $this->calculable['total_price_first_circulation'] =
                $this->calculable['total_price_first_circulation_item'] * $this->calculable['quantity'];
            $this->calculable['total_price_repeat_circulation'] = $this->calculable['total_price_first_circulation'];
        } elseif (intval($this->configs->get('min_price')) > $this->calculable['total_price_repeat_circulation']) {
            $this->calculable['total_price_repeat_circulation_item'] = round(
                $this->configs->get('min_price') / $this->calculable['quantity'],
                2,
            );
            $this->calculable['total_price_repeat_circulation'] =
                $this->calculable['total_price_repeat_circulation_item'] * $this->calculable['quantity'];
        }
    }

    public function getCalculable(): array
    {
        return $this->calculable;
    }

    /**
     * Устанавливает нож для печати
     * @param int $knifeId
     * @param bool $isDummy
     * @return void
     */
    public function setKnife(int $knifeId, bool $isDummy): void
    {
        $knife = RapportKnife::query()->find($knifeId);

        $this->calculable['knife'] = $knife;
        $this->calculable['rapport'] = $knife->rapport;

        if ($isDummy) {
            $this->calculable['knife']['print_height'] = intval($this->calculable['knife']['print_height']) - 10;
        }
    }

    public function setThermal(int $thermal): self
    {
        $this->calculable['thermal'] = $thermal;

        return $this;
    }

    /**
     * Устанавливает количество продукции
     * *приходит с фронта $request['product_count']*
     * @param int $count
     * @return Calculator
     */
    public function setProductCount(int $count): self
    {
        $this->calculable['quantity'] = $count;

        return $this;
    }

    /**
     * Устанавливает пользовательские цвета для подсчёта
     * @param array $paints
     * @return Calculator
     */
    public function setCustomPaints(array $paints): self
    {
        $this->calculable['custom_paints'] = $paints;

        return $this;
    }

    /**
     * Устанавливает цвет
     * @param int $colorId
     * @return Calculator
     */
    public function setColor(int $colorId): self
    {
        $this->calculable['color'] = Color::query()->find($colorId);

        return $this;
    }

    public function setSleeveQuantity(int $quantity): self
    {
        $this->calculable['sleeve_quantity'] = $quantity;

        return $this;
    }

    public function setRibbon(int $ribbonId): self
    {
        $this->calculable['ribbon'] = Ribbon::find($ribbonId)->material;

        return $this;
    }

    public function setMaterial(string|int $materialId, string $material_name = 'material'): self
    {
        $this->calculable['material'] = Material::query()->find($materialId);

        return $this;
    }

    /**
     * Устанавливает материалы ленты
     * @param array $ribbonMaterials
     * @return Calculator
     */
    public function setRibbonMaterials(array $ribbonMaterials = []): self
    {
        $ribbonMaterials[] = 'material';
        $this->calculable['material_weight_total'] = 0;
        $this->calculable['material_volume_total'] = 0;
        $this->calculable['material_cost_price_total'] = 0;
        $this->calculable['material_cost_price_rub_total'] = 0;
        $this->calculable['material_price_total'] = 0;
        $this->calculable['material_price_rub_total'] = 0;

        foreach ($ribbonMaterials as $material_name) {
            $this->calculable[$material_name . '_weight'] =
                ceil(
                    round(($this->calculable[$material_name]['weight'] * $this->calculable['square_meters']) / 10, 2),
                ) / 100;
            $this->calculable[$material_name . '_volume'] =
                ceil(
                    round(
                        ($this->calculable[$material_name]['volume'] * $this->calculable['square_meters']) / 10000,
                        2,
                    ),
                ) / 100;
            $this->calculable[$material_name . '_cost_price'] =
                ceil(round($this->calculable[$material_name]['price'] * $this->calculable['square_meters'] * 100, 2)) /
                100;
            $this->calculable[$material_name . '_cost_price_rub'] =
                ceil(round($this->calculable[$material_name . '_cost_price'] * $this->euro * 100, 2)) / 100;
            $this->calculable[$material_name . '_price'] =
                ceil(
                    round(
                        (($this->calculable[$material_name . '_cost_price'] / 100) *
                            $this->calculable[$material_name]['price_percent'] +
                            $this->calculable[$material_name . '_cost_price']) *
                            100,
                        2,
                    ),
                ) / 100;
            $this->calculable[$material_name . '_price_rub'] =
                ceil(round($this->calculable[$material_name . '_price'] * $this->euro * 100, 2)) / 100;
            $this->calculable['material_weight_total'] += $this->calculable[$material_name . '_weight'];
            $this->calculable['material_volume_total'] += $this->calculable[$material_name . '_volume'];
            $this->calculable['material_cost_price_total'] += $this->calculable[$material_name . '_cost_price'];
            $this->calculable['material_cost_price_rub_total'] += $this->calculable[$material_name . '_cost_price_rub'];
            $this->calculable['material_price_total'] += $this->calculable[$material_name . '_price'];
            $this->calculable['material_price_rub_total'] += $this->calculable[$material_name . '_price_rub'];
        }

        $this->calculable['weight'] = $this->calculable['material_weight_total'];

        return $this;
    }

    public function setCount()
    {
        $length = $this->calculable['rapport']['rapport_length'];
        $this->calculable['plate'] = $this->calculable['knife']['print_height'] . 'x' . $length;
        $this->calculable['counted_items'] = ceil(
            $this->calculable['knife']['count_rapport'] * $this->calculable['knife']['count_rows'],
        );
        $this->calculable['counted_plates'] =
            ceil(round(($this->calculable['quantity'] / $this->calculable['counted_items']) * 100, 2)) / 100;
        $this->calculable['running_meters'] = ($length * $this->calculable['counted_plates']) / 1000;
        $this->calculable['length_circulation'] =
            $this->calculable['running_meters'] * $this->calculable['knife']['count_rows'];
        $this->calculable['square_meters'] =
            ($this->calculable['knife']['print_height'] * $this->calculable['running_meters']) / 1000;
        return $this;
    }

    /**
     * @param int $printId
     * @return Calculator
     */
    public function setPrint(int $printId = 0): self
    {
        $this->calculable['paints'] = [];

        $this->calculable['custom_paints_unic'] = array_count_values(
            array_map(function ($paint) {
                return $paint->name;
            }, $this->calculable['custom_paints']),
        );

        $paints = [];
        if (!isset($this->calculable['color'])) {
            foreach ($this->calculable['custom_paints'] as $customPaint) {
                $paints[] = ColorPaint::query()->find($customPaint->id);
            }
        } else {
            $paints = $this->calculable['color']->paints;
        }

        if ($paints) {
            $print_price = 0;
            $price_percent = 0;

            foreach ($paints as $paint) {
                $paints_pack = $this->calculable['square_meters'] * $paint->consumption;

                $minPantoneLitres = (int) $this->configs->get('pantone_displacement');
                if ($paint->is_pantone) {
                    if ($minPantoneLitres && $paints_pack > $minPantoneLitres) {
                        $full_pack = $paints_pack / $minPantoneLitres;
                        if ($full_pack - floor($full_pack) > 0) {
                            $paints_pack = floor($full_pack) + 1;
                        }
                    } else {
                        $paints_pack = 1;
                    }
                }

                $paint->color_price = round($paint->price * $paints_pack, 2);
                $this->calculable['paints'][] = $paint;
                $print_price += $paint->color_price;
                $price_percent = $paint->price_percent;
            }

            $this->calculable['print_cost_price'] = ceil(round($print_price * 100, 2)) / 100;
            $this->calculable['print_cost_price_rub'] =
                ceil(round($this->calculable['print_cost_price'] * $this->euro * 100, 2)) / 100;
            $this->calculable['print_price'] =
                ceil(
                    round(
                        (($this->calculable['print_cost_price'] / 100) * $price_percent +
                            $this->calculable['print_cost_price']) *
                            100,
                        2,
                    ),
                ) / 100;
            $this->calculable['print_price_rub'] =
                ceil(round($this->calculable['print_price'] * $this->euro * 100, 2)) / 100;
        } else {
            $this->calculable['print_cost_price'] = 0;
            $this->calculable['print_cost_price_rub'] = 0;
            $this->calculable['print_price'] = 0;
            $this->calculable['print_price_rub'] = 0;
        }

        return $this;
    }

    /**
     * @param object $parameters
     * @return $this
     */
    public function setAddJob(object $parameters = new \stdClass()): self
    {
        //set custom settings if redefine
        // количество цветов, считает если передаётся параметр с их количеством или по count() красок
        //        if (isset($parameters->quantity_colors) ) {
        //        }

        $this->calculable['quantity_colors'] =
            $parameters?->quantity_colors ?? null === '0' || !empty($parameters?->quantity_colors)
                ? intval($parameters?->quantity_colors)
                : count($this->calculable['paints']);

        // фиксированная цена, берётся из настроек или из переданных в запросе параметров
        $fixed_price =
            $parameters?->fixed_price ?? null === '0' || !empty($parameters?->fixed_price)
                ? floatval($parameters->fixed_price)
                : $this->configs->get('fix_euro_price');
        $this->calculable['makeready'] =
            $parameters?->makeready ?? null === '0' || !empty($parameters?->makeready)
                ? floatval($parameters->makeready)
                : $this->configs->get('fitting_meters');
        $flexa_min_price =
            $parameters?->flexa_min_price ?? null === '0' || !empty($parameters?->flexa_min_price)
                ? floatval($parameters->flexa_min_price)
                : $this->configs->get('min_order_price');
        $knife_price = $this->calculable['knife']['price'];
        if ($parameters?->knife_price ?? null === '0' || !empty($parameters?->knife_price)) {
            $knife_price = floatval($parameters->knife_price);
        } elseif (isset($parameters->form) && $parameters->form == 4) {
            $knife_price = 0;
        }
        $knife_price_percent =
            $parameters?->knife_price_percent ?? null === '0' || !empty($parameters?->knife_price_percent)
                ? floatval($parameters->knife_price_percent)
                : $this->calculable['knife']['price_percent'];

        $this->calculable['add_printed_forms'] =
            ceil(
                round(
                    ($this->calculable['knife']['print_height'] *
                        $this->calculable['rapport']['rapport_length'] *
                        $this->calculable['quantity_colors'] *
                        $fixed_price *
                        100) /
                        1000,
                    2,
                ),
            ) / 100;
        $this->calculable['add_printed_forms_extra'] = $this->calculable['add_printed_forms'];
        if ($this->configs->get('form_markup_percent')) {
            $this->calculable['add_printed_forms_extra'] =
                ($this->calculable['add_printed_forms'] / 100) * $this->configs->get('form_markup_percent') +
                $this->calculable['add_printed_forms'];
        }
        $this->calculable['add_printed_forms_rub'] =
            ceil(round($this->calculable['add_printed_forms'] * $this->euro * 100, 2)) / 100;
        $this->calculable['add_printed_forms_rub_extra'] =
            ceil(round($this->calculable['add_printed_forms_extra'] * $this->euro * 100, 2)) / 100;
        $this->calculable['add_print_cost_price'] =
            ceil(
                round(
                    (($this->calculable['knife']['print_height'] *
                        $this->calculable['makeready'] *
                        $this->calculable['material']['price'] *
                        $this->calculable['quantity_colors']) /
                        1000) *
                        100,
                    2,
                ),
            ) / 100;
        $this->calculable['add_print_cost_price_rub'] =
            ceil(round($this->calculable['add_print_cost_price'] * $this->euro * 100, 2)) / 100;
        $this->calculable['add_print_price'] =
            ceil(
                round(
                    (($this->calculable['add_print_cost_price'] / 100) *
                        $this->calculable['material']['price_percent'] +
                        $this->calculable['add_print_cost_price']) *
                        100,
                    2,
                ),
            ) / 100;
        $this->calculable['add_print_price_rub'] =
            ceil(round($this->calculable['add_print_price'] * $this->euro * 100, 2)) / 100;
        if ($this->calculable['add_print_price_rub'] < intval($flexa_min_price)) {
            $this->calculable['add_print_price_rub'] = $flexa_min_price;
            $this->calculable['add_print_price_min'] = true;
        }
        $this->calculable['add_knife_cost_price'] = $knife_price;
        $this->calculable['add_knife_price'] = ($knife_price / 100) * $knife_price_percent + $knife_price;
        if (
            (isset($this->calculable['type']) && $this->calculable['type'] == '3851') ||
            isset($this->calculable['thermal'])
        ) {
            $this->calculable['thermo_print'] = intval($this->configs->get('thermo_print'));
        }
        $this->calculable['add_total_cost_price'] =
            $this->calculable['add_printed_forms_rub'] +
            $this->calculable['add_print_cost_price_rub'] +
            $this->calculable['add_knife_cost_price'];
        $this->calculable['add_total_price'] =
            $this->calculable['add_printed_forms_rub'] +
            $this->calculable['add_print_price_rub'] +
            $this->calculable['add_knife_price'] +
            ($this->calculable['thermo_print'] ?? 0);
        // втулки
        if (isset($this->calculable['sleeve_quantity']) && !empty($this->calculable['sleeve_quantity'])) {
            $this->calculable['sleeve_cost_price'] =
                $this->calculable['sleeve_quantity'] * $this->configs->get('markup_bushing_price');
            $this->calculable['sleeve_cost_price_rub'] = $this->calculable['sleeve_cost_price'] * $this->euro;
            $this->calculable['sleeve_price_total'] =
                $this->calculable['sleeve_cost_price'] +
                ($this->calculable['sleeve_cost_price'] / 100) * $this->configs->get('markup_bushing_price_percent');
            $this->calculable['sleeve_price_total_rub'] = $this->calculable['sleeve_price_total'] * $this->euro;
            $this->calculable['add_total_cost_price'] += $this->calculable['sleeve_cost_price_rub'];
            $this->calculable['add_total_price'] += $this->calculable['sleeve_price_total_rub'];
        }

        return $this;
    }
}
