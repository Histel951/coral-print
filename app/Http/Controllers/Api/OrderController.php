<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderCreateRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request, OrderService $service)
    {
        $data = $request->validated();

        $order = $service->createFromApi($data);

        return response()->json($order, 201);
    }
}
