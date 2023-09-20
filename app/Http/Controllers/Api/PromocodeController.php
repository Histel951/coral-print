<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PromocodeRequest;
use App\Models\Promocode;
use Symfony\Component\HttpFoundation\JsonResponse;

class PromocodeController extends Controller
{
    public function check(PromocodeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $discount = Promocode::query()
            ->where('value', $data['code'])
            ->first(['discount'])
            ?->toArray();

        return $discount !== null ? response()->json($discount) : response()->json(['message' => 'Not Found'], 404);
    }
}
