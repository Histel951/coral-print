<?php

namespace App\Orchid\Screens\Gallery;

use App\Http\Requests\GalleryRequest;
use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Gallery\Gallery;
use App\Orchid\Fields\FileManagerSelector;
use App\Orchid\Helpers\HAlert;
use App\Services\Gallery\GalleryFilesService;
use App\Services\Gallery\GalleryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Throwable;

class GalleryEditScreen extends Screen
{
    public CalculatorType $calculatorType;
    public Gallery $gallery;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(CalculatorType $calculatorType, Gallery $gallery): iterable
    {
        return [
            'calculatorType' => $calculatorType,
            'gallery' => $gallery,
            'files' => $gallery->files()->pluck('id'),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('edit'),
            Button::make('Удалить')
                ->type(Color::DANGER())
                ->method('delete'),
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
            Layout::rows([
                Input::make('gallery.name')
                    ->title('Название')
                    ->required(),

                Select::make('gallery.calculator_id')
                    ->title('Калькулятор')
                    ->fromQuery(Calculator::where('calculator_type_id', $this->calculatorType->id), 'name')
                    ->required(),
            ]),

            Layout::rows([FileManagerSelector::make('files')->title('Файлы')]),
        ];
    }

    public function delete(Request $request, CalculatorType $calculatorType, Gallery $gallery)
    {
        try {
            $gallery->delete();
            $gallery->files->each->delete();

            Toast::success(HAlert::SUCCESS_MSG);

            return to_route('platform.gallery', $calculatorType);
        } catch (Throwable) {
            Toast::error(HAlert::ERROR_MSG);
        }
    }

    public function edit(
        GalleryService $galleryService,
        GalleryFilesService $galleryFilesService,
        GalleryRequest $request,
        CalculatorType $calculatorType,
        Gallery $gallery,
    ) {
        try {
            DB::beginTransaction();

            $galleryService->updateFromRequest($gallery, [
                'name' => $request->input('gallery.name'),
                'calculator_id' => $request->input('gallery.calculator_id'),
            ]);

            $galleryFilesService->syncFromRequest($gallery, $request->input('files', []));

            DB::commit();

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (Throwable) {
            DB::rollback();

            Toast::error(HAlert::ERROR_MSG);
        }
    }
}
