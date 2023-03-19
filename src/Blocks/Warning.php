<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Warning extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array|string
    {
        return [
            'title' => [],
            'message' => [],
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
            'title' => 'string',
            'message' => 'string',
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
            return view(sprintf('editor.php::%s.warning', EditorPhp::usingTemplate()))
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . sprintf('/../../resources/php/%s/warning.php', EditorPhp::usingTemplate()), ['data' => $this->data]);
    }

    /**
     * Generates fake data for the block.
     *
     * @param \Faker\Generator $faker
     *
     * @return array
     */
    public static function fake(\Faker\Generator $faker): array
    {
        return [
            'title' => $faker->text(32),
            'message' => $faker->text(),
        ];
    }
}
