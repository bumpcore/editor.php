<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ListBlock implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('style', ['string', Rule::in(['ordered', 'unordered'])]),
            Field::make('items', 'array'),
            Field::make('item.*', 'string'),
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
        if (View::getFacadeRoot())
        {
            return view('editor.php::list')
                ->with(compact('data'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/views/php/list.php', compact('data'));
    }
}
