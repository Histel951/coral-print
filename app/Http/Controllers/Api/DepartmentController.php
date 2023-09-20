<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class DepartmentController extends Controller
{
    public function index()
    {
        Cache::store('redis')->add(
            'departments',
            Department::query()
                ->get()
                ->toArray(),
            now()->addDays(),
        );

        return response()->json(Cache::get('departments'));
    }
}
