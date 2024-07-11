<?php

namespace Darko\AutoTranslate\Services\Concerns;

use Darko\AutoTranslate\Exceptions\TranslateException;
use Darko\AutoTranslate\Models\LanguageLine;

trait CacheWithLanguageLine
{
    public function translateWithCache(string $base_value): ?array
    {
        if (empty($base_value)) {
            throw TranslateException::BaseValueEmpty();
        }

        $line = LanguageLine::getByBaseValue($base_value);

        $line->translateCompleted() ?
        $this->log->info('[translate with cache]', ['key' => $line->key]) :
        $line->translate();

        return $line->text;

    }
}
