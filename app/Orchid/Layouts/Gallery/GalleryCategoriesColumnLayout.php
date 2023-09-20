<?php

namespace App\Orchid\Layouts\Gallery;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryCategory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

class GalleryCategoriesColumnLayout extends Layout
{
    /**
     * @var string
     */
    protected $template = 'orchid.layouts.gallery-categories-column-layout';

    protected $title = 'Категории';

    protected $target = 'galleryCategories';

    protected function categoryActions()
    {
        return fn (GalleryCategory $galleryCategory) => [
            ModalToggle::make()
                ->modal('asyncAttachGalleryModal')
                ->modalTitle('Добавление галереи')
                ->method('attachGallery')
                ->asyncParameters([
                    'galleryCategory' => $galleryCategory->id,
                    'calculatorType' => $galleryCategory->calculator_type_id,
                ])
                ->icon('plus'),
            ModalToggle::make()
                ->modal('asyncEditGalleryCategoryModal')
                ->modalTitle('Переименовать')
                ->method('updateGalleryCategory', ['id' => $galleryCategory->id])
                ->asyncParameters([
                    'galleryCategory' => $galleryCategory->id,
                ])
                ->icon('pencil'),
            Button::make()
                ->method('removeGalleryCategory')
                ->icon('trash')
                ->confirm('Вы уверены, что хотите безвозвратно удалить категорию?')
                ->parameters([
                    'galleryCategory' => $galleryCategory->id,
                ]),
        ];
    }

    public function galleryActions()
    {
        return fn (GalleryCategory $galleryCategory, Gallery $gallery) => [
            Button::make()
                ->method('detachGallery')
                ->icon('trash')
                ->confirm('Вы уверены, что хотите безвозвратно удалить связку?')
                ->parameters([
                    'galleryCategory' => $galleryCategory->id,
                    'gallery' => $gallery->id,
                ]),
        ];
    }

    public function build(Repository $repository)
    {
        $this->query = $repository;

        $rows = $repository->getContent($this->target);
        $rows = is_array($rows) ? collect($rows) : $rows;

        return view($this->template, [
            'repository' => $repository,
            'rows' => $rows,
            'categoryActions' => $this->categoryActions(),
            'galleryActions' => $this->galleryActions(),
            'slug' => $this->getSlug(),
            'title' => $this->title,
        ]);
    }
}
