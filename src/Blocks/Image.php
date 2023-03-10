<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Image extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array
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
            return view('editor.php::image')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/image.php', ['data' => $this->data]);
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
            'file' => ['url' => $faker->imageUrl()],
            'caption' => $faker->text(),
            'withBorder' => $faker->boolean(),
            'stretched' => $faker->boolean(),
            'withBackground' => $faker->boolean(),
        ];
    }
}
