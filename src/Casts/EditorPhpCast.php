<?php

namespace BumpCore\EditorPhp\Casts;

use BumpCore\EditorPhp\EditorPhp;
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

        // $editorPhp = \BumpCore\EditorPhp\EditorPhp::make($value);

        // return \BumpCore\EditorPhp\EditorPhp::make($value)->setModel($model);
        return tap(
            EditorPhp::make($value),
            fn (EditorPhp $editorPhp) => $editorPhp->model = $model
        );
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
        if ($value instanceof EditorPhp)
        {
            $value->model = $model;

            return $value->toJson();
        }

        return $value;
    }
}
