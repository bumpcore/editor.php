<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\BlockData;
use BumpCore\EditorPhp\Contracts\Provider;

class Table implements Provider
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'table';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'withHeadings' => 'boolean',
            'content' => 'array',
			'content.*' => 'array',
            'content.*.*' => 'string',
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
		
        return view('editor.php::table')
            ->with(compact('data'))
            ->render();
    }
}
