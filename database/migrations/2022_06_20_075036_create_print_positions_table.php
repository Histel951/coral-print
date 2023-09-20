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
        Schema::create('print_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // todo понять как обозвать, если имеет значение "Прямая" и "Обратная", возможно bool поле
            $table->string('type_name');
            $table->unsignedBigInteger('image')->nullable(); // картинка
            $table->timestamps();

            $table->foreign('image')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('print_positions');
    }
};
