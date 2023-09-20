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
        Schema::create('bends', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('value');
            $table->timestamps();
        });

        Schema::create('pivot_calculator_bends', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('calculator_id')->nullable();
            $table->foreignId('bend_id')->nullable();
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
        Schema::dropIfExists('bends');
        Schema::dropIfExists('pivot_calculator_bends');
    }
};
