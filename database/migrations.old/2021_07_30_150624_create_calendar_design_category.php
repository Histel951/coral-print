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
        if (!Schema::hasTable('calendar_design_category')) {
            Schema::create('calendar_design_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('calendar_design_subcategory')) {
            Schema::create('calendar_design_subcategory', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('calendar_design_category_id');
                $table->foreign('calendar_design_category_id', 'category_id')->references('id')->on('calendar_design_category');
                $table->string('name');
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
        Schema::dropIfExists('calendar_design_category');
        Schema::dropIfExists('calendar_design_subcategory');
    }
};
