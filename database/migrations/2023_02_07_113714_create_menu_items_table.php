<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('url')->nullable();
            $table->unsignedTinyInteger('order');
            $table->boolean('is_visible')->default(true);

            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
