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
        Schema::create('preview_print_size_pixels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preview_id')->nullable();
            $table->foreignId('print_size_id')->nullable();
            $table->float('pixels_w', unsigned: true)->default(0);
            $table->float('pixels_h', unsigned: true)->default(0);
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
        Schema::dropIfExists('preview_print_size_pixels');
    }
};
