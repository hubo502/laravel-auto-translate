<?php
namespace Darko\AutoTranslate\Contracts\Services;

use Illuminate\Database\Eloquent\Model;

interface Translator
{
    public static function base_locale(): string;
    public static function trans_locales(): array;
    public function translate(string $text, bool $with_attributes = false): array | null;
    public function translateString(string $base_value, string $base_locale, string $trans_locale, bool $with_attributes = true): string;
    public function translateModel(Model $model, bool $force = false): mixed;
}
