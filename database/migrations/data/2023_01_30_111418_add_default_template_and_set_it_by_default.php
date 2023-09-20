<?php

use App\Models\Pages\PageTemplate;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();
        try {
            $pageTemplate = PageTemplate::create([
                'alias' => 'default',
                'name' => 'Стандартный',
                'template' => <<<'TEMP'
    @include('partials.breadcrumbs')

    <section class="section-product">
        @if($content->calculators->count())
            @include('partials.sections.calcs', ['types' => $types])
        @else
            @includeWhen((!$content->is_folder || $isEmptyFolder), 'partials.sections.product_internal')
            @includeUnless((!$content->is_folder || $isEmptyFolder), 'partials.sections.product')
        @endif
    </section>

    <section>
        @include('partials.sections.examples')
    </section>

    <section class="section-advantages">
        @include('partials.sections.advantages', [
            'advantages' => $advantages
        ])
    </section>

    <section class="prod-reviews-section">
        @include('partials.sections.reviews')
    </section>

    <section>
        @include('partials.sections.seo')
    </section>

    <section>
        @include('partials.sections.payment_delivery')
    </section>
TEMP,
            ]);

            DB::table('contents')
                ->whereRaw('1=1')
                ->update(['page_template_id' => $pageTemplate->id]);

            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
};
