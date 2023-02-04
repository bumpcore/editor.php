<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Table extends Block
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('withHeadings', 'boolean'),
            Field::make('content', 'array'),
            Field::make('content.*', 'array'),
            Field::make('content.*.*', 'string'),
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
            return view('editor.php::table')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/table.php', ['data' => $this->data]);
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
        $content = [];
        $width = $faker->numberBetween(2, 8);

        foreach (range(0, $faker->numberBetween(1, 10)) as $index)
        {
            $row = [];

            foreach (range(0, $width) as $index)
            {
                $row[] = $faker->text(64);
            }

            $content[] = $row;
        }

        return [
            'withHeadings' => $faker->boolean(),
            'content' => $content,
        ];
    }
}
