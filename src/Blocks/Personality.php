<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Personality extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'name' => [],
            'description' => [],
            'link' => [],
            'photo' => [],
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
            'name' => 'string',
            'description' => 'string',
            'link' => 'url',
            'photo' => 'url',
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
            return view("editor.php::{$template}.personality")
                ->with($this->only('name', 'description', 'link', 'photo'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/personality.php", $this->only('name', 'description', 'link', 'photo'));
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
            'name' => $faker->name(),
            'description' => $faker->text(),
            'link' => $faker->url(),
            'photo' => $faker->imageUrl(),
        ];
    }
}
