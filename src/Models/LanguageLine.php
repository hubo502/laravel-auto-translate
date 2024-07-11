<?php
namespace Darko\AutoTranslate\Models;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\TranslationLoader\LanguageLine as Base;

class LanguageLine extends Base
{
    const CACHE_GROUP = "_cache";
    const JSON_GROUP = "_json";

    protected string $base_locale;
    protected Collection $trans_locales;

    public function __construct()
    {
        $this->base_locale = app(Translator::class)->base_locale();
        $this->trans_locales = collect(app(Translator::class)->trans_locales());
    }

    /**
     * 翻译内容
     *
     * @param boolean $force 强制模式
     * @return boolean 是否翻译成功
     */
    public function translate(bool $force = false): bool
    {

        if ($this->locales_not_translated->count() || $force) {

            $translator = app(Translator::class);

            $trans_locales = $force ? $this->trans_locales : $this->locales_not_translated;

            $trans_locales->each(function ($trans_locale) use ($translator) {
                $trans_value = $translator->translateString($this->base_value, $this->base_locale, $trans_locale);
                $this->setTranslation($trans_locale, $trans_value);
            });

            return $this->save();
        }

        return true;
    }

    /**
     * 缓存数据中是否存在basevalue
     *
     * @param string $baseValue
     * @param string|null $group
     * @return boolean
     */
    public static function baseValueInCache(string $baseValue, ?string $group = self::CACHE_GROUP): bool
    {
        $base_locale = app(Translator::class)->base_locale();
        return static::where("text->{$base_locale}", $baseValue)->whereGroup($group)->exists();
    }

    /**
     * 缓存中是否存在key
     *
     * @param string $key
     * @param string|null $group
     * @return boolean
     */
    public static function keyInCache(string $key, ?string $group = self::CACHE_GROUP): bool
    {
        return static::where('key', $key)->whereGroup($group)->exists();
    }

    public static function getByBaseValue(string $base_value, ?string $group = self::CACHE_GROUP): self | null
    {
        $key = static::composeCacheKey($base_value);
        $column = config('database.default') == 'mysql' ? DB::raw('BINARY `key`') : 'key';
        $line = static::whereGroup($group)->where($column, $key)->first();

        if (!$line) {
            $line = static::create(compact('group', 'key') + ['text' => [app(Translator::class)->base_locale() => $base_value]]);
        }

        return $line;
    }

    /**
     * 完全翻译
     *
     * 是否所有的locale都翻译过了,因为key/text[base_locale]不会变更,所以不存在更新的情况
     *
     * @return boolean
     */
    public function translateCompleted(): bool
    {
        return $this->hasBaseValue() && $this->locales_not_translated->isEmpty();
    }

    /**
     * Text太长会进行md5编码
     *
     * @param string $text
     * @return string
     */
    public static function composeCacheKey(string $text): string
    {
        return strlen($text) > 255 ? md5($text) : $text;
    }

    public function getBaseValueAttribute(): mixed
    {
        return $this->getTranslation($this->base_locale);
    }

    public function hasBaseValue(): bool
    {
        return !empty($this->base_value);
    }

    public function getDefaultBaseValueAttribute(): array
    {
        return [$this->base_locale => null];
    }

    /**
     * 获取没有翻译的locale
     *
     * @return Collection
     */
    public function getLocalesNotTranslatedAttribute(): Collection
    {
        return $this->trans_locales->filter(fn($locale) => empty($this->text[$locale]));
    }
}
