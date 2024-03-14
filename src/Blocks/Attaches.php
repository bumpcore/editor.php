<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Attaches extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'title' => [],
            'file.url' => [],
            'file.name' => [],
            'file.extension' => [],
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
            'file.url' => 'url',
            'file.size' => 'numeric',
            'file.name' => 'string',
            'file.extension' => 'string',
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
            return view("editor.php::{$template}.attaches")
                ->with($this->only('title', 'file'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/attaches.php", $this->only('title', 'file'));
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
            'title' => $faker->text(64),
            'file' => [
                'url' => $faker->url(),
                'size' => $faker->numberBetween(250000, 10000000),
                'name' => $faker->text(64),
                'extension' => $faker->fileExtension(),
            ],
        ];
    }
}
