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
        Schema::create('specie_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type_name');
            $table->boolean('is_white_print')->default(false);
            $table->string('index_name')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('type')->nullable();
            $table->unsignedInteger('duplex')->nullable();
            $table->unsignedBigInteger('value_id')->nullable();
            $table->foreignId('print_specie_id')->nullable();
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
        Schema::dropIfExists('specie_types');
    }
};
