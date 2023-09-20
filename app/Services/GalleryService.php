<?php

namespace App\Services;

use App\Models\CalculatorType;
use App\Models\FileUpload;
use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryCategory;
use Illuminate\Support\Collection;

final class GalleryService
{
    private const ITEMS_COUNT = 12;

    public function __construct()
    {
    }

    public function addGalleryFile(array $request)
    {
        return FileUpload::query()->create([
            'path' => $request['url'],
            'fileable_id' => $request['gallery_id'] ?: null,
            'fileable_type' => Gallery::class,
            'is_temp' => true,
        ])->id;
    }

    /**
     * @param Collection $galleries
     * @return Collection
     */
    public function getGalleriesItemsInfo(?Collection $galleries): Collection
    {
        if (!$galleries) {
            return new Collection();
        }

        return $galleries->pluck('files');
    }

    /**
     * @param Collection $galleryCategories
     * @return Collection
     */
    public function getCategoriesGalleriesItemsInfo(Collection $galleryCategories): Collection
    {
        $items = new Collection();

        foreach ($galleryCategories as $galleryCategory) {
            $items->push($this->getGalleriesItemsInfo($galleryCategory->galleries));
        }

        return $items->collapse();
    }

    /**
     * @param int $contentId
     * @return Collection
     */
    public function getRandomGalleryItems(?int $calculatorTypeId): Collection
    {
        $calculatorType = CalculatorType::where('id', $calculatorTypeId)
            ->get()
            ->first();
        $items =
            $calculatorType?->calculators?->count() > 1
                ? $this->getCategoriesGalleriesItemsInfo($calculatorType?->galleryCategories)
                : $this->getGalleriesItemsInfo($calculatorType?->galleries);

        return $items
            ->collapse()
            ->shuffle()
            ->slice(0, self::ITEMS_COUNT);
    }

    /**
     * @param GalleryCategory|null $category
     * @return Collection
     */
    public function getVisibleGalleriesItems(?GalleryCategory $category): Collection
    {
        if (!$category) {
            return collect();
        }

        $result = collect();
        $count = 0;

        foreach ($category->galleries as $gallery) {
            $items = $gallery->files->shuffle()->slice(0, self::ITEMS_COUNT - $count);

            $result->add($items);

            $count += $items->count() + 2;
        }

        return $result;
    }

    public function getGalleriesCalculatorIds(?iterable $galleryCategories)
    {
        if (!$galleryCategories) {
            return [];
        }

        $result = [];

        foreach ($galleryCategories as $galleryCategory) {
            foreach ($galleryCategory->galleries as $gallery) {
                $result[$galleryCategory->id][] = $gallery->calculator_id;
            }
        }

        return $result;
    }
}
