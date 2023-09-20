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
        if (!Schema::hasTable('calendar_design')) {
            Schema::create('calendar_design', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calendar_design_subcategory_id');
                $table->bigInteger('calendar_size_id')->unsigned();
                $table->foreign('calendar_size_id')->references('id')->on('calendar_size')->onDelete('cascade');
                $table->string('name');
                $table->string('image');
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
        Schema::dropIfExists('calendar_design');
    }
};
