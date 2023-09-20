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
        Schema::create('size_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('calculator_id');
            $table->unsignedBigInteger('specie_types_id');
            $table->timestamps();

            $table->foreign('calculator_id')->references('id')->on('calculators');
            $table->foreign('specie_types_id')->references('id')->on('specie_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_types');
    }
};
