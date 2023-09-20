<?php

use App\Models\Calculator;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCatalogCalculatorsIds = Calculator::query()
            ->where('calculator_type_id', 3854)->pluck('id');

        $line = [
            'url' => 'images/catalog-preview/line.svg',
            'name' => 'line.svg',
//            'template_height_percent' => 100
        ];

        $newFile = new UploadedFile(public_path($line['url']), $line['name']);
        $attachment = (new File($newFile))->load();

        Preview::query()
            ->whereIn('calculator_id', $allCatalogCalculatorsIds)
            ->where('is_split', 0)
            ->where('dependence', 'width')
            ->where('sequence', 2)
            ->update([
                'image' => $attachment->getKey(),
//                'template_height_percent' => $line['template_height_percent'],
//                'static_width' => 1
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
