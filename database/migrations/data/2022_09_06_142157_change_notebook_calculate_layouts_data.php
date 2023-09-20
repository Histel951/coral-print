<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculator = Calculator::find(3859);

        $calculator->update([
            'parameters' => Arr::collapse([
                $calculator->parameters,
                [
                    'is_two_side_print' => true
                ]
            ])
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
