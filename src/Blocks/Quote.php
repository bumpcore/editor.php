<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\BlockData;
use BumpCore\EditorPhp\Contracts\Provider;
use Illuminate\Validation\Rule;

class Quote implements Provider
{
    /**
     * Type of the block.
     *
     * @return string
     */
    public function type(): string
    {
        return 'quote';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
			'text' => 'string',
			'caption' => 'string',
			'alignment' => ['string', Rule::in(['left', 'center'])]
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
        return view('editor.php::quote')
            ->with(compact('data'))
            ->render();
    }
}
