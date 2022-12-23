<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Contracts\Block;

class Checklist implements Block
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'embed';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'service' => 'string',
            'source' => 'url',
            'embed' => 'url',
            'width' => 'numeric',
            'height' => 'numeric',
            'caption' => 'string',
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
        return view('editor.php::embed')
            ->with(compact('data'))
            ->render();
    }
}
