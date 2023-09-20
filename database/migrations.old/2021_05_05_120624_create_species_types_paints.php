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
        if (!Schema::hasTable('species_types_paints')) {
            Schema::create('species_types_paints', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('quantity')->default(0);
                $table->float('paint1')->default(0);
                $table->float('paint2')->default(0);
                $table->float('paint3')->default(0);
                $table->float('paint4')->default(0);
                $table->float('paint5')->default(0);
                $table->float('paint6')->default(0);
                $table->float('paint7')->default(0);
                $table->float('paint8')->default(0);
                $table->integer('overprice')->default(0);
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
        Schema::dropIfExists('species_types_paints');
    }
};
