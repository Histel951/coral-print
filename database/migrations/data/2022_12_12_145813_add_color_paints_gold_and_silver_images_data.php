<?php

use App\Models\ColorPaint;
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
        $paintWhite = ColorPaint::query()->where('name', 'Белый (W)')->first();

        $paintWhite->update([
            'image_id' => null,
            'color' => '#ffffff'
        ]);

        $paintSilver = ColorPaint::query()->where('name', 'Серебряная краска')->first();

        $fileSilver = new UploadedFile(public_path("/images/paints/silver.svg"), 'silver.svg');
        $attachmentSilver = (new File($fileSilver))->load();

        $paintSilver->update([
            'image_id' => $attachmentSilver->getKey()
        ]);

        $paintGold = ColorPaint::query()->where('name', 'Золотая краска')->first();

        $fileGold = new UploadedFile(public_path("/images/paints/gold.svg"), 'gold.svg');
        $attachmentGold = (new File($fileGold))->load();

        $paintGold->update([
            'image_id' => $attachmentGold->getKey()
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
