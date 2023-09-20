<?php

use App\Models\CalculatorType;
use App\Models\CalculatorTypePreviewOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('calculator_type_preview_options', function (Blueprint $table) {
            if (Schema::hasColumn('calculator_type_preview_options', 'parameters_type')) {
                $catalogCalculator = CalculatorType::query()->where('name', 'catalogs')->first();
                $parametersType = $catalogCalculator->preview_options->parameters_type;

                $table->string('parameters_type')->default('default')->change();

                $catalogOption = CalculatorTypePreviewOption::query()->create([
                    'parameters_type' => $parametersType
                ]);

                $catalogCalculator->update([
                    'parameters_type' => $catalogOption
                ]);
            }
        });
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
