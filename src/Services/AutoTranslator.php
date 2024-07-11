<?php

namespace Darko\AutoTranslate\Services;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Darko\AutoTranslate\Services\Concerns\CacheWithLanguageLine;
use Darko\AutoTranslate\Services\Concerns\CanAutoTranslateModel;
use Darko\AutoTranslate\Services\Concerns\CanAutoTranslateString;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

class AutoTranslator implements Translator
{
    use CacheWithLanguageLine, CanAutoTranslateModel, CanAutoTranslateString;

    public LoggerInterface $log;

    public function __construct()
    {
        $this->log = Log::channel(config('auto-translate.log'));
    }

    public static function base_locale(): string
    {
        return (string) config('auto-translate.base_locale', config('app.fallback_locale', 'en'));
    }

    public static function trans_locales(): array
    {
        return (array) config('auto-translate.trans_locales', []);
    }

    public function translate(string $base_value, bool $with_attributes = false): ?array
    {
        return $this->translateWithCache($base_value, $with_attributes);
    }

    public function translateString(string $base_value, string $base_locale, string $trans_locale, bool $with_attributes = true): string
    {
        if (config('auto-translate.test_mode')) {
            return "{$base_value} - {$trans_locale}";
        }

        $method = $with_attributes ? 'apiTranslateWithAttributes' : 'apiTranslate';
        $trans_value = Str::$method($base_value, $trans_locale, $base_locale);
        $this->log->info("[translate string] {$base_locale}:{$trans_locale}", [$base_value, $trans_value]);

        return $trans_value;
    }
}
