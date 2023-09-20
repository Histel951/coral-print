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
        if (!Schema::hasTable('rapport_knives')) {
            Schema::create('rapport_knives', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('rapport_id')->index();
                $table->string('knife_number');
                $table->string('form')->index()->comment('1-прямоугольник, 2-круг, 3-овал, 4-сложная форма');
                $table->string('width')->index();
                $table->string('height')->index();
                $table->string('count_rapport')->index();
                $table->string('count_rows');
                $table->string('radius');
                $table->string('line_space');
                $table->string('row_space')->nullable();
                $table->string('print_height')->index();
                $table->string('price')->index();
                $table->string('price_percent')->index();
                $table->string('marking')->nullable();
                $table->boolean('isset_knife')->default(false);
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
        Schema::dropIfExists('rapport_knives');
    }
};
