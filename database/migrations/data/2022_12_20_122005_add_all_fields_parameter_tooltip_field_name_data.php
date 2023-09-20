<?php

use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        FormField::all()->each(function (FormField $field) {
            $parameters = $field->parameters;

            if (isset($parameters['label'])) {
                $parameters['tooltip_field_name'] = $parameters['label'];
            }

            $field->update([
                'parameters' => $parameters
            ]);
        });

        $pageCount = FormField::query()->where('name', 'page_count')->first();
        $pageSelect = FormField::query()->where('name', 'page_select')->first();

        $pageSelectParameters = $pageSelect->parameters;
        $pageSelectParameters['tooltip_field_name'] = "{$pageSelectParameters['label']}, выборка из селекта";
        $pageCountParameters = $pageCount->parameters;
        $pageCountParameters['tooltip_field_name'] = "{$pageCountParameters['label']}, текстовое поле";

        $pageCount->update([
            'parameters' => $pageCountParameters
        ]);

        $pageSelect->update([
            'parameters' => $pageSelectParameters
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
