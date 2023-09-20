<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->string('name')->after('alias');
            $table->unique('alias');
        });
    }

    public function down()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->dropIndex('page_templates_alias_unique');
            $table->dropColumn('name');
        });
    }
};
