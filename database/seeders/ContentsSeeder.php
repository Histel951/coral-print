<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\File;
use App\Services\ContentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContentsSeeder extends Seeder
{
    protected ContentService $contentService;

    /**
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $queue = $this->getData();

        while (!empty($queue)) {
            $item = (array)array_shift($queue);
            $data[] = $item;
            $item && $queue = [...$queue, ...$this->getData($item['id'])];
        }

        $rows = [];
        foreach ($data as $datum) {
            $rows[] = [
                'content_id' => $datum['id'],
                'alias' => $datum['alias'],
                'title' => $datum['pagetitle'],
                'parent' => $datum['parent'],
                'page_title' => $datum['pagetitle'],
                'long_title' => $datum['longtitle'],
                'description' => $datum['description'],
                'content' => str_replace('.htm', '', $datum['content']),
                'url' => $datum['uri'],
                'is_folder' => $datum['isfolder'],
                'is_visible' => !$datum['hidemenu'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        Content::insert($rows);
        $this->fixUrl();
        $this->mainMenuInsert();
        $this->setContentCalcTypes();
    }

    private function getData($parent_ids = ContentService::PARENT_ID)
    {
        return DB::table('coral_site_content')
             ->where('parent', $parent_ids)
             ->where('type', 'document')
             ->get()
             ->toArray();
    }

    private function fixUrl()
    {
        $models = Content::all();
        foreach ($models as $model) {
            $model->update(['url' => $this->contentService->getUrl($model)]);
        }
    }

    public function mainMenuInsert()
    {
        $data = [
            'vizitki' => [
                'page_title' => 'Визитки',
                'min_price' => '290',
                'image' => 'CP-business-card-icon.svg',
            ],
            'pechat-nakleek' => [
                'page_title' => 'Наклейки',
                'min_price' => '350',
                'image' => 'stickers/cp-sticker-special-icon.svg',
            ],
            'pechat-listovok' => [
                'page_title' => 'Листовки',
                'min_price' => '655',
                'image' => 'CP-leaflet-icon.svg',
            ],
            'pechat-bukletov' => [
                'page_title' => 'Буклеты',
                'min_price' => '1330',
                'image' => 'CP-booklet-icon.svg',
            ],
            'pechat-flaerov' => [
                'page_title' => 'Флаеры',
                'min_price' => '460',
                'image' => 'CP-flyer-icon.svg',
            ],
            'pechat-katalogov' => [
                'page_title' => 'Каталоги',
                'image' => 'catalogs/CP-catalog-icon.svg',
            ],
            'pechat-obyavleniy' => [
                'page_title' => 'Объявления',
                'min_price' => '500',
                'image' => 'CP-advert-icon.svg',
            ],
            'pechat-otkritok' => [
                'page_title' => 'Открытки',
                'min_price' => '540',
                'image' => 'CP-postcard-icon.svg',
            ],
            'pechat-plakatov' => [
                'page_title' => 'Плакаты',
                'min_price' => '440',
                'image' => 'CP-poster-icon.svg',
            ],
            'pechat-blankov' => [
                'page_title' => 'Бланки',
                'min_price' => '550',
                'image' => 'CP-blank-icon.svg',
            ],
            'pechat-kalendarey' => [
                'page_title' => 'Календари',
                'min_price' => '990',
                'image' => 'calendars/CP-calendar-quarter-3-spring-icon.svg',
            ],
            'pechat-prezentaciy' => [
                'page_title' => 'Презентации',
                'image' => 'catalogs/CP-catalog-presentation-icon.svg',
            ],
            'pechat-bannerov' => [
                'page_title' => 'Баннеры',
                'min_price' => '990',
                'image' => 'CP-banner-icon.svg',
            ],
            'pechat-chertezhej' => [
                'page_title' => 'Чертежи',
                'min_price' => '360',
                'image' => 'CP-blueprint-icon.svg',
            ],
            'pechat-konvertov' => [
                'page_title' => 'Конверты',
                'min_price' => '730',
                'image' => 'CP-envelope-icon.svg',
            ],
            'bloknoty' => [
                'page_title' => 'Блокноты',
                'min_price' => '2889',
                'image' => 'catalogs/CP-catalog-notebook-icon.svg',
            ],
            'pechat-broshyur' => [
                'page_title' => 'Брошюры',
                'min_price' => '2889',
                'image' => 'catalogs/CP-catalog-clamp-icon.svg',
            ],
            'priglasitelnye' => [
                'page_title' => 'Приглашения',
                'min_price' => '540',
                'image' => 'CP-invitation-icon.svg',
            ],

        ];

        $localPath = 'images/menu/';
        $remotePath = 'https://staging.coral-print.ru/assets/images/icons/';

        $models = Content::whereIn('alias', array_keys($data))->get()->keyBy('alias');
        foreach ($models as $alias => $model) {
            $fileName = substr_replace($remotePath.$data[$alias]['image'], '', 0, strrpos($remotePath.$data[$alias]['image'], '/') + 1);

            if (!file_exists($localPath.$fileName)) {
                @file_put_contents('public/'.$localPath.$fileName, file_get_contents($remotePath.$data[$alias]['image']));
            }

            $file = new File([
                'name' => $fileName,
                'extension' => 'svg',
                'path' => $localPath.$fileName,
            ]);
            $file->save();
            $model->image = $file->id;

            $model->show_in_main = true;
            $model->page_title = $data[$alias]['page_title'];
            $model->min_price = $data[$alias]['min_price'] ?? null;

            $model->save();
        }
    }

    private function setContentCalcTypes()
    {
        $contentCalcTypes = [
            [
                'content_id' => 5,
                'calc_type' => 3814,
            ],
            [
                'content_id' => 13,
                'calc_type' => 3854,
            ],
            [
                'content_id' => 2,
                'calc_type' => 3855,
            ],
            [
                'content_id' => 4,
                'calc_type' => 3856,
            ]
        ];

        Schema::disableForeignKeyConstraints();
        array_map(fn ($v) => Content::query()->where('content_id', $v['content_id'])->update(['calc_type' => $v['calc_type']]), $contentCalcTypes);
        Schema::enableForeignKeyConstraints();
    }
}
