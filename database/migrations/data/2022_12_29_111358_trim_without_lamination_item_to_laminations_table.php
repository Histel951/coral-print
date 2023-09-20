<?php

use App\Models\Lamination;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        $model = Lamination::find(111);
        $model->name = trim($model->name);
        $model->save();
    }
};
