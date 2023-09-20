<?php

use App\Models\PrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PrintSize::query()->find(76)->update([
            'name' => 'А3 (297x420 мм)',
            'short_name' => '297x420'
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
