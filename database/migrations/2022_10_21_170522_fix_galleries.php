<?php

use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryCategory;
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
        Gallery::query()->whereNot('content_id')->delete();
        GalleryCategory::query()->whereNot('content_id')->delete();

        Schema::table('galleries', function (Blueprint $table): void {
            $table->dropForeign(['content_id']);
        });
        Schema::table('gallery_categories', function (Blueprint $table): void {
            $table->dropForeign(['content_id']);
            $table->dropForeign(['calculator_id']);
        });
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
};
