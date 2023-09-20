<?php

namespace App\Http\Controllers;

use App\Services\PromocodeService;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function index(Request $request, PromocodeService $promocodeService)
    {
        return $promocodeService->getDisbledPromodes();
    }
}
