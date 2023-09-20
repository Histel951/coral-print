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
        if (!Schema::hasTable('materials')) {
            Schema::create('materials', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('code')->nullable();
                $table->string('category')->nullable();
                $table->integer('sequence')->default(0);
                $table->text('desc')->nullable();
                $table->text('width')->nullable();
                $table->text('weight')->nullable();
                $table->string('alias')->nullable();
                $table->integer('material_categories_id');
                $table->bigInteger('print_specie_id')->nullable();
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
        Schema::dropIfExists('materials');
    }
};
