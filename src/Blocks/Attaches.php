<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Helpers;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class Attaches extends Block
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('title', 'string'),
            Field::make('file.url', 'url'),
            Field::make('file.size', 'numeric'),
            Field::make('file.name', 'string'),
            Field::make('file.extension', 'string'),
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
    public static function fake(Generator $faker): array
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
