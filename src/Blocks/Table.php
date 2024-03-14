<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Table extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'content.*.*' => [],
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
            'withHeadings' => 'boolean',
            'content' => 'array',
            'content.*' => 'array',
            'content.*.*' => 'string',
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
            return view("editor.php::{$template}.table")
                ->with($this->only('withHeadings', 'content'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/table.php", $this->only('withHeadings', 'content'));
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
