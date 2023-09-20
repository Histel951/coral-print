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
        if (!Schema::hasTable('job_prices')) {
            Schema::create('job_prices', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('list_meters')->nullable();
                $table->integer('circulation')->nullable();
                $table->float('price')->nullable();
                $table->float('fixed_sum')->nullable();
                $table->integer('percent')->nullable();
                $table->integer('charge')->nullable();
                $table->integer('job_type_id')->nullable();
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
        Schema::dropIfExists('job_prices');
    }
};
