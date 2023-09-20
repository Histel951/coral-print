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
        $updateJson = '{"lam": {
  "conditions": {
    "readonly": [
      {
        "field": "reverse_sticker", "value": 1
      },
      {
        "field": "white_print", "value": 1, "priority": 100
      }
    ],
  "selected": [
    {
      "field": "reverse_sticker", "value": 1, "selected_value": 47
    },
    {
      "field": "white_print", "value": 1, "selected_value": 1
    }, {"field": "white_print", "value": 1, "priority": 2, "selected_value": 1}]}}, "cutting": {"conditions": {"readonly": [{"field": "mounting_film", "value": 1, "selected_value": 2}], "selected": [{"field": "mounting_film", "value": 1, "selected_value": 2}]}},

  "material": {
    "conditions": {
      "readonlyAnd": [
        {
          "field_values": {"white_print": 1, "reverse_sticker": 1},
          "value": 22,
          "change_field": "material"
        }
      ]
    }
  }
}';
        DB::update("update calculator_fields_configs set value = '{$updateJson}' where id = 20");
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
