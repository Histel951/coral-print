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
        Schema::create('work_additional_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('list_meters')->nullable();
            $table->unsignedInteger('circulation')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->double('fixed_sum', 8, 2)->nullable();
            $table->integer('percent')->nullable();
            $table->unsignedInteger('charge')->nullable();
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
        Schema::dropIfExists('work_additional_prices');
    }
};
