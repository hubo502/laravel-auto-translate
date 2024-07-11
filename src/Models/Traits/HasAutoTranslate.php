<?php

namespace Darko\AutoTranslate\Models\Traits;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property array $translatable
 * @property array $json_translatable
 */
trait HasAutoTranslate
{
    use HasTranslateState, HasTranslations;

    public function autoTranslate(bool $force = false): bool
    {
        $this->getFieldsShouldTranslate($force)->each(function ($field) use ($force) {
            $this->autoTranslateField($field, $force);
        });

        return true;
    }

    protected function autoTranslateField(string $field, bool $force = false): void
    {
        $log = app(Translator::class)->log;

        if ($this->isJsonField($field)) {
            $log->info('[auto translate field]:json', compact('field', 'force'));
            $this->autoTranslateJsonField($field, $force);
        } else {
            $log->info('[auto translate field]:text', compact('field', 'force'));
            $this->autoTranslateTextField($field, $force);
        }

    }

    protected function autoTranslateJsonField(string $field, bool $force = false): void
    {
        $base_value_json = $this->getTransFieldBaseValue($field);
        $trans_value_json = [];

        collect($base_value_json)->dot()->each(function ($base_value, $json_field) use (&$trans_value_json) {

            $trans_locales = collect(app(Translator::class)->trans_locales());

            if ($this->shouldTranslateJsonField($json_field) && ! empty($base_value)) {
                $translations = app(Translator::class)->translate($base_value);
            } else {
                $translations = $trans_locales
                    ->mapWithKeys(function ($trans_locale) use ($base_value) {
                        return [$trans_locale => $base_value];
                    });
            }

            $trans_locales->each(function ($trans_locale) use ($translations, &$trans_value_json, $json_field) {
                $trans_value_json["{$trans_locale}.{$json_field}"] = $translations[$trans_locale] ?? null;
            });
        });

        $trans_value_json = collect($trans_value_json)->undot()->toArray();
        $this->setTranslations($field, $trans_value_json);
    }

    protected function shouldTranslateJsonField(string $key): bool
    {
        return Str::of(preg_replace('/\.\d+/', '', $key))->contains($this->json_translatable);
    }

    protected function autoTranslateTextField(string $field, bool $force = false): void
    {
        $base_value = $this->getTransFieldBaseValue($field);
        $translations = app(Translator::class)->translate($base_value);
        $this->setTranslations($field, $translations);
    }
}
