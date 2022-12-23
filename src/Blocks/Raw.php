<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Contracts\Block;

class Raw implements Block
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'raw';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'html' => 'string',
        ];
    }

    /**
     * Renderer for the block.
     *
     * @param Data $data
     *
     * @return string
     */
    public function render(Data $data): string
    {
        return view('editor.php::raw')
            ->with(compact('data'))
            ->render();
    }
}
