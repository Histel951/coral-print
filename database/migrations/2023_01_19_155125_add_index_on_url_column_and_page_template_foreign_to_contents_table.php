<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->index('url');
            $table->foreignId('page_template_id')->nullable()->constrained('page_templates');
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropIndex('contents_url_index');
            $table->dropConstrainedForeignId('page_template_id');
        });
    }
};
