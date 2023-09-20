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
        if (Schema::hasTable('calendar_size')) {
            Schema::table('calendar_size', function (Blueprint $table) {
                $table->bigInteger('calendar_id')->unsigned()->index()->change();
                $table->foreign('calendar_id')->references('id')->on('calendar')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('calendar_size_type')) {
            Schema::table('calendar_size_type', function (Blueprint $table) {
                $table->bigInteger('calendar_size_id')->unsigned()->index()->change();
                $table->foreign('calendar_size_id')->references('id')->on('calendar_size')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('calendar_type_lam')) {
            Schema::table('calendar_type_lam', function (Blueprint $table) {
                $table->bigInteger('calendar_size_type_id')->unsigned()->index()->change();
                $table->foreign('calendar_size_type_id')->references('id')->on('calendar_size_type')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('calendar_lam_price')) {
            Schema::table('calendar_lam_price', function (Blueprint $table) {
                $table->bigInteger('calendar_type_lam_id')->unsigned()->index()->change();
                $table->foreign('calendar_type_lam_id')->references('id')->on('calendar_type_lam')->onDelete('cascade');
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
        if (Schema::hasTable('calendar_size')) {
            Schema::table('calendar_size', function (Blueprint $table) {
                $table->dropForeign('calendar_id');
                $table->dropIndex('calendar_id');
            });
        }

        if (Schema::hasTable('calendar_size_type')) {
            Schema::table('calendar_size_type', function (Blueprint $table) {
                $table->dropForeign('calendar_size_id');
                $table->dropIndex('calendar_size_id');
            });
        }

        if (Schema::hasTable('calendar_type_lam')) {
            Schema::table('calendar_type_lam', function (Blueprint $table) {
                $table->dropForeign('calendar_size_type_id');
                $table->dropIndex('calendar_size_type_id');
            });
        }

        if (Schema::hasTable('calendar_lam_price')) {
            Schema::table('calendar_lam_price', function (Blueprint $table) {
                $table->dropForeign('calendar_type_lam_id');
                $table->dropIndex('calendar_type_lam_id');
            });
        }
    }
};
