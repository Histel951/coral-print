<?php

namespace App\Orchid\Screens;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\FileUpload;
use App\Orchid\Helpers\HAlert;
use App\Services\DepartmentService;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Symfony\Component\HttpFoundation\Request;

class DepartmentSettingsScreen extends Screen
{
    protected DepartmentService $departmentService;
    protected FileUploadService $fileUploadService;

    public function __construct(DepartmentService $departmentService, FileUploadService $fileUploadService)
    {
        $this->departmentService = $departmentService;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $departments = Department::all();

        return [
            'table' => $departments,
            ...$departments,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Отделения';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')
                ->modal('asyncEditModal')
                ->modalTitle('Новое отделение')
                ->method('saveData')
                ->icon('new-doc')
                ->type(Color::PRIMARY()),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('table', [
                TD::make('id', 'ID')->render(function (Department $model) {
                    return $model->id;
                }),

                TD::make('name', 'Имя')->render(function (Department $model) {
                    return $model->name;
                }),

                TD::make('metro', 'Метро')->render(function (Department $model) {
                    return $model->metro;
                }),

                TD::make('address', 'Адрес')->render(function (Department $model) {
                    return $model->address;
                }),

                TD::make('work_time', 'Режим работы')->render(function (Department $model) {
                    return $model->work_time;
                }),

                TD::make('action', 'Действие')->render(function (Department $model) {
                    return Group::make([
                        ModalToggle::make('Редактировать')
                            ->modal('asyncEditModal')
                            ->modalTitle('Настройки отделения')
                            ->method('saveData')
                            ->icon('note')
                            ->asyncParameters($model->toArray()),

                        ModalToggle::make('Удалить')
                            ->modal('asyncDeleteModal')
                            ->modalTitle('Удалить отделение')
                            ->method('deleteData')
                            ->icon('cross')
                            ->asyncParameters(['id' => $model->id]),
                    ]);
                }),
            ]),

            Layout::modal('asyncEditModal', [
                Layout::rows([
                    Input::make('name')->title('Название'),

                    Input::make('city')->title('Город'),

                    Input::make('address')->title('Адрес'),

                    Select::make('metro')->options(
                        array_combine(
                            $this->departmentService->getMetroStations(),
                            $this->departmentService->getMetroStations(),
                        ),
                    ),

                    Input::make('address_link')->title('Ссылка на карту'),

                    Input::make('address_route_link')->title('Ссылка на схему'),

                    Input::make('work_time')->title('Режим работы'),

                    SimpleMDE::make('text_route')->title('Как добраться (текст)'),

                    Upload::make('upload')
                        ->title('Как добраться (фото)')
                        ->maxFiles(3),
                ]),
            ])
                ->applyButton('OK')
                ->withoutCloseButton()
                ->async('asyncGetData')
                ->size(Modal::SIZE_LG),

            Layout::modal('asyncDeleteModal', [
                Layout::rows([])->title('Вы уверены, что хотите безвозвратно удалить запись?'),
            ])
                ->applyButton('Да')
                ->closeButton('Нет')
                ->async('asyncGetData'),
        ];
    }

    public function asyncGetData(Request $request): array
    {
        $result = $request->all();

        if ($request->get('id')) {
            $images = Department::find($request->get('id'))->images;
            $names = [];
            foreach ($images as $image) {
                $names[] = $this->fileUploadService->getClearName($image->path, true);
            }

            $uploads = array_column(
                Attachment::whereIn('name', $names)
                    ->distinct('name')
                    ->get('id')
                    ->toArray(),
                'id',
            );
            $result['upload'] = $uploads;
        }

        return $result;
    }

    public function saveData(DepartmentRequest $request): void
    {
        $request->validated();

        try {
            DB::beginTransaction();
            if ($model = Department::find($request->get('id'))) {
                $model->update($request->all());
                $model->images()->delete();
            } else {
                $model = new Department($request->all());
                $model->save();
            }

            if ($request->get('upload')) {
                $uploadFiles = auth()
                    ->user()
                    ->adminAttachments()
                    ->whereIn('id', $request->get('upload'))
                    ->get();
                foreach ($uploadFiles as $uploadFile) {
                    $newFile = new FileUpload([
                        'path' => $uploadFile->path . $uploadFile->name . '.' . $uploadFile->extension,
                        'fileable_type' => Department::class,
                        'fileable_id' => $model->id,
                        'is_temp' => false,
                    ]);
                    $newFile->save();
                }
            }

            DB::commit();
            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception) {
            DB::rollBack();
            Toast::error(HAlert::ERROR_MSG);
        }
    }

    public function deleteData(Request $request): void
    {
        if ($model = Department::find($request->get('id'))) {
            $success = $model->delete();
            HAlert::alert($success);
        }
    }
}
