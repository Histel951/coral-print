<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->boolean('is_production')->default(true)->nullable();
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('is_production');
        });
    }
};
