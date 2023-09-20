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
        if (!Schema::hasTable('calc_fields')) {
            Schema::create('calc_fields', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('alias')->nullable();
                $table->integer('calc_category_id');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('calc_fields_list')) {
            Schema::create('calc_fields_list', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('alias');
                $table->string('image');
                $table->string('adds');
                $table->bigInteger('calc_fields_id')->unsigned();
                $table->integer('calc_category_id');
                $table->foreign('calc_fields_id')->references('id')->on('calc_fields')->onDelete('cascade');
                $table->string('name');
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
        Schema::dropIfExists('calc_fields');
        Schema::dropIfExists('calc_fields_list');
    }
};
