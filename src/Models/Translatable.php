<?php

namespace Darko\AutoTranslate\Models;

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Models\Traits\HasAutoTranslate;
use Illuminate\Database\Eloquent\Model;

abstract class Translatable extends Model implements AutoTranslatable
{
    use HasAutoTranslate;
}
