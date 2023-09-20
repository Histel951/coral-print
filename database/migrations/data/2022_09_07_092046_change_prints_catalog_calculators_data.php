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
        $notTwoSideColors = [23, 25, 27, 29];

        foreach ($notTwoSideColors as $colorId) {
            Color::query()->find($colorId)->update([
                'is_two_side' => true
            ]);
        }

        Calculator::query()->find(3858)->update([
            'parameters' => []
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
