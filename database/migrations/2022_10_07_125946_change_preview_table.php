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
    public function up(): void
    {
        Schema::table('previews', function (Blueprint $table) {
            $table->dropForeign('previews_rotate_sprint_position_id_foreign');
            $table->dropColumn(
                'scale_y',
                'scale_x',
                'static_width',
                'transition_y',
                'transition_x',
                'rotate_sprint_position_id',
                'is_bracing_as_image_part',
                'template_height_merger_percent',
                'template_height_percent'
            );

            $table->foreignId('print_size_id')->nullable();
            $table->float('coefficient_h')->default(0);
            $table->float('coefficient_w')->default(0);
            $table->unsignedInteger('height')->default(0);
            $table->unsignedInteger('width')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('previews', function (Blueprint $table) {
//            $table->dropColumn('print_size_id', 'coefficient_h', 'coefficient_w', 'height', 'width');
        });
    }
};
