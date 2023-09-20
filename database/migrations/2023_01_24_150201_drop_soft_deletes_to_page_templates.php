<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    public function down()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
