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
        $materialFields = FormField::query()->where('name', 'material_cover');

        $materialFields->each(function ($materialField) {
            $materialFieldParameters = $materialField->parameters;

            $materialFieldParameters['parameters'] = 'Бумага';
            $materialFieldParameters['sequence'] = 2;

            FormField::query()->find($materialField->id)?->update([
                'parameters' => $materialFieldParameters
            ]);
        });
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
