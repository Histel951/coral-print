<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ComponentsController extends Controller
{
    public function components(): View
    {
        return view('components');
    }
}
