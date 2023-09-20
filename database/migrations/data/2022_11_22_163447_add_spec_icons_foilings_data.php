<?php

use App\Models\Foiling;
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
        $noOtdelka = Foiling::query()->where('name', 'Без отделки')->first();
        $noEmbossing = Foiling::query()->where('name', 'Без тиснения')->first();
        $congrevWithoutFoiling = Foiling::query()->where('name', 'Конгрев без фольги')->first();

        $newFile = new UploadedFile(public_path('images/foilings/congrev-spec.svg'), 'congrev-spec.svg');
        $congrevWithoutFoilingIcon = (new File($newFile))->load();

        $newFile = new UploadedFile(public_path('images/foilings/no-color-spec-icon.svg'), 'no-color-spec-icon.svg');
        $noColorSpecIcon = (new File($newFile))->load();

        $noOtdelka->update([
            'spec_icon_id' => $noColorSpecIcon->getKey()
        ]);

        $congrevWithoutFoiling->update([
            'spec_icon_id' => $congrevWithoutFoilingIcon->getKey()
        ]);

        $noEmbossing->update([
            'spec_icon_id' => $noColorSpecIcon->getKey()
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
