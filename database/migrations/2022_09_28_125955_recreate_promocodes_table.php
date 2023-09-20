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
        Schema::dropIfExists('sent_promocodes');
        Schema::dropIfExists('promocodes');

        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->unsignedInteger('discount')->default(0);
            $table->string('email')->nullable();
            $table->unsignedInteger('source');
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('content_id')->nullable();
            $table->foreignId('review_id')->nullable()->constrained('reviews')->nullOnDelete();
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
        Schema::dropIfExists('promocodes');
    }
};
