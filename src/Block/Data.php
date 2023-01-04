<?php

namespace BumpCore\EditorPhp\Block;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Data implements Arrayable
{
    /**
     * Raw data to  handle.
     *
     * @var array
     */
    protected array $data;

    /**
     * Validated data to work with.
     *
     * @var array
     */
    protected array $validatedData;

    /**
     * Rules to validate raw data.
     *
     * @var array
     */
    protected array $rules;

    /**
     * Constructor.
     *
     * @param array $data
     * @param array $rules
     *
     * @return void
     */
    public function __construct(array $data = [], array $rules = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validatedData = $this->validate();
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
        return Arr::get($this->validatedData, $key, $default);
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
        Arr::set($this->validatedData, $key, $value);
    }

    /**
     * Converts the `Data` as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->validatedData;
    }

    /**
     * Checks whether data passes the rules or not.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !Validator::make($this->data, $this->rules)->fails();
    }

    /**
     * Validates raw data.
     *
     * @return array
     */
    protected function validate(): array
    {
        $validator = Validator::make($this->data, $this->rules);

        if ($validator->fails())
        {
            return [];
        }

        return $validator->validated();
    }
}
