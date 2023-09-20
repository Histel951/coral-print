<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressSuggestRequest;
use App\Services\DadataSuggestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    public function address(AddressSuggestRequest $request, DadataSuggestService $service): JsonResponse
    {
        $data = $request->validated();

        return response()->json($service->address($data));
    }

    public function company(Request $request, DadataSuggestService $service): JsonResponse
    {
        $query = $request->json('query');

        if (null === $query || strlen($query) < 3) {
            return response()->json(
                [
                    'message' => 'Validation Error',
                    'detail' => null === $query ? 'query is required' : 'query length is less than 3',
                ],
                422,
            );
        }

        $data = [
            'query' => $query,
            'limit' => $request->json('limit'),
        ];

        return response()->json($service->company($data));
    }

    public function name(Request $request, DadataSuggestService $service)
    {
        $query = $request->json('query');

        if (null === $query || strlen($query) < 3) {
            return response()->json(
                [
                    'message' => 'Validation Error',
                    'detail' => null === $query ? 'query is required' : 'query length is less than 3',
                ],
                422,
            );
        }

        $data = [
            'query' => $query,
            'limit' => $request->json('limit'),
        ];

        return response()->json($service->name($data));
    }
}
