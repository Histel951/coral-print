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
        PrintSize::query()->where('height', 55)->where('width', 88)->update([
            'width' => 85,
            'name' => '85x55',
            'short_name' => '85x55'
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
