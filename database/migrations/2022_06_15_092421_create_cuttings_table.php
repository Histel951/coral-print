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
        Schema::create('cuttings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('cutting_type_id')->nullable();
            $table->boolean('is_volume')->default(false);
            $table->foreignId('calculator_id')->nullable();
            $table->foreignId('calculator_type_id')->nullable();
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
        Schema::dropIfExists('cuttings');
    }
};
