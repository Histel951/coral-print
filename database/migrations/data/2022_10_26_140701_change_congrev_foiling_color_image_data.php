<?php

use App\Models\Foiling;
use App\Models\FoilingColor;
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
        $congregationFoiling = Foiling::query()->where('name', 'Конгрев без фольги')
            ->where('is_congregation', 1)->first();

        $newColorImage = new UploadedFile(public_path('images/foilings/no-color-star-2.svg'), 'no-color-star-2.svg');
        $attachment = (new File($newColorImage))->load();

        FoilingColor::query()->find($congregationFoiling->colors()->first()->id)->update([
            'image_id' => $attachment->getKey()
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
