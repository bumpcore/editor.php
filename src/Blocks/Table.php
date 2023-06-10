<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Table extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array|string
     */
    public function allows(): array|string
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
        if (View::getFacadeRoot())
        {
            return view(sprintf('editor.php::%s.table', EditorPhp::usingTemplate()))
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . sprintf('/../../resources/php/%s/table.php', EditorPhp::usingTemplate()), ['data' => $this->data]);
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
