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
        FormField::query()->where('parameters->label', 'like', 'Материал')
            ->each(fn (FormField $formField) => $formField->update(['parameters->label' => 'Материал']));

        FormField::query()->where('name', 'in', ['foiling_cover', 'foiling_block', 'foiling_substrate'])
            ->each(fn (FormField $formField) => $formField->update(['parameters->label' => 'Ламинация']));

        FormField::query()->where('name', 'in', ['color_cover', 'color_block', 'color_substrate'])
            ->each(fn (FormField $formField) => $formField->update(['parameters->label' => 'Цветность']));
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
