<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Checklist extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array|string
    {
        return [
            'items.*.text' => [],
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
            'items' => 'array',
            'items.*' => 'array',
            'items.*.text' => 'string',
            'items.*.checked' => 'boolean',
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
            return view('editor.php::checklist')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/checklist.php', ['data' => $this->data]);
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
        $items = [];

        foreach (range(0, $faker->numberBetween(1, 10)) as $index)
        {
            $items[] = [
                'text' => $faker->text(48),
                'checked' => $faker->boolean(),
            ];
        }

        return ['items' => $items];
    }
}
