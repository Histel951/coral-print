<?php

use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        FormField::query()->find(21)->update(['sequence' => 100]);

        PivotCalculatorBlockSelectFields::query()->find(29)?->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
