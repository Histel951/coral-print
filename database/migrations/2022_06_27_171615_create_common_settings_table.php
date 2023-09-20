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
        Schema::create('common_settings', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('email_complain')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedTinyInteger('discount_value')->default(0);
            $table->text('yandex_review_link')->nullable();
//            $table->unsignedFloat('yandex_review_rate', 2, 1)->nullable();
//            $table->unsignedInteger('yandex_review_quantity')->default(0);
            $table->text('google_review_link')->nullable();
//            $table->unsignedFloat('google_review_rate', 2, 1)->nullable();
//            $table->unsignedInteger('google_review_quantity')->default(0);
            $table->string('instagram_review_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('vk_link')->nullable();
            $table->text('bank_details')->nullable();
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
        Schema::dropIfExists('common_settings');
    }
};
