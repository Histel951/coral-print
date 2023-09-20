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
        if (!Schema::hasTable('offset_size')) {
            Schema::create('offset_size', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('offset_id')->unsigned();
                $table->foreign('offset_id')->references('id')->on('offset')->onDelete('cascade');
                $table->string('name');
                $table->string('image');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('offset_material')) {
            Schema::create('offset_material', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('offset_size_id')->unsigned();
                $table->foreign('offset_size_id')->references('id')->on('offset_size')->onDelete('cascade');
                $table->string('name');
                $table->string('weight');
                $table->string('volume');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('offset_price')) {
            Schema::create('offset_price', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('offset_material_id')->unsigned();
                $table->foreign('offset_material_id')->references('id')->on('offset_material')->onDelete('cascade');
                $table->integer('quantity');
                $table->float('price', 8, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offset_size');
        Schema::dropIfExists('offset_material');
        Schema::dropIfExists('offset_price');
    }
};
