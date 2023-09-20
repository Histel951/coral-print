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
        Schema::create('print_species', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('volume', 8, 3);
            $table->unsignedInteger('sequence')->default(1);
            $table->unsignedInteger('max_size')->default(100);
            $table->foreignId('print_type_id')->nullable();
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
        Schema::dropIfExists('print_species');
    }
};
