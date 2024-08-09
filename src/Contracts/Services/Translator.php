<?php

namespace Darko\AutoTranslate\Contracts\Services;

use Illuminate\Database\Eloquent\Model;

interface Translator
{
    public  function base_locale(): string;

    public  function locales(): array;

    public  function trans_locales(): array;

    public function locale_options(): array;

    public function localeLabel(string $locale, bool $native = false): ?string;

    public function translate(string $text, bool $with_attributes = false): ?array;

    public function translateString(string $base_value, string $base_locale, string $trans_locale, bool $with_attributes = true): string;

    public function translateModel(Model $model, bool $force = false): mixed;
}
