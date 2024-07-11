<?php

namespace Darko\AutoTranslate\Services\Concerns;

use Illuminate\Support\Str;

/**
 * @mixin \Darko\AutoTranslate\Contracts\Translator
 *
 * @property \Psr\Log\LoggerInterface $log
 */
trait CanAutoTranslateString
{
    public function translateString(string $text, string $from_locale, string $locale, bool $with_attributes = true): string
    {
        $method = $with_attributes ? 'apiTranslateWithAttributes' : 'apiTranslate';
        $result = Str::$method($text, $locale, $from_locale);
        $this->log->info("[translate string] {$from_locale}:{$locale}", [$text, $result]);

        return $result;
    }
}
