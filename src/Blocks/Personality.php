<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Personality extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array
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
        if (View::getFacadeRoot())
        {
            return view('editor.php::personality')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/personality.php', ['data' => $this->data]);
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
            'name' => $faker->name(),
            'description' => $faker->text(),
            'link' => $faker->url(),
            'photo' => $faker->imageUrl(),
        ];
    }
}
