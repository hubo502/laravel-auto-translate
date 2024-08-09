<?php

namespace Darko\AutoTranslate\Tests;

use Darko\AutoTranslate\AutoTranslateServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Darko\\AutoTranslate\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AutoTranslateServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $locales = [
            'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
            'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
            'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
            'ja' => ['name' => 'Japanese', 'script' => 'Jpan', 'native' => '日本語', 'regional' => 'ja_JP'],
        ];

        config()->set('database.default', 'testing');
        config()->set('auto-translate.base_locale', 'en');
        config()->set('auto-translate.test_mode', true);
        config()->set('auto-translate.locales', $locales);

        $migration = include __DIR__.'/database/migrations/create_test_table.php';
        $migration->up();
    }
}
