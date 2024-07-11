<?php

use Darko\AutoTranslate\Contracts\Services\Translator;
use Darko\AutoTranslate\Exceptions\TranslateException;
use Darko\AutoTranslate\Models\LanguageLine;

beforeEach(function () {
    $this->translator = app(Translator::class);
});

it('has base locale', function () {
    $base_locale = $this->translator->base_locale();
    expect($base_locale)->toBe(config('auto-translate.base_locale'));
});

it('has trans locales', function () {
    $trans_locales = $this->translator->trans_locales();
    expect($trans_locales)->toBe(config('auto-translate.trans_locales'));
});

it('don\'t translate empty base value', function () {
    $this->translator->translate('');
})->throws(TranslateException::class);

it('caches language line', function () {
    $this->translator->translate("hello");
    expect(LanguageLine::keyInCache('hello'))->toBe(true);
    expect(LanguageLine::baseValueInCache('hello'))->toBe(true);
    expect(LanguageLine::getByBaseValue('hello')->translateCompleted())->toBe(true);
});
