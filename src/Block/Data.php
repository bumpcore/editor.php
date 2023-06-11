<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Purifier;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class Data implements Arrayable
{
    /**
     * Validated data to work with.
     *
     * @var array<int|string, mixed>
     */
    protected array $data;

    /**
     * Constructor.
     *
     * @param array $data
     * @param array|string $allows
     * @param array $rules
     *
     * @return void
     */
    public function __construct(array $data = [], array|string $allows = '*', array $rules = [])
    {
        $this->data = $this->purify(
            $this->validate($data, $rules),
            $allows,
        );
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
     * Check if an item or items exist in the data.
     *
     * @param array|string $key
     *
     * @return bool
     */
    public function has(string|array $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Validates raw data.
     *
     * @return array<int|string, mixed>
     */
    protected function validate(array $data, array $rules): array
    {
        $validator = Helpers::makeValidator($data, $rules);

        if ($validator->fails())
        {
            return [];
        }

        return $validator->validated();
    }

    /**
     * Purifies validated data.
     *
     * @param array $data
     * @param array|string $allows
     *
     * @return array<int|string, mixed>
     */
    protected function purify(array $data, array|string $allows)
    {
        // Allows all tags and attributes for all fields.
        if ($allows === '*')
        {
            return $data;
        }

        $allows = $this->parseAllows($allows);
        $data = Arr::dot($data);

        foreach ($data as $key => $value)
        {
            if (!is_string($value))
            {
                continue;
            }

            // Find matching key E.g. `content*.*.text` = `content.1.5.text`
            $allow = Arr::first(Arr::where(
                $allows,
                // Below regex taken from `https://github.com/laravel/framework/blob/46ac3ec77ed4b07e3c6e47f97979822696bb7f1d/src/Illuminate/Validation/ValidationData.php#L57`
                fn ($tags, $attribute) => (bool) preg_match('/^' . str_replace('\*', '[^\.]+', preg_quote($attribute)) . '/', $key, $matches)
            ));

            if ($allow)
            {
                // Allows all tags and attributes for field.
                if ($allow === '*')
                {
                    continue;
                }

                $tags = array_keys($allow);

                $purified = Purifier::stripTags($value, $tags);

                foreach ($tags as $tag)
                {
                    $attributes = $allow[$tag];

                    // Allows all attributes.
                    if (Arr::first($attributes) === '*')
                    {
                        continue;
                    }

                    $purified = Purifier::stripAttributes($purified, $tag, $attributes);
                }

                $data[$key] = $purified;
            }
        }

        return Arr::undot($data);
    }

    /**
     * Parses following syntax: `a:href,class,title`.
     *
     * @param array $allows
     *
     * @return array
     */
    protected function parseAllows(array $allows): array
    {
        return Arr::map($allows, function(array|string $tags) {
            if ($tags === '*')
            {
                return $tags;
            }

            $tags = Arr::wrap($tags);

            $parsed = [];

            foreach ($tags as $allow)
            {
                $allow = explode(':', $allow);

                // First key is tag.
                $tag = Arr::first(array_slice($allow, 0, 1));

                // Second key is attributes.
                $attributes = array_filter(explode(
                    ',',
                    Arr::first(array_slice($allow, 1, 2), null, '')
                ));

                $parsed[$tag] = $attributes;
            }

            return $parsed;
        });
    }

    /**
     * Converts the `Data` as an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
