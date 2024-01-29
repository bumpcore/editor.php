<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class LinkTool extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
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
        $template = Registry::getTemplate();

        if (View::getFacadeRoot())
        {
            return view("editor.php::{$template}.linktool")
                ->with($this->only('link', 'meta'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/linktool.php", $this->only('link', 'meta'));
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
