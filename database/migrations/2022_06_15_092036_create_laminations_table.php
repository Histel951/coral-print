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
        Schema::create('laminations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('size_id')->nullable();
            $table->foreignId('lamination_type_id')->nullable();
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
        Schema::dropIfExists('laminations');
    }
};
