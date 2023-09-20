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
        Schema::create('calculators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->double('min_price', 8, 2, true)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('is_diameter')->default(false);
            $table->foreignId('calculator_type_id')->nullable();
            $table->timestamps();

            $table->foreign('image_id')->references('id')->on('attachments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculators');
    }
};
