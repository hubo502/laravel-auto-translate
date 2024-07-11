<?php

namespace Darko\AutoTranslate\Exceptions;

use Exception;

class TranslateException extends Exception
{
    public static function BaseValueEmpty()
    {
        return new self('待翻译文本不能为空');
    }

    public static function ModelNotTranslatable()
    {
        return new self('当前Model不可翻译');
    }
}
