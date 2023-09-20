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
        Schema::table('previews', function (Blueprint $table) {
            $table->unsignedTinyInteger('form_id')->after('cutting_id')->nullable();
            $table->boolean('is_volume')->after('form_id')->default(false);
            $table->boolean('is_mounting_film')->after('is_volume')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('previews', function (Blueprint $table) {
            $table->dropColumn(['form_id','is_volume', 'is_mounting_film']);
        });
    }
};
