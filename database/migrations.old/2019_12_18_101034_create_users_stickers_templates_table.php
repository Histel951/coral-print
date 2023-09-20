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
        if (!Schema::hasTable('users_stickers_templates')) {
            Schema::create('users_stickers_templates', function (Blueprint $table) {
                $table->id();
                $table->text('user_id');
                $table->longText('img_body');
                $table->longText('img_preview_svg');
                $table->text('img_name');
                $table->smallInteger('is_admin')->default(0);
                $table->text('category');
                $table->text('const_type');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_stickers_templates');
    }
};
