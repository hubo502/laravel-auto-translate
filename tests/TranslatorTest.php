<?php

use Darko\AutoTranslate\Contracts\Services\Translator;
use Darko\AutoTranslate\Exceptions\TranslateException;
use Darko\AutoTranslate\Facades\AutoTranslator;
use Darko\AutoTranslate\Models\LanguageLine;

beforeEach(function () {
    $this->translator = app(Translator::class);
});

it('facade works fine', function () {
    $locale = AutoTranslator::base_locale();
    expect($locale)->toBe(config('auto-translate.base_locale'));
});

it('has base locale', function () {
    $base_locale = $this->translator->base_locale();
    expect($base_locale)->toBe(config('auto-translate.base_locale'));
});

it('has locale options', function () {
    $options = $this->translator->locale_options();
    expect($options['fr'])->toBe('français');
});

it('has locales', function () {
    $locales = $this->translator->locales();
    expect($locales)->toContain('en', 'es', 'fr', 'ja');
});

it('has trans locales', function () {
    $trans_locales = $this->translator->trans_locales();
    expect($trans_locales)->toContain('es', 'fr', 'ja');
});

it("has trans locale label", function () {
    $label = $this->translator->localeLabel('fr');
    $native = $this->translator->localeLabel('fr', native: true);
    $nullLabel = $this->translator->localeLabel('hello');

    expect($nullLabel)->toBeNull();
    expect($label)->toBe("French");
    expect($native)->toBe("français");
});

it('don\'t translate empty base value', function () {
    $this->translator->translate('');
})->throws(TranslateException::class);

it('caches language line', function () {
    $this->translator->translate('hello');
    expect(LanguageLine::keyInCache('hello'))->toBe(true);
    expect(LanguageLine::baseValueInCache('hello'))->toBe(true);
    expect(LanguageLine::getByBaseValue('hello')->translateCompleted())->toBe(true);
});
