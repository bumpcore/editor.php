<?php

namespace BumpCore\EditorPhp\Block;

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
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->type = Parser::resolveType(self::class);
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
