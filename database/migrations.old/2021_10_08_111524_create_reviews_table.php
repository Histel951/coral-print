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
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('rate');
                $table->string('title');
                $table->string('comment');
                $table->string('email');
                ;
                $table->unique('email');
                ;
                $table->string('name');
                $table->integer('product_category');
                $table->integer('status')->comment('1-Новый, 2-Опубликованный, 3-Отмененный');
                $table->unsignedBigInteger('file_id')->nullable();
                $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
