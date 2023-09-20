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
        Schema::create('print_restrictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('height')->default(0);
            $table->unsignedInteger('width')->default(0);
            $table->unsignedInteger('min_height')->default(0);
            $table->unsignedInteger('min_width')->default(0);
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
        Schema::dropIfExists('print_restrictions');
    }
};
