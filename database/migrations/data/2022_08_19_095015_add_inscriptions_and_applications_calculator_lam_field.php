<?php

use App\Models\CalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        CalculatorFieldsConfig::query()->find(8)->update([
            'value' => ["print_type", "width_height", "product_count_types", "lam", "material", "cutting"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        CalculatorFieldsConfig::query()->find(8)->update([
            'value' => ["print_type", "width_height", "product_count_types", "material", "cutting"]
        ]);
    }
};
