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
        Schema::create('block_select_field_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_select_field_config_type_id');
            $table->boolean('active')->default(false);
            $table->foreignId('calculator_sub_id')->nullable();
            $table->foreignId('calculator_id')->nullable();
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
        Schema::dropIfExists('block_select_field_configs');
    }
};
