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
        Schema::create('pivot_calculator_specie_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculator_id');
            $table->foreignId('specie_type_id');
            $table->foreignId('print_id')->nullable();
            $table->boolean('is_duplex')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_calculator_specie_types');
    }
};
