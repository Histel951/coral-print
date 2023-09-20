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
        Schema::create('form_fields_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_field_id');
            $table->foreignId('calculator_type_id');
            $table->unsignedBigInteger('sequence')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields_sequences');
    }
};
