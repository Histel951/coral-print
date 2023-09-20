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
        if (!Schema::hasTable('species_types_prices')) {
            Schema::create('species_types_prices', function (Blueprint $table) {
                $table->id();
                $table->integer('quantity')->nullable();
                $table->float('price')->nullable();
                $table->integer('overprice')->nullable();
                $table->bigInteger('species_types_id')->nullable();
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
        Schema::dropIfExists('species_types_prices');
    }
};
