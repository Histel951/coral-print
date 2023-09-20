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
        if (!Schema::hasTable('calendar')) {
            Schema::create('calendar', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('calendar_size')) {
            Schema::create('calendar_size', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calendar_id');
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('calendar_size_type')) {
            Schema::create('calendar_size_type', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calendar_size_id');
                $table->string('name');
                $table->string('image')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('calendar_type_lam')) {
            Schema::create('calendar_type_lam', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calendar_size_type_id');
                $table->string('name');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('calendar_lam_price')) {
            Schema::create('calendar_lam_price', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calendar_type_lam_id');
                $table->integer('quantity');
                $table->integer('price')->default(0);
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
        Schema::dropIfExists('calendar');
        Schema::dropIfExists('calendar_size');
        Schema::dropIfExists('calendar_size_type');
        Schema::dropIfExists('calendar_type_lam');
        Schema::dropIfExists('calendar_lam_price');
    }
};
