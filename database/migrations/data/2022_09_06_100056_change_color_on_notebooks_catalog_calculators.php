<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\Color;
use App\Models\PivotCalculatorColor;
use App\Models\PivotCalculatorPrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $twoSideCalculatorColors = PivotCalculatorColor::query()
            ->where('calculator_sub_id', 2)
            ->whereIn('calculator_id', [3855, 3860, 3859, 3858, 3866]);

        $twoSideCalculatorColors->get()->map(function (PivotCalculatorColor $pivotCalculatorColor) {
            $color = Color::find($pivotCalculatorColor->color_id);

            $newColor = Color::create([
                'print_id' => $color->print_id,
                'name' => $color->name,
                'is_two_side' => false
            ]);

            PivotCalculatorColor::create([
                'calculator_sub_id' => 2,
                'calculator_id' => $pivotCalculatorColor->calculator_id,
                'color_id' => $newColor->getKey()
            ]);

            PivotCalculatorColor::find($pivotCalculatorColor->id)->delete();
        });

        $fields = CalculatorFieldsConfig::query()->find(11)->value;
        $fields[1] = 'page_count';

        CalculatorFieldsConfig::query()->find(11)->update([
            'type' => 'fields',
            'value' => $fields
        ]);

        PivotCalculatorPrintSize::query()
            ->where('calculator_id', 3866)
            ->where('print_size_id', 65)
            ->delete();


        Calculator::query()->find(3866)->update([
            'parameters' => [
                'is_wide' => true,
                'is_adhesive' => true,
                'is_two_side_print' => true
            ]
        ]);

        Calculator::query()->find(3858)->update([
            'parameters' => [
                'is_two_side_print' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
