<?php

use App\Models\Tooltip;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Tooltip::query()->create([
            'name' => 'Объемные наклейки',
            'type' => 'short',
            'content' => <<<CONTENT
                    <div class="tooltip_img">
                    <img src = "">
                    </div>
                    <div class="tooltip_header">Объемные наклейки</div>
                    <div class="tooltip_text">Наклейки покрываются эпоксидной смолой средней жесткости
                    </div>
      CONTENT,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Tooltip::where('name', 'Объемные наклейки')->delete();
    }
};
