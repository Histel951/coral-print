<?php

namespace App\Http\Controllers;

use App\Services\FileUploadService;
use App\Services\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(
        private readonly FileUploadService $fileUploadService,
        private readonly GalleryService $galleryService,
    ) {
    }

    public function upload(Request $request): JsonResponse
    {
        $files = $this->fileUploadService->upload($request->all());

        return response()->json([
            'success' => (bool) $files,
            'file_id' => $files,
        ]);
    }

    public function delete(int $id)
    {
        $this->fileUploadService->delete($id);

        return response('', 204);
    }

    public function add(Request $request): JsonResponse
    {
        $id = $this->galleryService->addGalleryFile($request->all());

        return response()->json([
            'success' => !is_null($id),
            'id' => $id,
        ]);
    }
}
