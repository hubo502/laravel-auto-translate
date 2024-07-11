<?php

namespace Darko\AutoTranslate\Contracts\Models;

interface AutoTranslatable
{
    public function autoTranslate(bool $force = false): bool;
}
