<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Embed extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'service' => [],
            'source' => [],
            'embed' => [],
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
            'service' => 'string',
            'source' => 'url',
            'embed' => 'url',
            'width' => 'numeric',
            'height' => 'numeric',
            'caption' => 'string',
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
            return view("editor.php::{$template}.embed")
                ->with($this->only('service', 'source', 'embed', 'width', 'height', 'caption'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/embed.php", $this->only('service', 'source', 'embed', 'width', 'height', 'caption'));
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
            'service' => $faker->text(32),
            'source' => $faker->url(),
            'embed' => $faker->url(),
            'width' => $faker->numberBetween(64, 1024),
            'height' => $faker->numberBetween(64, 1024),
            'caption' => $faker->text(32),
        ];
    }
}
