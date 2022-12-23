<?php

namespace BumpCore\EditorPhp\Contracts;

use BumpCore\EditorPhp\Block\Data;

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
     * @param Data $data
     *
     * @return string
     */
    public function render(Data $data): string;
}
