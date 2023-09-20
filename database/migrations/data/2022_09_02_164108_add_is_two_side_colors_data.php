<?php

use App\Models\Calculator;
use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $twoSideColors = [11, 12];

        foreach ($twoSideColors as $colorId) {
            Color::query()->find($colorId)->update([
                'is_two_side' => true
            ]);
        }

//        $twoSideCalculators = Calculator::query()->whereIn('id', [3855, 3859, 3860])->get();
//
//        $twoSideCalculators->map(function(Calculator $calculator): void
//        {
//            $parameters = $calculator->parameters;
//            $parameters['is_two_side_print'] = true;
//
//            $calculator->update([
//                'parameters' => $parameters
//            ]);
//        });
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
