<?php
namespace Darko\AutoTranslate\Services\Concerns;

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Exceptions\TranslateException;
use Illuminate\Database\Eloquent\Model;

trait CanAutoTranslateModel
{
    public function translateModel(Model $model, bool $force = false): mixed
    {
        if ($model instanceof AutoTranslatable) {
            return $model->autoTranslate($force);
        }
        throw TranslateException::ModelNotTranslatable();
    }
}
