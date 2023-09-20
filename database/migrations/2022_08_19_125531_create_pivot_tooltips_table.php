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
        Schema::create('pivot_tooltips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tooltip_id')->nullable();
            $table->unsignedBigInteger('calculator_type_id')->nullable();
            $table->unsignedBigInteger('field_id')->nullable();
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
        Schema::dropIfExists('pivot_tooltips');
    }
};
