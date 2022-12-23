<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Contracts\Block;

class LinkTool implements Block
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'linktool';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'link' => 'url',
			'meta.title' => 'string',
			'meta.site_name' => 'string',
			'meta.description' => 'string',
			'meta.image.url' => 'url'
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
        return view('editor.php::linktool')
            ->with(compact('data'))
            ->render();
    }
}
