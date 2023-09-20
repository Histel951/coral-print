<?php

use App\Models\Calculator;
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
        $allCatalogCalculators = Calculator::query()->where('calculator_type_id', 3854);

        $allCatalogCalculators->each(fn (Calculator $calculator) => $calculator->previews()->delete());

        $previewsData = [
            'broshury-h' => [
                'url' => 'images/catalog-preview/broshury.svg',
                'name' => 'broshury.svg',
                'template_height_percent' => 70,
                'dependence' => 'height',
                'sequence' => 1,
                'is_bracing_as_image_part' => 1,
                'description' => 'В сложенном виде: #width#✗#height# мм'
            ],
            'broshury-w' => [
                'url' => 'images/catalog-preview/line.svg',
                'template_height_percent' => 100,
                'name' => 'line.svg',
                'dependence' => 'width',
                'sequence' => 1,
                'description' => 'В развернутом виде: #width#✗#height# мм'
            ],
            'line' => [
                'url' => 'images/catalog-preview/line.svg',
                'name' => 'line.svg',
                'template_height_percent' => 100,
                'dependence' => 'width',
                'sequence' => 2,
                'description' => 'В развернутом виде: #width#✗#height# мм'
            ],
            'pruzhina-w' => [
                'url' => 'images/catalog-preview/pruzhina.svg',
                'template_height_percent' => 94,
                'name' => 'pruzhina.svg',
                'dependence' => 'width',
                'sequence' => 2,
                'is_split' => 1,
                'rotate_sprint_position_id' => 1,
                'static_width' => 12,
                'description' => 'В развернутом виде: #width#✗#height# мм'
            ],
            'pruzhina-h' => [
                'url' => 'images/catalog-preview/pruzhina.svg',
                'name' => 'pruzhina.svg',
                'template_height_percent' => 94,
                'dependence' => 'height',
                'sequence' => 1,
                'rotate_sprint_position_id' => 1,
                'transition_x' => 50,
                'static_width' => 14,
                'description' => 'В сложенном виде: #width#✗#height# мм'
            ],
            'screpi-w' => [
                'url' => 'images/catalog-preview/screpi-w.svg',
                'name' => 'screpi-w.svg',
                'template_height_percent' => 100,
                'dependence' => 'width',
                'sequence' => 2,
                'static_width' => 4,
                'description' => 'В развернутом виде: #width#✗#height# мм'
            ],
            'screpi-h' => [
                'url' => 'images/catalog-preview/screpi-h.svg',
                'name' => 'screpi-h.svg',
                'template_height_percent' => 100,
                'dependence' => 'height',
                'sequence' => 1,
                'static_width' => 3,
                'description' => 'В сложенном виде: #width#✗#height# мм'
            ]
        ];

        // calculator_id => preview-name
        $calculatorPreviews = [
            3855 => ['screpi-h', 'screpi-w'],
            3860 => ['screpi-h', 'screpi-w'],
            3856 => ['pruzhina-w', 'pruzhina-h'],
            3858 => ['pruzhina-w', 'pruzhina-h'],
            3859 => ['pruzhina-w', 'pruzhina-h'],
            3866 => ['broshury-h', 'broshury-w'],
            Calculator::query()->where('calculator_type_id', 3854)->latest()->first()->id => ['broshury-h', 'broshury-w']
        ];

        foreach ($calculatorPreviews as $calculatorId => $previews) {
            foreach ($previews as $previewName) {
                $item = $previewsData[$previewName];

                if ($item['url']) {
                    $file = new UploadedFile(public_path($item['url']), $item['name']);
                    $attachment = (new File($file))->load();
                }

                unset($item['url']);
                unset($item['name']);
                $item['image'] = isset($attachment) ? $attachment->getKey() : null;
                $item['calculator_type_id'] = 3854;
//                $item['is_changeable'] = 1;

                Calculator::query()->find($calculatorId)->previews()->create($item);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Calculator::query()->where('calculator_type_id', 3854)
            ->each(
                fn (Calculator $calculator) => $calculator->previews()->delete()
            );
    }
};
