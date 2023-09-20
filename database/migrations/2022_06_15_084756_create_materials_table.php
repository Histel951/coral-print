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
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type_name')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedInteger('price_percent')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('cost_price', 8, 2)->nullable();
            $table->decimal('extra_change', 8, 2)->nullable();
            $table->unsignedInteger('max_size')->nullable();
            $table->string('article')->nullable();
            $table->unsignedInteger('min_meters')->nullable();
            $table->foreignId('print_specie_id')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->float('width')->default(0.00);
            $table->float('weight')->default(0.00);
            $table->boolean('is_hex')->default(true);
            $table->string('code')->nullable();
            $table->foreignId('material_type_id')->nullable();
            $table->foreignId('material_category_id')->nullable();
            $table->unsignedInteger('volume')->nullable();
            $table->boolean('is_show')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
