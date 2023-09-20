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
    public function up(): void
    {
        Schema::create('calculator_model_text_data_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_text_data_message_id')->nullable();
            $table->foreignId('calculator_id')->nullable();
            $table->string('model_field')->default('');
            $table->boolean('is_int')->default(false);
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
        Schema::dropIfExists('calculator_model_text_data_message');
    }
};
