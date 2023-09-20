<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\File;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::delete("delete from previews");

        $paths = $this->getPreviewFullPaths(public_path().'/images/calc_previews/3814');

        $fileRows = [];
        $previewRows = [];

        foreach ($paths as $key => $path) {
            $fileRows[$key] = [
                'name' => 'preview.svg',
                'extension' => 'svg',
                'path' => $path . '/preview.svg',
                'user_id' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

            ];

            $explodePath = explode('/', str_replace('images/calc_previews/', '', $path));

            if (count($explodePath) > 3) {
                list($calcType, $calcId, $cutting, $formId) = $explodePath;
            } elseif (count($explodePath) > 2) {
                $formId = null;
                list($calcType, $calcId, $cutting) = $explodePath;
            } else {
                $formId = null;
                $cutting = null;
                list($calcType, $calcId) = $explodePath;
            }

            $file = new UploadedFile(public_path($fileRows[$key]['path']), "{$calcType}-{$calcId}-{$calcId}-{$cutting}-preview.svg");
            $attachment = (new File($file))->load();

            $previewRows[] = [
                'image' => $attachment->getKey(),
                'calculator_type_id' => $calcType,
                'calculator_id' => $calcId,
                'cutting_id' => is_numeric($cutting) ? $cutting : null,
                'form_id' => is_numeric($formId) ? $formId : null,
                'is_volume' => str_contains($path, 'volume'),
                'is_mounting_film' => str_contains($path, 'mounting_film'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('files')->insert($fileRows);
        DB::table('previews')->insert($previewRows);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::delete("delete from previews");
    }

    protected function getPreviewFullPaths(string $path): array
    {
        static $result = [];

        if (is_dir($path)) {
            $dir = opendir($path);
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..') {
                    $this->getPreviewFullPaths($path.'/'.$file);
                }
            }
        } else {
            $resultPath = str_replace('/preview.svg', '', str_replace(base_path(), '', $path));
            $resultPath = str_replace('/public/', '', $resultPath);
            $result[] = $resultPath;
        }

        return $result;
    }
};
