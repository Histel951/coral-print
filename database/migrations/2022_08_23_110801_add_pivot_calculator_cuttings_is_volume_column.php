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
        Schema::table('pivot_calculator_cuttings', function (Blueprint $table) {
            $table->boolean('is_volume')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pivot_calculator_cuttings', function (Blueprint $table) {
            $table->dropColumn('is_volume');
        });
    }
};
