<?php

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
        Schema::table('calculators', function (Blueprint $table) {
            $table->unsignedBigInteger('calculated_calculator_type_id')->nullable();
            $table->foreign('calculated_calculator_type_id')->references('id')
                ->on('calculator_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('calculators', function (Blueprint $table) {
//            $table->dropForeign(['calculated_calculator_category_id']);
        });
    }
};
