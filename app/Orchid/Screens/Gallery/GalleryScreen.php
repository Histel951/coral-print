<?php

namespace App\Orchid\Screens\Gallery;

use App\Models\CalculatorType;
use App\Models\Gallery\GalleryCategory;
use App\Models\Gallery\Gallery;
use App\Orchid\Layouts\Gallery\GalleriesColumnLayout;
use App\Orchid\Layouts\Gallery\GalleryCategoriesColumnLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class GalleryScreen extends Screen
{
    public CalculatorType $calculatorType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(CalculatorType $calculatorType): iterable
    {
        $calculatorType->loadMissing(['galleryCategories.galleries', 'galleries']);

        return [
            'calculatorType' => $calculatorType,
            'galleryCategories' => $calculatorType->galleryCategories->sortBy('name'),
            'galleries' => $calculatorType->galleries->sortBy('name'),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Галереи ' . $this->calculatorType->name;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать категорию')
                ->modal('asyncAddGalleryCategoryModal')
                ->modalTitle('Новая категория')
                ->hidden($this->calculatorType->calculators()?->count() < 2)
                ->method('addGalleryCategory')
                ->icon('browser'),

            Link::make('Создать галерею')
                ->route('platform.gallery.create', ['id' => $this->calculatorType->id])
                ->icon('camera'),
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
            Layout::columns([GalleryCategoriesColumnLayout::class, GalleriesColumnLayout::class]),

            Layout::asyncModal('asyncAttachGalleryModal', function (Repository $repository) {
                return [
                    Layout::rows([
                        Relation::make('galleries')
                            ->title('Галереи')
                            ->multiple()
                            ->fromModel(Gallery::class, 'name')
                            ->applyScope(
                                'nonUsedElementsInCategory',
                                $repository->getContent('calculatorType.id'),
                                $repository->getContent('galleryCategory.id'),
                            ),
                    ]),
                ];
            })->async('asyncAttachGalleryModalQuery'),

            Layout::modal('asyncAddGalleryCategoryModal', [
                Layout::rows([
                    Input::make('name')
                        ->title('Наименование')
                        ->required(),
                ]),
            ])->async('asyncAddGalleryCategoryModalQuery'),

            Layout::modal('asyncEditGalleryCategoryModal', [
                Layout::rows([
                    Input::make('name')
                        ->title('Наименование')
                        ->required(),
                ]),
            ])->async('asyncEditGalleryCategoryModalQuery'),
        ];
    }

    public function asyncAddGalleryCategoryModalQuery(Request $request)
    {
        return [];
    }

    public function addGalleryCategory(Request $request, CalculatorType $calculatorType)
    {
        $calculatorType->galleryCategories()->create($request->only(['name']));
    }

    public function asyncEditGalleryCategoryModalQuery(GalleryCategory $galleryCategory)
    {
        return [
            'name' => $galleryCategory->name,
        ];
    }

    public function asyncAttachGalleryModalQuery(
        Request $request,
        GalleryCategory $galleryCategory,
        CalculatorType $calculatorType,
    ) {
        return [
            'galleries' => [],
            'galleryCategory' => $galleryCategory,
            'calculatorType' => $calculatorType,
        ];
    }

    public function attachGallery(Request $request, CalculatorType $calculatorType)
    {
        $calculatorType
            ->galleryCategories()
            ->findOrFail($request->input('galleryCategory'))
            ->galleries()
            ->syncWithoutDetaching($request->input('galleries', []));
    }

    public function detachGallery(Request $request, CalculatorType $calculatorType)
    {
        $calculatorType
            ->galleryCategories()
            ->findOrFail($request->input('galleryCategory'))
            ->galleries()
            ->detach($request->input('gallery'));
    }

    public function updateGalleryCategory(Request $request, CalculatorType $calculatorType)
    {
        $calculatorType
            ->galleryCategories()
            ->findOrFail($request->input('galleryCategory'))
            ->update($request->only(['name']));
    }

    public function removeGalleryCategory(Request $request, CalculatorType $calculatorType)
    {
        $calculatorType
            ->galleryCategories()
            ->findOrFail($request->input('galleryCategory'))
            ->delete();
    }
}
