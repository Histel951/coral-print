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
        Schema::create('cutting_print_work_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cutting_id');
            $table->foreignId('calculator_id');
            $table->foreignId('print_type_id');
            $table->foreignId('work_additional_id');
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
        Schema::dropIfExists('cutting_print_work_additionals');
    }
};
