<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Purifier;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Data implements Arrayable
{
    /**
     * Raw data to  handle.
     *
     * @var array<int|string, mixed>
     */
    protected array $data;

    /**
     * Validated data to work with.
     *
     * @var array<int|string, mixed>
     */
    protected array $validatedData;

    /**
     * Rules to validate raw data.
     *
     * @var array<int, Field>
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
        $this->validatedData = $this->purify($this->validate());
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
     * Checks whether data passes the rules or not.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !Helpers::makeValidator($this->data, $this->rules)->fails();
    }

    /**
     * Validates raw data.
     *
     * @return array<int|string, mixed>
     */
    protected function validate(): array
    {
        $validator = Helpers::makeValidator($this->data, $this->mapRules());

        if ($validator->fails())
        {
            return [];
        }

        return $validator->validated();
    }

    /**
     * Purifies validated data.
     *
     * @param array $validatedData
     *
     * @return array<int|string, mixed>
     */
    protected function purify(array $validatedData)
    {
        $allows = $this->mapAllows();
        $data = Arr::dot($validatedData);

        foreach ($validatedData as $name => $data)
        {
            if (key_exists($name, $allows))
            {
                $tags = array_keys($allows[$name]);
                $data = Purifier::stripTags($data, $tags);

                foreach ($tags as $tag)
                {
                    $data = Purifier::stripAttributes($data, $tag, $allows[$name][$tag]);
                }
            }

            Arr::set($validatedData, $name, $data);
        }

        return $validatedData;
    }

    /**
     * Maps `Field` array to key value array for rules.
     *
     * @return array<string, array|string>
     */
    protected function mapRules()
    {
        $mapped = [];

        foreach ($this->rules as $rule)
        {
            $mapped[$rule->getName()] = $rule->getRules();
        }

        return $mapped;
    }

    /**
     * Maps `Field` array to key value array for tags.
     *
     * @return array<string, array>
     */
    protected function mapAllows()
    {
        $mapped = [];

        foreach ($this->rules as $rule)
        {
            if (!empty($allow = $rule->getAllow()))
            {
                $mapped[$rule->getName()] = $allow;
            }
        }

        return $mapped;
    }

    /**
     * Converts the `Data` as an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->validatedData;
    }
}
