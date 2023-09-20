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
        Schema::create('material_sub_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('cost_price')->nullable();
            $table->unsignedInteger('extra_change')->nullable();
            $table->double('price')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->foreignId('material_id');
            $table->string('color')->nullable();
            $table->boolean('hex')->default(true);
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
        Schema::dropIfExists('material_sub_types');
    }
};
