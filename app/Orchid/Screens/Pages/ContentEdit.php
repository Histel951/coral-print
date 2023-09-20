<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Content;
use App\Models\File;
use App\Models\Pages\PageTemplate;
use App\Orchid\Fields\CKEditor;
use App\Services\ContentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContentEdit extends Screen
{
    protected ContentService $contentService;

    /**
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    private string $scenario = self::SCENARIO_CREATE;

    private const SCENARIO_CREATE = 'create';
    private const SCENARIO_EDIT = 'edit';

    /**
     * Query data.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function query(): iterable
    {
        if (
            request()->get('content_id') &&
            ($model = Content::where('content_id', request()->get('content_id'))
                ->get()
                ->first())
        ) {
            $this->scenario = self::SCENARIO_EDIT;

            return [...$model->toArray(), 'uploadImg' => $model->attachFile->id ?? null];
        }

        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->scenario == self::SCENARIO_EDIT ? 'Редактирование записи' : 'Создание записи';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function commandBar(): iterable
    {
        if ($this->scenario == self::SCENARIO_EDIT) {
            return [
                Button::make('Удалить')
                    ->method('deleteData')
                    ->type(Color::DANGER())
                    ->icon('cross')
                    ->confirm('Вы уверены, что хотите безвозвратно удалить запись?')
                    ->parameters(['content_id' => request()->get('content_id')]),
            ];
        }
        return [];
    }

    /**
     * Views.
     *
     * @return iterable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('title')->title('Название'),

                    Input::make('alias')->title('Алиас'),

                    Input::make('page_title')->title('Заголовок'),

                    Input::make('long_title')->title('Расширенный заголовок'),

                    Input::make('description')->title('Описание'),
                ]),

                Layout::rows([
                    Input::make('min_price')->title('Минимальная цена'),

                    Select::make('parent')
                        ->title('Родительская папка')
                        ->fromQuery(
                            Content::where('is_folder', 1)->where('content_id', '!=', request()->get('content_id')),
                            'title',
                            'content_id',
                        )
                        ->empty(''),

                    Select::make('calc_type')
                        ->id('calc_type')
                        ->title('Категория калькулятора')
                        ->fromModel(CalculatorType::class, 'name')
                        ->empty(),

                    Select::make('default_calculator_id')
                        ->id('default_calculator_id')
                        ->title('Калькулятор по умолчанию')
                        ->fromQuery(
                            Calculator::where(
                                'calculator_type_id',
                                Content::where('content_id', request()->get('content_id'))
                                    ->get()
                                    ->first()?->calc_type,
                            ),
                            'name',
                        )
                        ->empty(),

                    Group::make([
                        Input::make('url')
                            ->title('URL')
                            ->disabled(),

                        Link::make('Перейти')
                            ->href($this->getLinkHref())
                            ->target('_blank')
                            ->hidden(is_null(request()->get('content_id'))),
                    ])->alignStart(),
                ]),
            ]),

            Layout::rows([
                Upload::make('uploadImg')
                    ->title('Изображение')
                    ->maxFiles(1),

                Select::make('page_template_id')
                    ->id('page_template_id')
                    ->title('Шаблон страницы')
                    ->fromModel(PageTemplate::class, 'name')
                    ->empty('Не выбрано'),

                CKEditor::make('content')
                    ->title('Контент'),

                Group::make([
                    CheckBox::make('is_folder')
                        ->title('Папка')
                        ->sendTrueOrFalse(),

                    CheckBox::make('is_visible')
                        ->title('Показывать')
                        ->sendTrueOrFalse(),

                    CheckBox::make('show_in_main')
                        ->title('Показывать на главной')
                        ->sendTrueOrFalse(),

                    CheckBox::make('only_default_calculator_id')
                        ->title('Отображать только калькулятор по умолчанию')
                        ->sendTrueOrFalse(),
                ]),

                Button::make('Сохранить')
                    ->method('saveData')
                    ->parameters(['content_id' => request()->get('content_id')])
                    ->type(Color::SUCCESS())
                    ->icon('cursor'),
            ]),
            Layout::view('orchid.contentEdit_select', [
                'calcs' => json_encode(
                    Calculator::all()
                        ->groupBy('calculator_type_id')
                        ->toArray(),
                ),
            ]),
        ];
    }

    public function saveData()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string',
            'alias' => 'required|string|regex:/^[a-z0-9-]+$/',
        ]);

        $data = $this->prepareData(request()->all());

        $validator->after(function ($validator) use ($data) {
            if ($this->checkAliasExists($data['url'])) {
                $validator->errors()->add('alias', 'Такой алиас уже существует в текущей папке');
            }
        });
        $validator->validate();

        try {
            DB::beginTransaction();
            if ($model = Content::where('content_id', request()->get('content_id'))->first()) {
                if ($model->is_folder && !$data['is_folder']) {
                    if (!$this->contentService->isEmptyFolder($model->content_id)) {
                        Toast::error('Папка не пуста!');
                        return null;
                    }
                }

                if ($model->parent != $data['parent']) {
                    $oldId = $model->parent;
                }

                $model->update($data);

                if (isset($oldId)) {
                    $this->contentService->updateChildsUrl($model->content_id);

                    $model->reviews()->update(['content_id' => $model->parent], ['content_id' => $oldId]);
                }

                if ($this->isFolderAndHidden($data)) {
                    $this->contentService->updateChildsVisible($data['content_id']);
                }
            } else {
                $model = new Content($data);
                $model->save();
            }

            if (request()->has('uploadImg')) {
                $uploadFile = auth()
                    ->user()
                    ->adminAttachments()
                    ->where('id', request()->get('uploadImg'))
                    ->get()
                    ->first();

                $file = new File([
                    'name' => $uploadFile->name . '.' . $uploadFile->extension,
                    'extension' => $uploadFile->extension,
                    'path' => 'storage/' . $uploadFile->path . $uploadFile->name . '.' . $uploadFile->extension,
                    'attach_id' => $uploadFile->id,
                ]);
                $file->save();
                $model->image = $file->id;
                $model->save();
            }

            DB::commit();
            Cache::flush();
            Toast::success('Данные успешно обновлены');
        } catch (\Exception $e) {
            DB::rollBack();
            Toast::error('При обновлении данных произошла ошибка!');
        }

        return redirect()->route('platform.content');
    }

    public function deleteData()
    {
        $model = Content::where('content_id', request()->get('content_id'))->first();

        try {
            DB::beginTransaction();

            $model->delete();
            $this->contentService->deleteChilds($model->content_id);

            DB::commit();
            Cache::forget('contents');
            Toast::success('Данные успешно удалены');
        } catch (\Exception) {
            DB::rollBack();

            Toast::error('При удалении данных произошла ошибка');
        }

        return redirect()->route('platform.content');
    }

    public function getLinkHref(): string
    {
        return URL::to(
            Content::where('content_id', request()->get('content_id'))
                ->get('url')
                ->first()?->url,
        );
    }

    private function isFolderAndHidden(array $data): bool
    {
        return $data['is_folder'] && !$data['is_visible'];
    }

    public function prepareData(array $requestData): array
    {
        $data = $requestData;
        $data['parent'] = $data['parent'] ?? ContentService::PARENT_ID;
        $data['content_id'] =
            $data['content_id'] ??
            Content::orderby('content_id', 'desc')
                ->withTrashed()
                ->first()->content_id +
                1;
        $parrentUrl = Content::where('content_id', $data['parent'])
            ->get('url')
            ->first()?->url;
        $data['url'] = ($parrentUrl ? $parrentUrl . '/' : '') . $data['alias'];

        return $data;
    }

    private function checkAliasExists($url): bool
    {
        return (bool) Content::where('url', $url)
            ->where('content_id', '!=', request()->get('content_id'))
            ->get()
            ->first();
    }
}
