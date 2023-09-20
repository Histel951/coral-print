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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('size_types_id')->nullable();
            $table->text('description');
            $table->unsignedInteger('volume');
            $table->unsignedInteger('weight');
            $table->unsignedBigInteger('image')->nullable();
            $table->unsignedInteger('coefficient');
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
        Schema::dropIfExists('sizes');
    }
};
