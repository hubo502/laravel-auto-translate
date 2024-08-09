# laravel auto translate

用于自动翻译数据

## Installation

You can install the package via composer:

```bash
composer require xdarko/laravel-auto-translate
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-auto-translate-migrations"
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-auto-translate-config"
```

This is the contents of the published config file:

```php
return [
    'test_mode' => false,//just for test.(won't query translate api,just fake translation)
    'log' => 'default',//log channel
    'base_locale' => 'en',
    'trans_locales' => ['fr', 'es', 'ja', 'it', 'pt'],
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-auto-translate-views"
```

## Usage

```php

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Models\Traits\HasAutoTranslate;
use Illuminate\Database\Eloquent\Model;

class AutoTranslateModel extends Model implements AutoTranslatable{
    use HasAutoTranslatable;

    public $translatable = ['title', 'content', 'blocks', 'desc'];//fields can be translated
    public $json_translatable = ['title', 'description'];//fields in json keys can be translated

}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Boris Hu](https://github.com/hubo502)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
