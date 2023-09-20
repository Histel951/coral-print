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
        \App\Models\Preview::query()->create([
            'calculator_id' => 3819,
            'calculator_type_id' => 3814,
            'form_id' => 54,
            'cutting_id' => 2,
            'image'=> 148
        ]);

        \App\Models\Preview::query()->create([
            'calculator_id' => 3821,
            'calculator_type_id' => 3814,
            'form_id' => 54,
            'cutting_id' => 2,
            'image'=> 148
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
