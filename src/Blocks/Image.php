<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Image extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array|string
    {
        return [
            'file.url' => [],
            'caption' => [],
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
            'file.url' => 'url',
            'caption' => 'string',
            'withBorder' => 'boolean',
            'stretched' => 'boolean',
            'withBackground' => 'boolean',
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
            return view(sprintf('editor.php::%s.image', EditorPhp::usingTemplate()))
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . sprintf('/../../resources/php/%s/image.php', EditorPhp::usingTemplate()), ['data' => $this->data]);
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
            'file' => ['url' => 'https://picsum.photos/200/300'],
            'caption' => $faker->text(),
            'withBorder' => $faker->boolean(),
            'stretched' => $faker->boolean(),
            'withBackground' => $faker->boolean(),
        ];
    }
}
