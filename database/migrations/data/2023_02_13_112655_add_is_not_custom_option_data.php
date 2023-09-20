<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculator = Calculator::query()->where('name', 'На прозрачной плёнке с белым')->first();

        $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'color_paints' => [
                    'isNotCustom' => true
                ]
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
