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
        Schema::create('pivot_work_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_additional_id');
            $table->foreignId('lamination_id')->nullable();
            $table->foreignId('print_type_id')->nullable();
            $table->foreignId('cutting_id')->nullable();
            $table->foreignId('hole_id')->nullable();
            $table->foreignId('foiling_id')->nullable();
            $table->foreignId('calculator_id')->nullable();
            $table->foreignId('print_form_id')->nullable();
            $table->boolean('is_complex_form')->nullable();
            $table->boolean('is_mounting_film')->nullable();
            $table->boolean('is_small_objects')->nullable();
            $table->boolean('is_white_print')->nullable();
            $table->boolean('is_volume')->nullable();
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
        Schema::dropIfExists('pivot_work_additionals');
    }
};
