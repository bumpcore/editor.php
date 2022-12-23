<?php

namespace BumpCore\EditorPhp\Contracts;

use BumpCore\EditorPhp\Block\BlockData;

interface Provider
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string;

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Renderer for the block.
     *
     * @param BlockData $data
     *
     * @return string
     */
    public function render(BlockData $data): string;
}
