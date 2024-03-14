<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ListBlock extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'style' => [],
            'item.*' => [],
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
            'style' => ['string', Rule::in(['ordered', 'unordered'])],
            'items' => 'array',
            'item.*' => 'string',
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
            return view("editor.php::{$template}.list")
                ->with($this->only('style', 'items'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/list.php", $this->only('style', 'items'));
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
        $items = [];

        foreach (range(0, $faker->numberBetween(1, 10)) as $index)
        {
            $items[] = $faker->text(64);
        }

        return [
            'style' => $faker->randomElement(['ordered', 'unordered']),
            'items' => $items,
        ];
    }
}
