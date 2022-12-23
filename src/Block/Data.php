<?php

namespace BumpCore\EditorPhp\Block;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;

class Data implements Arrayable, Jsonable
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
     * Gets data by given key.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function __invoke(string $key, mixed $default = null): mixed
    {
        return $this->get($key, $default);
    }

    /**
     * Gets data by given key.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Sets a data by given key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        Arr::set($this->data, $key, $value);
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
