<?php

namespace Darko\AutoTranslate\Models\Traits;

use Spatie\Translatable\HasTranslations;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property array $translatable
 * @property array $json_translatable
 */
trait HasAutoTranslate
{
    use HasTranslations, JustAutoTranslate;
}
