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
        Schema::create('material_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type_name');
            $table->unsignedInteger('sort')->default(100);
//            $table->unsignedBigInteger('price_id'); todo узнать нужно ли это в принципе
            $table->string('color')->nullable();
            $table->unsignedBigInteger('image')->nullable();
            $table->foreignId('calculator_id')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();

//            $table->foreign('price_id')->on('material_type_prices')->references('id');
            $table->foreign('image')->on('files')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_types');
    }
};
