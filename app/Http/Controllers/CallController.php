<?php

namespace App\Http\Controllers;

use App\Services\CallService;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function callback(Request $request, CallService $callService)
    {
        return response()->json(['success' => (bool) $callService->callback($request->get('phone'))]);
    }
}
