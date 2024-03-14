<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Image extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
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
        $template = Registry::getTemplate();

        if (View::getFacadeRoot())
        {
            return view("editor.php::{$template}.image")
                ->with($this->only('file', 'caption', 'withBorder', 'stretched', 'withBackground'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/image.php", $this->only('file', 'caption', 'withBorder', 'stretched', 'withBackground'));
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
            'file' => ['url' => $faker->imageUrl()],
            'caption' => $faker->text(),
            'withBorder' => $faker->boolean(),
            'stretched' => $faker->boolean(),
            'withBackground' => $faker->boolean(),
        ];
    }
}
