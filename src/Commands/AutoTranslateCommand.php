<?php

namespace Darko\AutoTranslate\Commands;

use Illuminate\Console\Command;

class AutoTranslateCommand extends Command
{
    public $signature = 'laravel-auto-translate';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
