<?php

namespace Darko\AutoTranslate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Darko\AutoTranslate\Commands\AutoTranslateCommand;

class AutoTranslateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-auto-translate')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-auto-translate_table')
            ->hasCommand(AutoTranslateCommand::class);
    }
}
