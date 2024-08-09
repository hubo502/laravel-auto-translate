<?php

namespace Darko\AutoTranslate\Facades;

use Darko\AutoTranslate\Contracts\Services\Translator;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Darko\AutoTranslate\AutoTranslate
 */
class AutoTranslator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Translator::class;
    }
}
