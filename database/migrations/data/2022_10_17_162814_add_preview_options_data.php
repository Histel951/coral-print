<?php

use App\Models\CalculatorType;
use App\Models\CalculatorTypePreviewOption;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorCatalogType = CalculatorType::query()->where('name', 'catalogs')->first();

        $newPreviewOption = CalculatorTypePreviewOption::query()->create([
            'parameters_type' => 'changeable'
        ]);

        $calculatorCatalogType->update([
            'calculator_type_preview_option_id' => $newPreviewOption->getKey()
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
