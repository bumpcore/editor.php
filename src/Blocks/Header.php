<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Header extends Block
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
            Field::make('level', 'integer|min:1|max:6'),
        ];
    }

    /**
     * Renderer for the block.
     *
     * @return string
     */
    public function render(): string
    {
        if (View::getFacadeRoot())
        {
            return view('editor.php::header')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/header.php', ['data' => $this->data]);
    }
}
