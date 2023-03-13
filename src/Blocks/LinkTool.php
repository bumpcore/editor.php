<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class LinkTool extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array
    {
        return [
            'link' => [],
            'meta.title' => [],
            'meta.site_name' => [],
            'meta.description' => [],
            'meta.image.url' => [],
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
            'link' => 'url',
            'meta.title' => 'string',
            'meta.site_name' => 'string',
            'meta.description' => 'string',
            'meta.image.url' => 'url',
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
            return view('editor.php::linktool')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/linktool.php', ['data' => $this->data]);
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
            'link' => $faker->url(),
            'meta' => [
                'title' => $faker->text(32),
                'site_name' => $faker->text(32),
                'description' => $faker->text(96),
                'image' => ['url' => $faker->imageUrl()],
            ],
        ];
    }
}
