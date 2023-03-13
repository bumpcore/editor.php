<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Header extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array
    {
        return [
            'text' => [],
        ];
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
            'level' => 'integer|min:1|max:6',
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

    /**
     * Generates fake data for the block.
     *
     * @param Generator $faker
     *
     * @return array
     */
    public static function fake(\Faker\Generator $faker): array
    {
        return [
            'text' => $faker->text(64),
            'level' => $faker->numberBetween(1, 6),
        ];
    }
}
