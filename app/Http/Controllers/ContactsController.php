<?php

namespace App\Http\Controllers;

use App\Models\CommonSetting;
use App\Models\Department;
use Illuminate\Contracts\View\View;

class ContactsController extends Controller
{
    public function contacts(): View
    {
        return view('contacts', [
            'settings' => CommonSetting::first(),
            'departments' => Department::with('images')->get(),
        ]);
    }
}
