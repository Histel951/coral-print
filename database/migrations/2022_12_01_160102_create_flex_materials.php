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
        Schema::create('flex_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type');
            $table->string('name');
            $table->string('article');
            $table->unsignedInteger('min_meters')->nullable();
            $table->unsignedInteger('weight')->default(0);
            $table->decimal('price', 8, 4);
            $table->unsignedInteger('price_percent')->default(0);
            $table->boolean('show')->default(false);
            $table->unsignedInteger('sequence');
            $table->unsignedInteger('volume')->default(0);
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
        Schema::dropIfExists('flex_materials');
    }
};
