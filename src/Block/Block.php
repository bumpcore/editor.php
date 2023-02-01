<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Parser;
use Illuminate\Contracts\Support\Arrayable;

abstract class Block implements Arrayable
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
     * Rules to validate data of the block.
     *
     * @return array<int, Field>
     */
    public abstract function rules(): array;

    /**
     * Render's the block.
     *
     * @return string
     */
    public abstract function render(): string;

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
        $this->type = Parser::resolveType(self::class);
        $this->root = $root;
        $this->data = new Data($data, $this->rules());
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
    public function __toString(): string
    {
        return $this->render();
    }
}
