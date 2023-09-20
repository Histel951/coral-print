<?php

use App\Models\CalculatorRouteProps;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorRouteProps = [
            [
                'name' => 'deps',
                'value' => ["cutting", "form", "volume"],
                'calculator_type_route_id' => 3,
                'calculator_id' => 3815
            ],
            [
                'name' => 'deps',
                'value' => ["cutting", "form", "volume"],
                'calculator_type_route_id' => 3,
                'calculator_id' => 3816
            ],
            [
                'name' => 'deps',
                'value' => ["cutting", "form", "volume"],
                'calculator_type_route_id' => 3,
                'calculator_id' => 3827
            ],
            [
                'name' => 'deps',
                'value' => ["cutting", "form", "volume"],
                'calculator_type_route_id' => 3,
                'calculator_id' => 3829
            ],
        ];

        foreach ($calculatorRouteProps as $prop) {
            CalculatorRouteProps::query()->create($prop);
        }
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
