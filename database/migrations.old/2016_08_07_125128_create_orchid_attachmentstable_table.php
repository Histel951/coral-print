<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidAttachmentstableTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('attachments')) {
            Schema::create('attachments', function (Blueprint $table) {
                $table->id();
                $table->text('name');
                $table->text('original_name');
                $table->string('mime');
                $table->string('extension')->nullable();
                $table->bigInteger('size')->default(0);
                $table->integer('sort')->default(0);
                $table->text('path');
                $table->text('description')->nullable();
                $table->text('alt')->nullable();
                $table->text('hash')->nullable();
                $table->string('disk')->default('public');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->string('group')->nullable();
                $table->timestamps();


                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }

        if (!Schema::hasTable('attachmentable') and Schema::hasTable('attachments')) {
            Schema::create('attachmentable', function (Blueprint $table) {
                $table->id();
                $table->string('attachmentable_type');
                $table->unsignedBigInteger('attachmentable_id');
                $table->unsignedBigInteger('attachment_id');

                $table->index(['attachmentable_type', 'attachmentable_id']);

                $table->foreign('attachment_id')
                    ->references('id')
                    ->on('attachments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('attachmentable');
        Schema::drop('attachments');
    }
}
