<?php

namespace BumpCore\EditorPhp;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

/**
 * Class Block.
 *
 * This class is building block for EditorPhp. It provides functionality to interact and manipulate block data.
 */
abstract class Block implements Arrayable, Htmlable, Renderable
{
    /**
     * Type of the block.
     *
     * @var string
     */
    protected string $type;

    /**
     * Data of the block.
     *
     * @var array
     */
    protected array $data;

    /**
     * Belonging EditorPhp instance.
     *
     * @var EditorPhp|null
     */
    protected ?EditorPhp $parent;

    /**
     * Render's the block.
     *
     * @return string
     */
    public abstract function render(): string;

    /**
     * Fluent method to create new `Block` instance.
     *
     * @param array $data The data of the block.
     * @param EditorPhp|null $parent The parent instance.
     *
     * @return self The new instance of `Block`.
     */
    public static function make(array $data = [], ?EditorPhp &$parent = null): self
    {
        return new static($data, $parent);
    }

    /**
     * Constructor.
     *
     * @param array $data The data of the block.
     * @param EditorPhp|null $parent The parent instance.
     *
     * @return void
     */
    public function __construct(array $data = [], ?EditorPhp &$parent = null)
    {
        $this->type = Registry::getBlockTypeByClass(static::class);
        $this->parent = $parent;
        $this->data = (new Sanitizer($this->validateData($data, $this->rules()), $this->sanitize()))->sanitize();
    }

    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string The rules to sanitize data.
     */
    public function sanitize(): array|string
    {
        return '*';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array<string, mixed> The rules to validate data.
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Gets block data by given key.
     *
     * @param string $key The key of the data.
     * @param mixed $default The default value if key doesn't exist.
     *
     * @return mixed The value of the data.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Sets block data by given key.
     *
     * @param string $key The key of the data.
     * @param mixed $value The value of the data.
     *
     * @return $this The current instance of `Block`.
     */
    public function set(string $key, mixed $value): self
    {
        Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * Check if an item or items exist in the data.
     *
     * @param array|string $key The key of the data.
     *
     * @return bool True if the item or items exist, false otherwise.
     */
    public function has(string|array $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Returns array of specified keys.
     *
     * @param mixed $keys The keys to return.
     *
     * @return array The array of specified keys.
     */
    public function only($keys): array
    {
        return Arr::only($this->data, is_array($keys) ? $keys : func_get_args());
    }

    /**
     * Returns given property.
     *
     * @param string $name The name of the property.
     *
     * @return mixed The value of the property.
     */
    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    /**
     * Checks if given property exists.
     *
     * @param string $name The name of the property.
     *
     * @return bool True if the property exists, false otherwise.
     */
    public function __isset(string $name): bool
    {
        return $this->has($name);
    }

    /**
     * Sets given property.
     *
     * @param string $name The name of the property.
     * @param mixed $value The value of the property.
     *
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->set($name, $value);
    }

    /**
     * Unsets given property.
     *
     * @param string $name The name of the property.
     *
     * @return void
     */
    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    /**
     * Validates raw data.
     *
     * @return array<int|string, mixed> The validated data.
     */
    protected function validateData(array $data, array $rules): array
    {
        if ($rules === [])
        {
            return $data;
        }

        $validator = Helpers::makeValidator($data, $rules);

        if ($validator->fails())
        {
            return [];
        }

        return $validator->validated();
    }

    /**
     * Converts the `Block` as an array.
     *
     * @return array<string, array|string> Array representation of the `Block`.
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }

    /**
     * Renders block into HTML.
     *
     * @return string Rendered HTML.
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * Renders block into HTML.
     *
     * @return string Rendered HTML.
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
