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
            fn(string $modelName) => 'Darko\\AutoTranslate\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
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
        config()->set('database.default', 'testing');
        config()->set('auto-translate.base_locale', 'en');
        config()->set('auto-translate.test_mode', true);
        config()->set('auto-translate.trans_locales', ['fr', 'es', 'ja']);

        $migration = include __DIR__ . '/database/migrations/create_test_table.php';
        $migration->up();

    }
}
