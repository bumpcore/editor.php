<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Embed extends Block
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('service', 'string'),
            Field::make('source', 'url'),
            Field::make('embed', 'url'),
            Field::make('width', 'numeric'),
            Field::make('height', 'numeric'),
            Field::make('caption', 'string'),
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
            return view('editor.php::embed')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/embed.php', ['data' => $this->data]);
    }
}
