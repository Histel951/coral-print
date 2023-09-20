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
        if (!Schema::hasTable('species_types')) {
            Schema::create('species_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('alias')->nullable();
                $table->bigInteger('print_specie_id')->nullable();
                $table->string('index_name')->nullable();
                $table->integer('height')->nullable();
                $table->integer('value_id')->nullable();
                $table->integer('width')->nullable();
                $table->smallInteger('type')->nullable();
                $table->string('duplex')->nullable();
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
        Schema::dropIfExists('species_types');
    }
};
