<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Embed extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array|string
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
        if (View::getFacadeRoot())
        {
            return view('editor.php::embed')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/embed.php', ['data' => $this->data]);
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
            'service' => $faker->text(32),
            'source' => $faker->url(),
            'embed' => $faker->url(),
            'width' => $faker->numberBetween(64, 1024),
            'height' => $faker->numberBetween(64, 1024),
            'caption' => $faker->text(32),
        ];
    }
}
