<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{
    public function order(): View
    {
        return view('order');
    }

    public function orderThank(Request $request, OrderService $service): Application|RedirectResponse|Redirector|View
    {
        $orderUuid = $request->query('order');

        if (null === $orderUuid || !Uuid::isValid($orderUuid)) {
            return redirect('/');
        }

        $order = $service->findOrderByUuid($orderUuid);

        return view('order-thank', ['order' => $order]);
    }

    public function send(Request $request, OrderService $orderService)
    {
        return response()->json(['success' => $orderService->send($request->all())]);
    }

    public function download(Request $request, OrderService $orderService)
    {
        return $orderService->download($request->get('id'));
    }
}
