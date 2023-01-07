<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;
use Illuminate\Validation\Rule;

class Quote implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('text', 'string'),
            Field::make('caption', 'string'),
            Field::make('alignment', ['string', Rule::in(['left', 'center'])]),
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
        return view('editor.php::quote')
            ->with(compact('data'))
            ->render();
    }
}
