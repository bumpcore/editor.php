<?php

namespace BumpCore\EditorPhp\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class EditorPhpCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param string|null $value
     * @param array $attributes
     *
     * @return \BumpCore\EditorPhp\EditorPhp|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value))
        {
            return $value;
        }

        return \BumpCore\EditorPhp\EditorPhp::make($value)->setModel($model);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof \BumpCore\EditorPhp\EditorPhp)
        {
            return $value->setModel($model)->toJson();
        }

        return $value;
    }
}
