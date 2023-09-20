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
        Calculator::query()->find(3822)->update([
            'width_without_print' => 1100
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Calculator::query()->find(3822)->update([
            'width_without_print' => 1200
        ]);
    }
};
