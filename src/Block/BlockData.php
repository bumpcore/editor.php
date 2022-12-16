<?php

namespace BumpCore\EditorPhp\Block;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;

class BlockData implements Arrayable, Jsonable
{
    /**
     * Data to work with.
     *
     * @var array
     */
    protected array $data;

    /**
     * Constructor.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets or if provided sets the data.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function __invoke(string $key, mixed $value = null): mixed
    {
        if (empty($value))
        {
            return Arr::get($this->data, $key);
        }

        Arr::set($this->data, $key, $value);

        return $this($key);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
