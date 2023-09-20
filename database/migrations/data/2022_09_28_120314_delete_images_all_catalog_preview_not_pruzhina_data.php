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
        \App\Models\Preview::query()->whereNotIn('calculator_id', [3858, 3856, 3859])
            ->where('calculator_type_id', 3854)
            ->update([
                'image' => null
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
