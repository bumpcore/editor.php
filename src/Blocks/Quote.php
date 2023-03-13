<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class Quote extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array
    {
        return [
            'text' => [],
            'caption' => [],
            'alignment' => [],
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
            'text' => 'string',
            'caption' => 'string',
            'alignment' => ['string', Rule::in(['left', 'center'])],
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
            return view('editor.php::quote')
                ->with(['data' => $this->data])
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/quote.php', ['data' => $this->data]);
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
            'text' => $faker->text(),
            'caption' => $faker->name(),
            'alignment' => $faker->randomElement(['left', 'center']),
        ];
    }
}
