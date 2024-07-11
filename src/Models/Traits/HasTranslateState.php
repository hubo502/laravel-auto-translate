<?php

namespace Darko\AutoTranslate\Models\Traits;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;

trait HasTranslateState
{
    protected function transRate(): Attribute
    {
        return Attribute::make(get: fn () => $this->calcTransRate())->shouldCache();
    }

    protected function transRateLabel(): Attribute
    {
        return Attribute::make(get: fn () => $this->transRate * 100 .'%')->shouldCache();
    }

    public function calcTransRate(): float
    {
        //总待翻译项目（可翻译字段数 * locales）
        $total = $this->getTransFieldsHasBaseValue()->count() * count($this->translatable);

        //缺失项目（有basevalue的字段数 * 缺失项目）
        $missing = $this->getTransFieldsHasBaseValue()->sum(function ($field) {
            return $this->getTransFieldEmptyLocales($field)->count();
        });

        return round(1 - $missing / $total, 2);
    }

    /**
     * 获取字段的源值
     */
    public function getTransFieldBaseValue(string $field): mixed
    {
        return $this->getTranslation($field, app(Translator::class)->base_locale());
    }

    /**
     * 获取源值不为空的fields
     */
    public function getTransFieldsHasBaseValue(): Collection
    {
        return collect($this->translatable)->filter(function ($field) {
            return ! empty($this->getTransFieldBaseValue($field));
        });
    }

    public function getFieldsShouldTranslate(bool $force = false): Collection
    {
        return $this->getTransFieldsHasBaseValue()->filter(function ($field) use ($force) {
            return $force || $this->shouldTranslateField($field);
        });
    }

    public function shouldTranslateField(string $field): bool
    {
        return $this->getTransFieldEmptyLocales($field)->count() > 0 || $this->isJsonField($field);
    }

    /**
     * 查看哪些locale翻译内容缺失
     */
    public function getTransFieldEmptyLocales(string $field): Collection
    {
        //目标语言
        $locales = collect(app(Translator::class)->trans_locales());

        //当前翻译内容
        $translations = $this->getTranslations($field);

        //源值
        $baseValue = $this->getTransFieldBaseValue($field);

        //缓存没有这个源值，则表示之前没翻译过
        // if (!app(Translator::class)->hasCache($baseValue)) {
        //     return $locales;
        // }

        //返回缺失内容的locales
        return $locales->filter(function ($locale) use ($translations) {
            return empty($translations[$locale]);
        });
    }

    public function isJsonField(string $field): bool
    {
        return is_array($this->$field);
    }
}
