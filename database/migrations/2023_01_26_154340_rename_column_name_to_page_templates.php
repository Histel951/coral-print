<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->dropIndex('page_templates_name_unique');
            $table->renameColumn('name', 'alias');
        });
    }

    public function down()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->renameColumn('alias', 'name');
            $table->unique('name');
        });
    }
};
