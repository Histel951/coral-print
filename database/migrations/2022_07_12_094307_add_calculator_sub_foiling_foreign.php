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
        Schema::table('pivot_calculator_foilings', function (Blueprint $table) {
            $table->foreignId('calculator_sub_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pivot_calculator_foilings', function (Blueprint $table) {
            $table->dropColumn('calculator_sub_id');
        });
    }
};
