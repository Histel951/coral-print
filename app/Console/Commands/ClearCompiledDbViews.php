<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCompiledDbViews extends Command
{
    protected $signature = 'view:clear-compiled';

    protected $description = 'Clear files with compiled DB views from storage';

    public function handle()
    {
        try {
            $compiledViews = \Storage::disk('local')->allFiles('db-blade-compiler');
            unset($compiledViews[0]);

            foreach ($compiledViews as $compiledView) {
                if (!\Storage::disk('local')->delete($compiledView)) {
                    throw new \Exception("No such file: {$compiledView}");
                }
            }

            $this->info('Successfully cleared!');
        } catch (\Exception $e) {
            $this->error("Failed to clear: {$e->getMessage()}");
        }
    }
}
