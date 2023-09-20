<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $value = '{"white_print": {"conditions": {"visible": [{"field": "print_type", "value": 14}], "unchecked": [{"field":  "print_type", "value":  17}]}}, "complex_form": {"conditions": {"checked": [{"field": "mounting_film", "value": 1}], "readonly": [{"field": "mounting_film", "value": 1}]}}}';
        DB::update("update calculator_fields_configs set value = '$value' where id = 21");
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
