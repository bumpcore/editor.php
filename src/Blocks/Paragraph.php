<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Paragraph extends Block
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('text', 'string')
                ->allow('mark')
                ->allow('b')
                ->allow('strong')
                ->allow('code')
                ->allow('a', 'href'),
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
            return view('editor.php::paragraph')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/paragraph.php', ['data' => $this->data]);
    }

    /**
     * Generates fake data for the block.
     *
     * @param Generator $faker
     *
     * @return array
     */
    public static function fake(\Faker\Generator $faker): array
    {
        return ['text' => $faker->text(256)];
    }
}
