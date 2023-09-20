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
        if (!Schema::hasTable('print_pockets')) {
            Schema::create('print_pockets', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('print_specie_id');
                $table->integer('quantity');
                $table->integer('overprice');
                $table->string('price_1');
                $table->string('price_2');
                $table->string('price_3');
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
        Schema::dropIfExists('print_pockets');
    }
};
