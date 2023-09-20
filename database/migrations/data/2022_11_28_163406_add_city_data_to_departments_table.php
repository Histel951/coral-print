<?php

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            if ($department->city === null) {
                $department->city = explode(',', $department->address)[0];
                $department->save();
            }
        }
    }
};
