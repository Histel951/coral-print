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
        Schema::create('gallery_files', function (Blueprint $table) {
            $table->id();

            $table->string('alt', 256);
            $table->string('description', 1024);
            $table->string('basename', 256);
            $table->string('path', 2048);

            $table->foreignId('gallery_id')
                ->constrained('galleries')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('gallery_files');
    }
};
