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
        Schema::table('pivot_calculator_specie_types', function (Blueprint $table): void {
            $table->boolean('is_white_print')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pivot_calculator_specie_types', function (Blueprint $table): void {
            $table->dropColumn('is_white_print');
        });
    }
};
