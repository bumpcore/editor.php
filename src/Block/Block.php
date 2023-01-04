<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\Contracts\Provider;
use Illuminate\Contracts\Support\Arrayable;

class Block implements Arrayable
{
    /**
     * Provider of the block.
     *
     * @var Provider
     */
    protected readonly Provider $provider;

    /**
     * Type of the block.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Data of the block.
     *
     * @var Data
     */
    public readonly Data $data;

    /**
     * Constructor.
     *
     * @param Provider $provider
     * @param array $data
     *
     * @return void
     */
    public function __construct(string $type, Provider $provider, array $data)
    {
        $this->provider = $provider;
        $this->type = $type;
        $this->data = new Data($data, $provider->rules());
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

    /**
     * Renders block into HTML.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->provider->render($this->data);
    }
}
