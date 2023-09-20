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
        if (!Schema::hasTable('print_species')) {
            Schema::create('print_species', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('volume')->default(0);
                $table->string('alias')->nullable();
                $table->bigInteger('print_scheme_id')->nullable();
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
        Schema::dropIfExists('print_species');
    }
};
