<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('previews')->where('cutting_id', 2)->where('form_id', 54)
                ->update(['is_volume' => 1]);

        \App\Models\CalculatorRouteProps::query()->create([
            'name' => 'deps',
            'calculator_id' => 3817,
            'calculator_type_route_id' => 3,
            'value' => ['cutting']
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
