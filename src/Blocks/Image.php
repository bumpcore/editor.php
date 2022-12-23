<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\BlockData;
use BumpCore\EditorPhp\Contracts\Provider;

class Image implements Provider
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'image';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file.url' => 'url',
            'caption' => 'string',
            'withBorder' => 'boolean',
            'stretched' => 'boolean',
            'withBackground' => 'boolean',
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
        return view('editor.php::image')
            ->with(compact('data'))
            ->render();
    }
}
