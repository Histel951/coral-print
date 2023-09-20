<?php

use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private array $values = [
        3820 => [145, 146, 147, 148, 149, 150, 151]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        foreach ($this->values as $calculatorId => $materials) {
            foreach ($materials as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'is_white_print' => true,
                    'print_id' => 14
                ]);
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->values as $calculatorId => $materials) {
            foreach ($materials as $materialId) {
                PivotCalculatorMaterial::query()->where([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'is_white_print' => true,
                    'print_id' => 14
                ])->delete();
            }
        }
    }
};
