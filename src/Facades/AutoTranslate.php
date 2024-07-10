<?php

namespace Darko\AutoTranslate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Darko\AutoTranslate\AutoTranslate
 */
class AutoTranslate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Darko\AutoTranslate\AutoTranslate::class;
    }
}
