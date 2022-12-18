<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\BlockData;
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
        return 'checklist';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'items' => 'array',
            'items.*' => 'array',
			'items.*.text' => 'string',
			'items.*.checked' => 'boolean',
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
        return view('editor.php::checklist')
            ->with(compact('data'))
            ->render();
    }
}
