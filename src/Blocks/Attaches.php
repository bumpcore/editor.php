<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\BlockData;
use BumpCore\EditorPhp\Contracts\Provider;

class Attaches implements Provider
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'attaches';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'file.url' => 'url',
            'file.size' => 'numeric',
            'file.name' => 'string',
            'file.extension' => 'string',
        ];
    }

    /**
     * Renderer for the block.
     *
     * @param BlockData $data
     *
     * @return string
     */
    public function render(BlockData $data): string
    {
        return view('editor.php::attaches')
            ->with(compact('data'))
            ->render();
    }
}
