<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public array $sequenceCalculators = [
        3815 => 1,
        3816 => 2,
        3827 => 3,
        3817 => 4,
        3818 => 5,
        3819 => 6,
        3821 => 7,
        3820 => 8,
        3824 => 9,
        3823 => 10,
        3822 => 11,
        3829 => 12,
        3830 => 13,
        3826 => 14
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->sequenceCalculators as $calculatorId => $sequence) {
            Calculator::find($calculatorId)->update([
                'sequence' => $sequence
            ]);

            DB::insert("insert into pivot_calculator_specie_types (calculator_id, specie_type_id, is_white_print) value (3829, 21, true);");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->sequenceCalculators as $calculatorId) {
            $model = Calculator::find($calculatorId);
            $model && $model->update([
                'sequence' => 1
            ]);
        }
    }
};
