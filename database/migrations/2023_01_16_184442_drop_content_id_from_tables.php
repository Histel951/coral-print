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
        if (Schema::hasColumn('galleries', 'content_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                if ($this->hasIndex('galleries', 'galleries_content_id_foreign')) {
                    $table->dropIndex('galleries_content_id_foreign');
                }

                $table->dropColumn('content_id');
            });
        }

        if (Schema::hasColumn('gallery_categories', 'content_id')) {
            Schema::table('gallery_categories', function (Blueprint $table) {
                if ($this->hasIndex('gallery_categories', 'gallery_categories_content_id_foreign')) {
                    $table->dropIndex('gallery_categories_content_id_foreign');
                }

                $table->dropColumn('content_id');
            });
        }

        Schema::dropIfExists('gallery_video_links');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function hasIndex(string $table, string $key): bool
    {
        return collect(DB::select("SHOW INDEXES FROM {$table}"))->pluck('Key_name')->contains($key);
    }
};
