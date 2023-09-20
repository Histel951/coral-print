<?php

use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        $ids = [10, 11, 12, 13, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29];

        foreach ($ids as $id) {
            $color = Color::find($id);
            $color->name = str_replace('ие', 'яя', $color->name);
            $color->name = str_replace('ые', 'ая', $color->name);

            $color->save();
        }
    }
};
