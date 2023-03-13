<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Block;

class Raw extends Block
{
    /**
     * Tag allow list for purifying data.
     *
     * @return array<array<string, string>|string>|string
     */
    public function allows(): array
    {
        return [
            'html' => '*',
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
            'html' => 'string',
        ];
    }

    /**
     * Renderer for the block.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->data->get('html', '');
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
        return ['html' => $faker->randomHtml()];
    }
}
