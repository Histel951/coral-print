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
        Schema::create('rapport_knifes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapport_id');
            $table->unsignedInteger('knife_number')->nullable();
            $table->foreignId('print_form_id');
            $table->double('width', 8, 2);
            $table->double('height', 8, 2);
            $table->unsignedInteger('count_rapport');
            $table->unsignedInteger('count_rows');
            $table->double('radius', 8, 3)->nullable();
            $table->unsignedInteger('row_space')->nullable();
            $table->double('line_space', 8, 2);
            $table->unsignedInteger('print_height');
            $table->unsignedInteger('price');
            $table->unsignedInteger('price_percent');
            $table->string('marking');
            $table->boolean('isset_knife')->default(false);
            $table->foreignId('image_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('dummy')->default(false);
            $table->string('knife_number_summary');
            $table->unsignedBigInteger('image_small')->nullable(); // внешний ключ для маленьких картинок
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
        Schema::dropIfExists('rapport_knifes');
    }
};
