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
        if (!Schema::hasTable('job_types')) {
            Schema::create('job_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('alias')->nullable();
                $table->string('code')->default('309aee');
                $table->bigInteger('job_id')->nullable();
                $table->bigInteger('formula_id')->nullable();
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
        Schema::dropIfExists('job_types');
    }
};
