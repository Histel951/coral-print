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
        Schema::table('calculator_restrictions', function (Blueprint $table): void {
            $table->unsignedInteger('extra_max_size')->nullable();
            $table->unsignedInteger('extra_min_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropColumns('calculator_restrictions', ['extra_max_size', 'extra_min_size']);
    }
};
