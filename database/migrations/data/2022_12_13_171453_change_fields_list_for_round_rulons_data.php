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
        $calculator = Calculator::query()->where('name', 'Круглые этикетки в рулоне')->first();

        $calculator->fields()->where('type', 'fields')->first()->update([
            'value' => ["width_height_flex", "product_count_types", "material_select", "color_paints", "location"]
        ]);

        $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'width' => 112,
                    'label' => 'Диаметр'
                ]
            ]
        ]);

        $calculatorComplex = Calculator::query()->where('name', 'Фигурные этикетки в рулоне')->first();

        $calculatorComplex->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'label' => 'Вид и размер'
                ]
            ]
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
