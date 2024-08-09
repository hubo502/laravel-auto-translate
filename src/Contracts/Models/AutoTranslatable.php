<?php

namespace Darko\AutoTranslate\Contracts\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

interface AutoTranslatable
{
    public function autoTranslate(bool $force = false): bool;
}
