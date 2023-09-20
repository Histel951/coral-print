<?php

use App\Models\CalculatorType;
use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private array $calcIds;

    public function __construct()
    {
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->calcIds = CalculatorType::where('name', 'labels')->get()->first()->calculators->pluck('id')->toArray();

        $works = [
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [112, 113, 114, 115, 116, 117],
                'work_additional_id' => [32],
            ],
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [112, 113, 114, 115],
                'work_additional_id' => [28],
            ],
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [116, 117],
                'work_additional_id' => [37],
            ],
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [119, 120],
                'work_additional_id' => [29, 31],
            ],
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [113, 115],
                'work_additional_id' => [28],
            ],
            [
                'calculator_id' => $this->calcIds,
                'lamination_id' => [117],
                'work_additional_id' => [37],
            ],
        ];


        foreach ($works as $work) {
            $collection = collect($work);
            $values = $collection->values()->map(fn ($v) => collect($v));
            $rows = $values->shift()->crossJoin(...$values)->map(fn ($v) => array_combine($collection->keys()->toArray(), $v))->toArray();

            PivotWorkAdditional::query()->insert($rows);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->calcIds = CalculatorType::where('name', 'labels')->get()->first()->calculators->pluck('id')->toArray();
        $models = PivotWorkAdditional::whereIn('calculator_id', $this->calcIds)->whereNotNull('lamination_id')->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
};
