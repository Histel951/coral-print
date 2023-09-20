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
    public function up(): void
    {
        Schema::create('windings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('preview_id')->nullable();

            $table->foreign('image_id')->references('id')->on('attachments')->nullOnDelete();
            $table->foreign('preview_id')->references('id')->on('attachments')->nullOnDelete();
            $table->unsignedBigInteger('sequence')->default(0);
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
        Schema::dropIfExists('windings');
    }
};
