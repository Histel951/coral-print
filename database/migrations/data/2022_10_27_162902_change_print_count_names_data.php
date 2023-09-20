<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        \App\Models\ColorCount::query()->find(26)->update([
            'name' => 'Шесть цветов'
        ]);

        \App\Models\ColorCount::query()->find(27)->update([
            'name' => 'Шесть цветов'
        ]);

        \App\Models\ColorCount::query()->find(28)->update([
            'name' => 'Шесть цветов'
        ]);
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
