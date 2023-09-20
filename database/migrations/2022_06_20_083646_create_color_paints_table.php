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
        Schema::create('color_paints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('consumption', 8, 3);
            $table->double('price', 8, 2);
            $table->unsignedInteger('price_percent');
            $table->unsignedBigInteger('image_id')->nullable();
//            $table->foreignId('color_id');
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
        Schema::dropIfExists('color_paints');
    }
};
