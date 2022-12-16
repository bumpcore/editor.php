<?php

namespace BumpCore\EditorPhp\Block;

use BumpCore\EditorPhp\Contracts\Block as Provider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Validator;

class Block implements Arrayable, Jsonable
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
     * @var BlockData
     */
    public readonly BlockData $data;

    /**
     * Constructor.
     *
     * @param Provider $provider
     * @param array $data
     *
     * @return void
     */
    public function __construct(Provider $provider, array $data)
    {
        $this->provider = $provider;
        $this->type = $provider->type();
        $this->data = new BlockData($this->validateData($data));
    }

    /**
     * Validates block data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function validateData(array $data): array
    {
        $validator = Validator::make($data, $this->provider->rules());

        if ($validator->fails())
        {
            return [];
        }

        return $validator->validated();
    }

    /**
     * Converts block into array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data->toArray(),
        ];
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

    /**
     * Renders block.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Renders block.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->provider->render($this->data);
    }
}
