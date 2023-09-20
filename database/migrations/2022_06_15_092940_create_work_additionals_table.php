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
        Schema::create('work_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formula_id');
            $table->string('name');
            $table->string('type_name')->nullable();
            $table->string('color', 11)->nullable();
            $table->string('code')->nullable();
            $table->double('weight', 20, 10)->default(0);
            $table->double('volume', 20, 10)->default(0);
            $table->unsignedInteger('times')->default(1);
            $table->foreignId('work_additional_type_id')->nullable();
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
        Schema::dropIfExists('work_additionals');
    }
};
