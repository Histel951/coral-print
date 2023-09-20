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
        // todo: определиться с точной структурой, пока ток известно что будет поле name
        Schema::create('print_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('calculator_type_id')->nullable();
            $table->boolean('is_diameter')->default(false);
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
        Schema::dropIfExists('print_forms');
    }
};
