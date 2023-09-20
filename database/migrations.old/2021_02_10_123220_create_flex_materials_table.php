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
        if (!Schema::hasTable('flex_materials')) {
            Schema::create('flex_materials', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('weight');
                $table->string('price');
                $table->string('price_percent');
                $table->string('type')->nullable()->index()->comment('1-пленка, 2-бумага, 3-термо, 4-специальные');
                ;
                $table->string('article')->nullable();
                $table->string('min_meters')->nullable();
                $table->boolean('show')->default(false);
                $table->integer('order')->default(0);
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
        Schema::dropIfExists('flex_materials');
    }
};
