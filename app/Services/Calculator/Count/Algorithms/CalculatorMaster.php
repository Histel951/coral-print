<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Models\Calculator as CalculatorModel;
use App\Models\Formulas;
use App\Models\Material;
use App\Models\PrintSpecie;
use App\Models\SpecieType;
use App\Services\Calculator\Count\Util\Exceptions\WorkAdditionalException;
use App\Services\Calculator\Count\Util\RestrictionSizeChecker;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;

class CalculatorMaster implements Calculator
{
    use LoggerTrait;
    use WorkAdditionalSetter;

    /**
     * Нужно ли округлять $this->calculable['total_price'] до целого числа после подсчёта
     * @var bool
     */
    protected bool $isRoundedTotalPrice = false;

    protected array $calculable = [];

    protected $timeStart;

    protected $formulasDict;

    /**
     * @param CalculatorModel|null $calculator модель калькулятора с данными
     */
    public function __construct(private readonly CalculatorModel|null $calculator = null)
    {
        $this->loadFormulas();
    }

    //utility

    /**
     * @return array
     */
    public function getTotalOnly(): array
    {
        return [
            'total_price' => $this->calculable['total_price'],
            'item_price' => $this->calculable['count_item_price'],
            'weight' => $this->calculable['weight'],
        ];
    }

    /**
     * @return array
     */
    public function getCalculable(): array
    {
        return $this->calculable;
    }

    /**
     * @return string
     */
    public function getDebugLog(): string
    {
        return join(PHP_EOL, $this->debugLog);
    }

    //getters

    /**
     * @return Calculator
     */

    public function getBeforeTotal(): Calculator
    {
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        //count items_on_page and material_count
        if (!isset($this->calculable['items_on_page']) && $this->calculable['type'] != 'banner') {
            $this->getItemsOnPage();
            $this->setMaterialCount();
            $this->countMaterialPrice();
        }

        //additional jobs counting
        if (isset($this->calculable['add_jobs'])) {
            $this->countAdditionalJobs();
        }

        $this->countWeightVolume();
        //Print Count
        //getting total print price
        if (isset($this->calculable['print'])) {
            if (isset($this->calculable['print']['type'])) {
                if ($this->calculable['print']['type'] == 1) {
                    $this->interpolPriceCount($this->calculable['print']);
                } else {
                    $this->normalPriceCount($this->calculable['print']);
                }
            }
        }

        $this->calculable['total_price'] = 0;
        //adds every *_total variable without total_price to total_price
        foreach ($this->calculable as $key => $item) {
            if (strpos($key, '_total') !== false && $key != 'total_price') {
                $this->calculable['total_price'] += $item;
            }
        }

        if (floor((int) $this->calculable['total_price']) < $this->calculator->min_price) {
            $this->calculable['result_total_price'] = $this->calculator->min_price;
        } else {
            $this->calculable['result_total_price'] = $this->calculable['total_price'];
        }

        $this->setItemPrice();
        $this->getTotalCost();

        return $this->calcTotalPrice();
    }

    /**
     * Устанавливает флаг, нужно ли округлять полученный результат подсчёта до целого
     * @param bool $isRounded
     * @return void
     */
    public function setRoundedTotalPrice(bool $isRounded): void
    {
        $this->isRoundedTotalPrice = $isRounded;
    }

    protected function calcTotalPrice(): float
    {
        if (!isset($this->calculable['part'])) {
            $this->calculable['total_price'] =
                $this->calculable['count_item_price'] * $this->calculable['product_count'];
        }

        if ($this->isRoundedTotalPrice) {
            $this->calculable['total_price'] = round($this->calculable['total_price']);
        }

        if (isset($this->calculable['addition_types_price'])) {
            $this->calculable['total_price'] += $this->calculable['addition_types_price'];
        }

        return $this->calculable['total_price'];
    }

    protected function getCorrectPrice(
        array &$data,
        string $prices_name = 'prices',
        string $prices_key = 'price',
        string $count_name = 'print_count',
    ) {
        if (isset($data[$prices_name]) && end($data[$prices_name])['quantity'] < $this->calculable[$count_name]) {
            $this->calculable['print_quantity_price'] = end($data[$prices_name])[$prices_key];
            $this->countPrintPrice(end($data[$prices_name]), isset($data['is_duplex']));
        } else {
            $this->calculable['print_quantity_price'] = 0;
            $i = 0;
            $len = count($data[$prices_name]);
            foreach ($data[$prices_name] as $price) {
                if ($this->calculable[$count_name] == $price['quantity']) {
                    $this->calculable['print_quantity_price'] = $data[$prices_name][$i][$prices_key];
                    if (isset($data[$prices_name][$i])) {
                        $this->countPrintPrice($data[$prices_name][$i], isset($data['is_duplex']));
                        break;
                    }
                } elseif ($this->calculable[$count_name] < $price['quantity'] || $i == $len - 1) {
                    if (isset($data[$prices_name][$i - 1][$prices_key])) {
                        $this->calculable['print_quantity_price'] = $data[$prices_name][$i - 1][$prices_key];
                        $this->countPrintPrice($data[$prices_name][$i - 1], isset($data['is_duplex']));
                        break;
                    }
                }
                $i++;
            }
        }
    }

    protected function normalPriceCount(array &$data, string $print_name = 'print'): void
    {
        if (isset($this->calculable['paints_quantity'])) {
            $this->getCorrectPrice(
                $data,
                'paints',
                'paint' . ($this->calculable['paints_quantity'] ?: 1),
                'material_count',
            );
        } else {
            $this->getCorrectPrice($data);
        }
    }

    protected function getJobPrice($job, $product_count): array
    {
        $pricesItem = [];
        if (count($job['prices']) == 1) {
            $pricesItem = reset($job['prices']);
        } else {
            $i = 0;
            while ($i <= count($job['prices'])) {
                if ($job['prices'][$i]['circulation'] == $product_count) {
                    $pricesItem = $job['prices'][$i];
                    break;
                }
                if ($product_count > end($job['prices'])['circulation']) {
                    $pricesItem = end($job['prices']);
                    break;
                }
                if (
                    $product_count > $job['prices'][$i]['circulation'] &&
                    $product_count < $job['prices'][$i + 1]['circulation']
                ) {
                    $pricesItem = $job['prices'][$i];
                    break;
                } else {
                    $i++;
                    continue;
                }
            }
        }
        return $pricesItem;
    }

    protected function getAddJobCost(array $job, bool $multiple = true): float
    {
        switch ($job['formula']['name']) {
            case 'prct':
                if (isset($this->calculable['grommet'])) {
                    $pricesItem = $this->getJobPrice($job, $this->calculable['product_count']);
                    $perimeter =
                        ($this->calculable['layout_width'] / 1000 +
                            $this->calculable['layout_height'] / 1000 +
                            ($this->calculable['departure'] / 1000) * 4) *
                        2;
                    $grommet = round(($perimeter / intval($this->calculable['grommet'])) * 100);
                    $data['count'] =
                        $grommet *
                        $pricesItem['price'] *
                        ((1 + $pricesItem['charge'] / 100) * $this->calculable['product_count']);
                    return $grommet * $pricesItem['price'] * $this->calculable['product_count'];
                }
                break;
            case 'fs':
                return floatval(reset($job['prices'])['fixed_sum']);
                break;
            case 'prmct':
                $pricesItem = $this->getJobPrice($job, $this->calculable['product_count']);
                $perimeter =
                    ($this->calculable['layout_width'] / 1000 +
                        $this->calculable['layout_height'] / 1000 +
                        ($this->calculable['departure'] / 1000) * 4) *
                    2;
                return floatval($perimeter * $pricesItem['price'] * $this->calculable['product_count']);
                break;
            case 'k1ct':
                $product_count = $this->calculable['product_count'];
                if (isset($this->calculable['product_quantity'])) {
                    $product_count = $this->calculable['product_quantity'];
                }
                $pricesItem = $this->getJobPrice($job, $product_count);
                if ($multiple) {
                    return floatval($pricesItem['price']) * $product_count;
                } else {
                    return floatval(reset($job['prices'])['price']);
                }
                break;
            case 'percent':
                //                if ($multiple) {
                // phpcs:ignore
                //                    return floatval(reset($this->calculable['print']['prices'])['price'] * (1 + reset($job['prices'])['percent'] / 100));
                $prices = reset($job['prices']);
                return floatval(($this->calculable['print_price_total'] * $prices['percent']) / 100);
                //                } else {
                //                    return floatval(reset($this->calculable['prices'])['price']);
                //                }
                break;
            case 'plmct':
                $priceItem = $this->getSquareMetersPrices($job);
                return floatval($priceItem['price']) * $this->calculable['print_count'];
                break;
            case 'lc':
                if ($multiple) {
                    if (isset($this->calculable['linear_meters'])) {
                        $priceItem = $this->getSquareMetersPrices($job, 'list_meters', 'linear_meters');
                        return floatval($priceItem['price']) * $this->calculable['linear_meters'];
                    } elseif (isset($this->calculable['material_count'])) {
                        $priceItem = $this->getSquareMetersPrices($job);
                        return floatval($priceItem['price']) * $this->calculable['material_count'];
                    }
                } else {
                    $priceItem = reset($job['prices']);
                    return floatval($priceItem['price']);
                }
                break;
            case 'scc':
                return floatval($this->calculable['paints_quantity'] * $job['prices'][0]['fixed_sum']);
        }
    }

    public function setLayoutPrintCount($roundUp = true): void
    {
        $print_count =
            (($this->addDeparture($this->calculable['layout_width']) *
                $this->addDeparture($this->calculable['layout_height'])) /
                1000000) *
            $this->calculable['product_count'];
        if ($roundUp) {
            $this->calculable['print_count'] = ceil(round($print_count * 1000, 3)) / 1000;
        } else {
            $this->calculable['print_count'] = round($print_count, 3);
        }
    }

    protected function countMaterialPrice(string $material_name = 'material'): void
    {
        $this->calculable[$material_name . '_price_total'] =
            ceil(round($this->calculable[$material_name]['price'] * $this->calculable['material_count'] * 100, 2)) /
            100;
        $this->calculable['total_' . $material_name . '_cost'] =
            ceil(
                round($this->calculable[$material_name]['cost_price'] * $this->calculable['material_count'] * 100, 2),
            ) / 100;
    }

    protected function countAllMaterialPrice(array $material_names = ['material']): void
    {
        $this->calculable['material_price_total'] = 0;
        $this->calculable['total_material_cost'] = 0;
        foreach ($material_names as $name) {
            $this->calculable['material_price_total'] += $this->calculable[$name . '_price_total'];
            $this->calculable['total_material_cost'] += $this->calculable['total_' . $name . '_cost'];
        }
    }

    protected function countWeight($weight): float
    {
        $printSpecieVolume = 1;
        if (isset($this->calculable['print_specie']['volume'])) {
            $printSpecieVolume = $this->calculable['print_specie']['volume'];
        }

        return ($weight * $printSpecieVolume * $this->calculable['material_count']) / 1000;
    }

    protected function countVolume($width): float
    {
        $printSpecieVolume = 1;
        if (isset($this->calculable['print_specie']['volume'])) {
            $printSpecieVolume = $this->calculable['print_specie']['volume'];
        }

        return ($printSpecieVolume * $this->calculable['material_count'] * $width) / 1000000;
    }

    protected function countWeightVolume(): void
    {
        if (isset($this->calculable['paper']) && isset($this->calculable['plastic'])) {
            $this->calculable['weight'] =
                $this->countWeight($this->calculable['plastic']['weight']) +
                $this->countWeight($this->calculable['paper']['weight']);
            $this->calculable['volume'] =
                $this->countWeight($this->calculable['plastic']['width']) +
                $this->countWeight($this->calculable['paper']['width']);
        } else {
            $this->calculable['weight'] = $this->countWeight($this->calculable['material']['weight']);
            $this->calculable['volume'] = $this->countVolume($this->calculable['material']['width']);
        }
        if (isset($this->calculable['add_jobs_weight'])) {
            $this->calculable['weight'] += $this->calculable['add_jobs_weight'];
        }
        if (isset($this->calculable['add_jobs_volume'])) {
            $this->calculable['volume'] += $this->calculable['add_jobs_volume'];
        }

        $this->calculable['weight'] = number_format($this->calculable['weight'], 8);
        $this->calculable['volume'] = number_format($this->calculable['volume'], 8);
    }

    protected function addDeparture(int $side): int
    {
        return $side + $this->calculable['departure'] * 2;
    }

    protected function setMaterialCount(string $unit = 'pm'): void
    {
        switch ($unit) {
            case 'wide':
                $this->calculable['material_count'] =
                    ($this->calculable['wide_print_height'] * $this->calculable['wide_print_width']) / 1000000;
                break;
            case 'banner':
                $this->calculable['material_count'] = $this->calculable['print_count'];
                break;
            default:
                $this->calculable['material_count'] = ceil(
                    $this->calculable['product_count'] / $this->calculable['items_on_page'],
                );
        }
    }

    protected function modifyCalculableProp(string $prop_name, string $math_operator, $second_operator): void
    {
        $this->calculable[$prop_name] = eval(
            'return ' . $this->calculable[$prop_name] . $math_operator . $second_operator . ';'
        );
    }

    protected function setLinearMeters(): void
    {
        $this->calculable['linear_meters'] = $this->calculable['wide_print_height'] / 1000;
    }

    protected function setWidePrintWidthHeight(): void
    {
        $layout_bigger =
            $this->calculable['layout_height'] > $this->calculable['layout_width']
                ? $this->calculable['layout_height']
                : $this->calculable['layout_width'];
        $this->calculable['wide_print_height'] =
            ceil($this->calculable['product_count'] / $this->calculable['items_on_page']) *
            $this->addDeparture($layout_bigger);
        if (!isset($this->calculable['print']) || $this->calculable['print']['id'] == 23) {
            $this->calculable['wide_print_width'] = 1200;
        } elseif ($this->calculable['print']['id'] == 21) {
            $this->calculable['wide_print_width'] = 650;
        } elseif ($this->calculable['print']['id'] == 46) {
            $this->calculable['wide_print_width'] = 1520;
        }
    }

    protected function countAdditionalJobs(): void
    {
        //setting variable
        $this->calculable['add_jobs_total'] = 0;
        $add_jobs_weight_total = 0;
        $add_jobs_volume_total = 0;
        $this->calculable['jobs'] = [];
        //counts add jobs prices using their formulas
        foreach ($this->calculable['add_jobs'] as &$job) {
            //checking existing
            if (isset($job['prices']) && isset($job['formula'])) {
                //use Calculator formula by alias
                usort($job['prices'], function ($a, $b) {
                    return floatval($a['list_meters']) - floatval($b['list_meters']);
                });
                $this->{$job['formula']['name'] . 'Formula'}($job);
                //adding job price to total price
                $job['count'] *= $job['coefficient'];
                $this->calculable['add_jobs_total'] += $job['count'];
            } else {
                $this->setError('Not founded prices or formula for additional job ' . $job['name']);
            }
            $this->calculable['jobs'][trim($job['name'])][] = $job;
        }

        $this->jobsCost();

        foreach ($this->calculable['jobs'] as $resultJob) {
            foreach ($resultJob as $itemJob) {
                if (isset($itemJob['total_volume'])) {
                    $add_jobs_volume_total += $itemJob['total_volume'];
                }

                if (isset($itemJob['total_weight'])) {
                    $add_jobs_weight_total += $itemJob['total_weight'];
                }
            }
        }

        if ($add_jobs_volume_total && $add_jobs_weight_total) {
            $this->calculable['add_jobs_volume'] = $add_jobs_volume_total;
            $this->calculable['add_jobs_weight'] = $add_jobs_weight_total;
        }
    }

    public function jobsCost()
    {
        $this->calculable['add_job_cost'] = 0;
        foreach (array_keys($this->calculable['jobs']) as $key) {
            foreach ($this->calculable['jobs'][$key] as $k => $job) {
                $job_cost = $this->getAddJobCost($job) * $job['coefficient'];
                $this->calculable['add_job_cost'] = $job_cost + floatval($this->calculable['add_job_cost']);
                $this->calculable['jobs'][$key][$k]['job_cost'] = $job_cost;
            }
        }
    }

    public function getTotalCost(): void
    {
        $this->calculable['total_cost'] = 0;
        if (isset($this->calculable['total_material_cost'])) {
            $this->calculable['total_cost'] += floatval($this->calculable['total_material_cost']);
        }

        if (isset($this->calculable['print_cost'])) {
            $this->calculable['total_cost'] += floatval($this->calculable['print_cost']);
        }

        if (isset($this->calculable['add_job_cost'])) {
            $this->calculable['total_cost'] += floatval($this->calculable['add_job_cost']);
        }
    }

    protected function interpolPriceCount(array &$print): void
    {
        if (isset($print['prices'])) {
            $this->calculable['print_quantity_price'] = 0;
            if (end($print['prices'])['quantity'] <= $this->calculable['material_count']) {
                $this->calculable['print_quantity_price'] = end($print['prices'])['price'];
                $this->countPrintPrice(end($print['prices']), isset($print['is_duplex']));
            }
            foreach ($print['prices'] as $key => $price) {
                if (
                    $this->calculable['material_count'] <= $price['quantity'] &&
                    $this->calculable['print_quantity_price'] == 0
                ) {
                    $this->calculable['print_quantity_price'] = $print['prices'][max(0, $key - 1)]['price'];
                }
                if ($price['quantity'] == $this->calculable['material_count']) {
                    $this->calculable['print_quantity_price'] = $price['price'];
                    $this->countPrintPrice($price, isset($print['is_duplex']));
                }
            }

            //if quantity not exist in print prices and interpolation needed
            if (!isset($this->calculable['print_price_total'])) {
                if ($this->calculable['material_count'] > end($print['prices'])['quantity']) {
                    $this->calculable['interpol_print'] = $interpolPrice = end($print['prices'])['overprice'];
                } else {
                    $interpolMin = $this->setInterpolationMin($print);
                    $interpolMax = $this->setInterpolationMax($print);
                    $this->calculable['print_cost'] =
                        end($print['prices'])['price'] * $this->calculable['material_count'];
                    $interpolPrice = $this->countInterpolationPrintPrice($interpolMin, $interpolMax);
                    $this->calculable['interpol_print'] = round($interpolPrice);
                }

                $this->calculable['print_price_total'] =
                    $this->calculable['print_quantity_price'] *
                    (1 + round($interpolPrice) / 100) *
                    $this->calculable['material_count'];
                //if duplex doubles price
                if (isset($print['is_duplex'])) {
                    $this->calculable['print_price_total'] *= $print['duplex_coefficient'];
                    $this->calculable['print_cost'] *= $print['duplex_coefficient'];
                }
            }
        } else {
            $this->setError('Print don`t have prices');
        }
    }

    protected function countPrintPrice(array $price, $duplex = false): void
    {
        if ($this->calculable['print']['height'] == 0) {
            $this->calculable['print_cost'] = $price['price'] * $this->calculable['print_count'];
            $this->calculable['print_price_total'] =
                $this->calculable['print_count'] * ($price['price'] + ($price['price'] * $price['overprice']) / 100);
        } else {
            if (isset($this->calculable['paints_quantity'])) {
                if (isset($price['paint' . $this->calculable['paints_quantity']])) {
                    $final_price = $price['paint' . $this->calculable['paints_quantity']];
                } else {
                    $final_price = $price['price'];
                }
            } else {
                $final_price = $price['price'];
            }

            $this->calculable['print_cost'] = $final_price * $this->calculable['material_count'];
            //            $this->calculable['interpol_' . $print_name] = $price['overprice'];
            $this->calculable['print_price_total'] =
                $this->calculable['material_count'] * ($final_price + ($final_price * $price['overprice']) / 100);
        }

        if (isset($this->calculable['print']['is_duplex'])) {
            $this->calculable['print_cost'] *= $this->calculable['print']['duplex_coefficient'];
        }
        if ($duplex) {
            $this->calculable['print_price_total'] *= $this->calculable['print']['duplex_coefficient'];
        }
    }

    protected function setInterpolationMin(array $print): array
    {
        $i = count($print['prices']);
        while ($i > 0) {
            if ($print['prices'][$i - 1]['quantity'] > $this->calculable['material_count']) {
                --$i;
            } else {
                $min = $print['prices'][$i - 1]['quantity'];
                $minPrice = $print['prices'][$i - 1]['overprice'];
                break;
            }
        }

        return [
            'quantity' => $min,
            'price' => $minPrice,
        ];
    }

    protected function setInterpolationMax(array $print): array
    {
        $i = 0;
        while ($i < count($print['prices'])) {
            if ($print['prices'][$i]['quantity'] < $this->calculable['material_count']) {
                ++$i;
            } else {
                $max = $print['prices'][$i]['quantity'];
                $maxPrice = $print['prices'][$i]['overprice'];
                break;
            }
        }

        return [
            'quantity' => $max,
            'price' => $maxPrice,
        ];
    }

    /**
     * @param array $min
     * @param array $max
     * @return float
     */
    protected function countInterpolationPrintPrice(array $min, array $max): float
    {
        return (($min['price'] - $max['price']) / ($min['quantity'] - $max['quantity'])) *
            ($this->calculable['material_count'] - $max['quantity']) +
            $max['price'];
    }

    protected function countInterpolationAddJobPrice(array $min, array $max): float
    {
        return (($min['price'] - $max['price']) / ($min['circulation'] - $max['circulation'])) *
            ($this->calculable['product_count'] - $max['circulation']) +
            $max['price'];
    }

    /**
     * Устанавливает ширину печати для подсчёта количества эементов на странице, если возможно отсутствие печати
     * @param int|null $with
     * @return void
     */
    public function setPrintWidthWithoutPrint(int $with = null): void
    {
        $this->calculable['print_width_without_print'] = $with;
    }

    protected function getItemsOnPage(): void
    {
        if (!isset($this->calculable['print'])) {
            $width = isset($this->calculable['print_width_without_print'])
                ? (int) $this->calculable['print_width_without_print']
                : 1200;
            $this->calculable['items_on_page'] = floor($width / $this->addDeparture($this->calculable['layout_width']));
        } else {
            $album = $this->getAlbumItemsOnPage();
            $portrait = $this->getPortraitItemsOnPage();
            if ($album > $portrait) {
                $this->calculable['items_on_page'] = $album;
            } else {
                $this->calculable['items_on_page'] = $portrait;
            }
        }
    }

    /**
     * @return float
     */
    protected function getAlbumItemsOnPage(): float
    {
        $layout_items = floor(
            $this->calculable['print']['width'] / $this->addDeparture($this->calculable['layout_width']),
        );
        if ($this->calculable['print']['height'] > 0) {
            $layout_items *= floor(
                $this->calculable['print']['height'] / $this->addDeparture($this->calculable['layout_height']),
            );
        }
        return $layout_items ?: 1;
    }

    /**
     * @return float
     */
    protected function getPortraitItemsOnPage(): float
    {
        $layout_items = floor(
            $this->calculable['print']['width'] / $this->addDeparture($this->calculable['layout_height']),
        );
        if ($this->calculable['print']['height'] > 0) {
            $layout_items *= floor(
                $this->calculable['print']['height'] / $this->addDeparture($this->calculable['layout_width']),
            );
        }
        return $layout_items ?: 1;
    }

    //setters

    /**
     * @param string|int $materialId
     * @param string $material_name
     * @return Calculator
     * @throws \Exception
     */
    public function setMaterial(string|int $materialId, string $material_name = 'material'): Calculator
    {
        if ($materialId = intval($materialId)) {
            $cacheKeyMaterial = cache_key('calculator:master:material', [
                'material_id' => $materialId,
                'material_name' => $material_name,
            ]);

            $cache = Cache::tags(['calculatorMaster', 'setMaterial', 'material']);

            $material = $cache->remember(
                $cacheKeyMaterial,
                now()->addHours(6),
                fn () => Material::where('id', $materialId)->first(),
            );

            if (!empty($material)) {
                $this->calculable[$material_name] = $material->toArray();

                $cacheSpecieType = Cache::tags(['calculatorMaster', 'setMaterial', 'specie_type']);
                $cacheKeyPrintSpecie = cache_key('calculator:master:print_specie', [
                    'print_specie_id' => $this->calculable[$material_name]['print_specie_id'],
                ]);


                if (isset($this->calculable[$material_name]['print_specie_id'])) {
                    $this->calculable['print_specie'] = $cacheSpecieType->remember(
                        $cacheKeyPrintSpecie,
                        now()->addHours(6),
                        fn () => PrintSpecie::find($this->calculable[$material_name]['print_specie_id'])->toArray(),
                    );
                }
            } else {
                $this->setError('Not founded material with id ' . $materialId);
            }
        } else {
            throw new \Exception('Material "Id" is incorrect');
        }

        return $this;
    }

    /**
     * @param string $cutting
     * @return $this|Calculator
     */
    public function setCutting(string $cutting): Calculator
    {
        $this->calculable['cutting'] = $cutting;

        return $this;
    }

    /**
     * @param string $paints_face
     * @param string $paints_back
     * @return $this|Calculator
     */
    public function setPaintsQuantity(string $paints_face, string $paints_back): Calculator
    {
        $this->calculable['paints_quantity'] = intval($paints_face) + intval($paints_back);

        if (!$this->calculable['paints_quantity']) {
            $this->calculable['paints_quantity'] = 1;
        }

        return $this;
    }

    /**
     * @param int $departure
     * @return $this|Calculator
     */
    public function setDeparture(int $departure = 2): Calculator
    {
        $this->calculable['departure'] = $departure;

        return $this;
    }

    /**
     * @param string $type
     * @return $this|Calculator
     */
    public function setType(string $type): Calculator
    {
        $this->calculable['type'] = $type;

        return $this;
    }

    /**
     * @param string $grommet
     * @return $this|Calculator
     */
    public function setGrommet(string $grommet): Calculator
    {
        $this->calculable['grommet'] = $grommet;

        return $this;
    }

    /**
     * @param string $part
     * @return $this|Calculator
     */
    public function setPart(string $part): Calculator
    {
        $this->calculable['part'] = $part;

        return $this;
    }

    /**
     * @param int $quantity
     * @return $this|Calculator
     */
    public function setProductQuantity(int $quantity): Calculator
    {
        $this->calculable['product_quantity'] = $quantity;

        return $this;
    }

    /**
     * @param int $printId
     * @param bool $duplex
     * @param string $print_name
     * @param bool $checkSizes
     * @param bool $useExtraMaxSize
     * @param bool $isDuplexPrint
     * @param bool $isNotUseDeparture
     * @param int $checkSpecieTypeId
     * @return Calculator
     * @throws BindingResolutionException
     */
    public function setPrint(
        int $printId,
        bool $duplex = false,
        string $print_name = 'print',
        bool $checkSizes = false,
        bool $useExtraMaxSize = false,
        bool $isDuplexPrint = false,
        bool $isNotUseDeparture = false,
        int $checkSpecieTypeId = 0,
    ): Calculator {
        $cacheKey = cache_key('calculator:master:print', [
            'print_id' => $printId,
            'duplex' => $duplex,
            'print_name' => $print_name,
        ]);

        $print = Cache::tags(['calculatorMaster', 'setPrint', 'specie_type'])->remember(
            $cacheKey,
            now()->addHours(6),
            fn () => SpecieType::where('id', $printId)
                ->with('prices')
                ->with('paints')
                ->first(),
        );

        if (!empty($print)) {
            if ($checkSizes) {
                $checkPrint = clone $print;

                if (!isset($this->calculable['departure'])) {
                    $this->setDeparture();
                }

                if ($checkSpecieTypeId) {
                    $cacheKey = cache_key('calculator:master:print', [
                        'print_check_id' => $checkSpecieTypeId,
                        'duplex' => $duplex,
                        'print_name' => $print_name,
                    ]);

                    $checkPrint = Cache::tags(['calculatorMaster', 'setPrint', 'specie_type'])->remember(
                        $cacheKey,
                        now()->addHours(6),
                        fn () => SpecieType::where('id', $checkSpecieTypeId)
                            ->with('prices')
                            ->with('paints')
                            ->first(),
                    );
                }

                $restrictionSizeChecker = app()->make(RestrictionSizeChecker::class, [
                    'calculator' => $this->calculator,
                    'print' => $checkPrint,
                    'departure' => $this->calculable['departure'],
                    'isDuplexSize' => $isDuplexPrint,
                    'isNotUseDeparture' => $isNotUseDeparture,
                ]);

                if (
                    !$restrictionSizeChecker->check(
                        width: $this->getSize('width'),
                        height: $this->getSize('height'),
                        useExtraMaxSize: $useExtraMaxSize,
                        isNotPrintRotation: $this->calculator->parameters['is_no_rotate_print_paper'] ?? false,
                    )
                ) {
                    $restrictionSizeChecker->throwException();
                }
            }

            $this->calculable[$print_name] = $print->toArray();
            usort($this->calculable['print']['prices'], static function ($a, $b) {
                return $a['quantity'] - $b['quantity'];
            });
            //sets duplex variable
            if ($duplex) {
                $this->calculable[$print_name]['duplex_coefficient'] = $print['duplex'];
                $this->calculable[$print_name]['is_duplex'] = 1;
            }
        } else {
            $this->setError('Not founded print with id ' . $printId);
        }
        return $this;
    }

    private function getSize(string $key): int
    {
        $sizeKeyPrefix = isset($this->calculable['layout_height']) ? 'layout_' : '';

        return $this->calculable["{$sizeKeyPrefix}{$key}"] ?? 0;
    }

    /**
     * @param int $addJobId
     * @param int $times
     * @param float $coefficient
     * @return Calculator
     */
    public function setAddJob(int $addJobId, int $times = 1, float $coefficient = 1): Calculator
    {
        try {
            $this->setWorkAdditional($addJobId, $times, $coefficient);
        } catch (WorkAdditionalException $exception) {
            $this->setError($exception->getMessage());
        }

        return $this;
    }

    public function setItemPrice(): void
    {
        $this->calculable['item_price'] = $this->calculable['total_price'] / $this->calculable['product_count'];
        $this->calculable['count_item_price'] = ceil(round($this->calculable['item_price'] * 100, 2)) / 100;
    }

    protected function loadFormulas(): void
    {
        $cacheKey = cache_key('calculator:master:formulas:all');

        $this->formulasDict = Cache::tags(['calculatorMaster', 'loadFormulas', 'formulas'])->remember(
            $cacheKey,
            now()->addDays(7),
            fn () => Formulas::all()->pluck('alias', 'id'),
        );
    }

    /**
     * @param int $count
     * @return $this|Calculator
     */
    public function setProductCount(int $count): Calculator
    {
        $this->calculable['product_count'] = $count;

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @return Calculator
     */
    public function setWidthHeight(int $width, int $height): Calculator
    {
        $this->calculable['width'] = $width;
        $this->calculable['height'] = $height;

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this|Calculator
     */
    public function setLayoutSize(int $width, int $height): Calculator
    {
        $this->calculable['layout_width'] = $width;
        $this->calculable['layout_height'] = $height;

        return $this;
    }

    /**
     * @param int $diameter
     * @return $this|Calculator
     */
    public function setLayoutDiameter(int $diameter): Calculator
    {
        $this->calculable['layout_width'] = $diameter;
        $this->calculable['layout_height'] = $diameter;

        return $this;
    }

    /**
     * @param int $quantity
     * @return $this|Calculator
     */
    public function setAdditionTypesPrice(int $quantity): Calculator
    {
        $this->calculable['addition_types_price'] = 300 * ($quantity - 1);
        return $this;
    }

    //formulas

    public function prctFormula(array &$data): void
    {
        if (isset($this->calculable['grommet'])) {
            $pricesItem = $this->getJobPrice($data, $this->calculable['product_count']);
            $perimeter =
                ($this->calculable['layout_width'] / 1000 +
                    $this->calculable['layout_height'] / 1000 +
                    ($this->calculable['departure'] / 1000) * 4) *
                2;
            $grommet = round(($perimeter / intval($this->calculable['grommet'])) * 100);
            $data['count'] =
                $grommet *
                $pricesItem['price'] *
                ((1 + $pricesItem['charge'] / 100) * $this->calculable['product_count']);
        }
    }

    /**
     * @param array $data
     */
    public function fsFormula(array &$data): void
    {
        $data['count'] = reset($data['prices'])['fixed_sum'] * (1 + reset($data['prices'])['charge'] / 100);
    }

    public function prmctFormula(&$data): void
    {
        $pricesItem = $this->getJobPrice($data, $this->calculable['product_count']);
        $perimeter =
            ($this->calculable['layout_width'] / 1000 +
                $this->calculable['layout_height'] / 1000 +
                ($this->calculable['departure'] / 1000) * 4) *
            2;
        $data['count'] =
            $perimeter *
            $pricesItem['price'] *
            ((1 + $pricesItem['charge'] / 100) * $this->calculable['product_count']);
    }

    public function k1ctFormula(array &$data): void
    {
        $product_count = $this->calculable['product_count'];
        if (isset($this->calculable['product_quantity'])) {
            $product_count = $this->calculable['product_quantity'];
        }
        $pricesItem = $this->getJobPrice($data, $product_count);
        $data['count'] = $pricesItem['price'] * ((1 + $pricesItem['charge'] / 100) * $product_count);
        if ($data['weight'] != 0 && $data['volume'] != 0) {
            $data['total_weight'] = ($data['volume'] / 1000) * $this->calculable['material_count'];
            $data['total_volume'] = $this->calculable['product_quantity'] * $data['weight'];
        }
    }

    public function percentFormula(array &$data): void
    {
        $prices = reset($data['prices']);
        $data['count'] =
            $this->calculable['print_price_total'] *
            ($prices['percent'] / 100 + ($prices['percent'] / 100 / 100) * $prices['charge']);
    }

    /**
     * @param array $data
     */
    public function lcFormula(array &$data): void
    {
        if (isset($this->calculable['linear_meters'])) {
            $priceItem = $this->getSquareMetersPrices($data, 'list_meters', 'linear_meters');
            $data['count'] =
                $this->calculable['linear_meters'] * $priceItem['price'] * (1 + $priceItem['charge'] / 100);
        } elseif (isset($this->calculable['material_count'])) {
            $priceItem = $this->getSquareMetersPrices($data);
            $data['count'] =
                $this->calculable['material_count'] * $priceItem['price'] * (1 + $priceItem['charge'] / 100);
        } else {
            $this->setError('Items On Page variable required! Probably missed layout sizes.');
        }
        if ($data['weight'] != 0 && $data['volume'] != 0) {
            $data['total_weight'] = ($data['volume'] / 1000) * $this->calculable['material_count'];
            $data['total_volume'] = $this->countVolume($data['volume']);
        }
    }

    protected function getSquareMetersPrices($data, $name_sort = 'list_meters', $compare = 'material_count'): array
    {
        if (count($data['prices']) == 1) {
            return reset($data['prices']);
        } elseif (count($data['prices']) > 1) {
            usort($data['prices'], function ($a, $b) use ($name_sort) {
                return $a[$name_sort] - $b[$name_sort];
            });
            $numItems = count($data['prices']);
            $i = 0;
            $priceItem = [];
            foreach ($data['prices'] as $key => $item) {
                if ($i == 0 && $this->calculable[$compare] <= intval($item[$name_sort])) {
                    $priceItem = $data['prices'][$key];
                    break;
                } elseif ($this->calculable[$compare] == intval($item[$name_sort])) {
                    $priceItem = $data['prices'][$key];
                    break;
                } elseif ($this->calculable[$compare] < intval($item[$name_sort])) {
                    $priceItem = $data['prices'][$key - 1];
                    break;
                } elseif ($i === $numItems - 1) {
                    $priceItem = $item;
                    break;
                }
                $i++;
            }
            return $priceItem;
        } else {
            return [];
        }
    }

    public function plmctFormula(array &$data): void
    {
        $pricesItem = $this->getSquareMetersPrices($data);
        $data['count'] = $this->calculable['print_count'] * $pricesItem['price'] * (1 + $pricesItem['charge'] / 100);
        if ($data['weight'] != 0 && $data['volume'] != 0) {
            $data['total_weight'] = ($data['volume'] / 1000) * $this->calculable['material_count'];
            $data['total_volume'] = $this->countVolume($data['volume']);
        }
    }

    public function sccFormula(&$data): void
    {
        $data['count'] =
            $this->calculable['paints_quantity'] *
            $data['prices'][0]['fixed_sum'] *
            (1 + $data['prices'][0]['charge'] / 100);
    }

    public function getA(): string
    {
        return 'B';
    }
}
