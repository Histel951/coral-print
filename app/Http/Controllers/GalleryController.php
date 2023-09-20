<?php

namespace App\Http\Controllers;

use App\Models\Gallery\GalleryCategory;
use App\Services\GalleryService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function getGallery(Request $request, GalleryService $galleryService)
    {
        if ($request->boolean('is_random')) {
            $items = $galleryService->getRandomGalleryItems($request->integer('calculatorTypeId'));

            return response()->json([
                'html' => view('partials.gallery_div_random', ['files' => $items])->render(),
                'info' => $items,
            ]);
        }

        $category = GalleryCategory::with('galleries.files')->findOrNew($request->input('tab'));

        $galleries = $galleryService->getVisibleGalleriesItems($category);

        return response()->json([
            'html' => view('partials.gallery_div', ['galleries' => $galleries])->render(),
            'info' => $galleries->collapse(),
        ]);
    }
}
