<?php

use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        FormField::query()->whereIn('name', ['color_count_face', 'color_count_back'])->update(['type' => 'select-color']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FormField::query()->whereIn('name', ['color_count_face', 'color_count_back'])->update(['type' => 'select']);
    }
};
