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
        Schema::create('calculator_config_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_additional')->default(false);
            $table->enum('type', ['fields', 'checkboxes']);
            $table->json('condition')->nullable();
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
        Schema::dropIfExists('calculator_config_conditions');
    }
};
