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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) {
                    $table->string('name')->nullable();
                }

                if (!Schema::hasColumn('users', 'email')) {
                    $table->string('email')->nullable()->unique();
                }

                if (!Schema::hasColumn('users', 'email_verified_at')) {
                    $table->timestamp('email_verified_at')->nullable();
                }

                if (!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }

                if (!Schema::hasColumns('users', ['created_at', 'updated_at'])) {
                    $table->timestamps();
                }
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email',
                'email_verified_at',
                'remember_token',
                'created_at',
                'updated_at'
                ]);
        });
    }
};
