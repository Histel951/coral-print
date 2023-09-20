<?php

use App\Models\Calculator;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $symbols = [];

        // calculator previews
        $allCalculators = Calculator::with(['image'])->get();

        $allCalculators->each(function (Calculator $calculator) use (&$symbols): void {
            if (!$calculator->image) {
                return;
            }

            $pathToFile = public_path("storage/{$calculator->image->path}{$calculator->image->name}.svg");

            if (!file_exists($pathToFile)) {
                return;
            }

            $content = File::get($pathToFile);
            $symbolId = $this->getSymbolId($calculator->image->original_name);
            $content = $this->setSymbol($content, $symbolId);

            $svg = new DOMDocument();
            $svg->loadHTML($content, LIBXML_NOERROR);

            $gradientValues = [];
            foreach ($svg->getElementsByTagName('symbol') as $tag) {
                foreach ($tag->getElementsByTagName('defs')->item(0)->childNodes as $defsTag) {
                    if ($defsTag->nodeName === 'lineargradient') {
                        $gradientValues[$defsTag->attributes->getNamedItem('id')->nodeValue.'-'.$symbolId] = $defsTag->attributes->getNamedItem('id')->nodeValue;
                    }
                }
            }

            foreach ($gradientValues as $newGradientId => $oldGradientId) {
                $content = Str::replace($oldGradientId, $newGradientId, $content);
            }

            $symbols[] = $content;

            $calculator->update([
                'svg_id' => $symbolId
            ]);
        });

        $allPreviews = Preview::with(['previewImage'])->get();

        $allPreviews->each(function (Preview $preview) use (&$symbols): void {
            if (!$preview->preview_image) {
                return;
            }

            $pathToFile = public_path("storage/{$preview->preview_image->path}{$preview->preview_image->name}.svg");

            if (!file_exists($pathToFile)) {
                return;
            }

            $content = File::get($pathToFile);
            $symbolId = $this->getSymbolId($preview->preview_image->original_name);
            $content = $this->setSymbol($content, $symbolId);

            $symbols[] = $content;

            $preview->update([
                'svg_id' => $symbolId
            ]);
        });

        $symbolsResultString = '';
        foreach ($symbols as $symbol) {
            $symbolsResultString .= "
{$symbol}
            ";
        }

        $spriteSvgContent = File::get(public_path('images/sprite.svg'));

        $spriteSvgContent = Str::replace('</svg>', '', $spriteSvgContent);
        $spriteSvgContent .= $symbolsResultString;
        $spriteSvgContent .= '
</svg>
        ';

        File::replace(public_path('images/sprite.svg'), $spriteSvgContent);
    }

    private function setSymbol(string $content, string $symbolId): string
    {
        $content = preg_replace('/<svg width="\d+" height="\d+"/', '<svg ', $content);
        $content = Str::replace('<svg', '<symbol', $content);
        $content = Str::replace('</svg', '</symbol', $content);
        $content = Str::replace('<stop stop-color', '<stop offset="0" stop-color', $content);
        $content = preg_replace('/xmlns="(.*?)"/', '', $content);

        return Str::replace('<symbol', "<symbol id=\"{$symbolId}\"", $content);
    }

    private function getSymbolId(string $originalName): string
    {
        $symbolId = preg_replace('/.svg/', '', $originalName);
        $symbolId = Str::replace('&', '-', $symbolId);
        $symbolId = preg_replace('/\s+/u', '-', $symbolId);
        $symbolId = preg_replace('/\(/u', 'a', $symbolId);
        $symbolId = preg_replace('/\)/u', 'b', $symbolId);

        return strtolower($symbolId);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
