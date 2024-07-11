<?php

namespace Darko\AutoTranslate;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Darko\AutoTranslate\Services\AutoTranslator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AutoTranslateServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton(Translator::class, function () {
            return new AutoTranslator();
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-auto-translate')
            ->hasConfigFile();
    }
}
