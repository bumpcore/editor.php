<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Parser;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;

abstract class Block implements Arrayable, Htmlable, Renderable
{
    /**
     * Type of the block.
     *
     * @var string
     */
    public string $type;

    /**
     * Data of the block.
     *
     * @var Data
     */
    public readonly Data $data;

    /**
     * Belonging EditorPhp instance.
     *
     * @var EditorPhp|null
     */
    protected ?EditorPhp $root;

    /**
     * Render's the block.
     *
     * @return string
     */
    public abstract function render(): string;

    /**
     * Fluent method to create new `Block` instance.
     *
     * @param array $data
     * @param EditorPhp|null $root
     *
     * @return self
     */
    public static function make(array $data = [], ?EditorPhp &$root = null): self
    {
        return new static($data, $root);
    }

    /**
     * Constructor.
     *
     * @param array $data
     * @param EditorPhp|null $root
     *
     * @return void
     */
    public function __construct(array $data = [], ?EditorPhp &$root = null)
    {
        $this->type = array_flip(Parser::$blocks)[static::class];
        $this->root = $root;
        $this->data = new Data($data, $this->allows(), $this->rules());
    }

    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array|string
    {
        return '*';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Gets block data by given key.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data->get($key, $default);
    }

    /**
     * Sets block data by given key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $key, mixed $value): self
    {
        $this->data->set($key, $value);

        return $this;
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
        return $this->data->has($key);
    }

    /**
     * Converts the `Block` as an array.
     *
     * @return array<string, array|string>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data->toArray(),
        ];
    }

    /**
     * Renders block into HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * Renders block into HTML.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
