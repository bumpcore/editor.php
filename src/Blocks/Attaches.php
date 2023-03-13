<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Attaches extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array|string
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
        if (View::getFacadeRoot())
        {
            return view('editor.php::attaches')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/attaches.php', ['data' => $this->data]);
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
