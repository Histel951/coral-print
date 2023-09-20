<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        $calculatorIds = [3867, 3868, 3869, 3870, 3871, 3872, 3873];

        $materialIds = [99, 48, 49, 77, 140, 50, 51, 52, 141];

        DB::beginTransaction();

        try {
            foreach ($calculatorIds as $calculatorId) {
                foreach ($materialIds as $materialId) {
                    $isExist = boolval(
                        DB::table('pivot_calculator_materials')
                            ->select('id')
                            ->where('calculator_id', '=', $calculatorId)
                            ->where('material_id', '=', $materialId)
                            ->count('id')
                    );

                    if (!$isExist) {
                        DB::table('pivot_calculator_materials')
                            ->insert([
                                'calculator_id' => $calculatorId,
                                'material_id' => $materialId,
                            ]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
};
