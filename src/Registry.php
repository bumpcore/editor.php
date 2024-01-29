<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Exceptions\InvalidBlockException;
use BumpCore\EditorPhp\Exceptions\InvalidTemplateException;

class Registry
{
    /**
     * Registered template.
     *
     * @var string
     */
    protected static string $template = 'tailwind';

    /**
     * Registered blocks.
     *
     * @var array<string, class-string<Block>>
     */
    protected static array $blocks = [
        'attaches' => Blocks\Attaches::class,
        'checklist' => Blocks\Checklist::class,
        'code' => Blocks\Code::class,
        'delimiter' => Blocks\Delimiter::class,
        'embed' => Blocks\Embed::class,
        'header' => Blocks\Header::class,
        'image' => Blocks\Image::class,
        'linkTool' => Blocks\LinkTool::class,
        'list' => Blocks\ListBlock::class,
        'paragraph' => Blocks\Paragraph::class,
        'personality' => Blocks\Personality::class,
        'quote' => Blocks\Quote::class,
        'raw' => Blocks\Raw::class,
        'table' => Blocks\Table::class,
        'warning' => Blocks\Warning::class,
    ];

    /**
     * Get current template.
     *
     * @return string
     */
    public static function getTemplate(): string
    {
        return static::$template;
    }

    /**
     * Set current template.
     *
     * @param string $template
     *
     * @return void
     */
    public static function setTemplate(string $template): void
    {
        if (!in_array($template, ['tailwind', 'bootstrap-five']))
        {
            throw new InvalidTemplateException("Invalid template: {$template}, available templates: tailwind, bootstrap-five");
        }

        static::$template = $template;
    }

    /**
     * Get registered blocks.
     *
     * @return array<string, class-string<Block>>
     */
    public static function getBlocks(): array
    {
        return static::$blocks;
    }

    /**
     * Returns the block class by given type.
     *
     * @param string $type
     *
     * @return class-string<Block>|null
     */
    public static function getBlockByType(string $type): ?string
    {
        return static::$blocks[$type];
    }

    /**
     * Returns the block type by given class.
     *
     * @param string $class
     *
     * @return string|null
     */
    public static function getBlockTypeByClass(string $class): ?string
    {
        return array_flip(static::$blocks)[$class];
    }

    /**
     * Return only fakeable blocks.
     *
     * @return array<string, class-string<Block&Fakeable>>
     */
    public static function getFakeableBlocks(): array
    {
        return array_filter(static::getBlocks(), fn (string $block) => is_subclass_of($block, Fakeable::class));
    }

    /**
     * Register new block.
     *
     * @param string $name
     * @param class-string<Block> $class
     *
     * @return void
     */
    public static function registerBlock(string $name, string $class): void
    {
        if (!is_subclass_of($class, Block::class))
        {
            throw new InvalidBlockException("Invalid block: {$class}, block must be a subclass of " . Block::class);
        }

        static::$blocks[$name] = $class;
    }

    /**
     * Register new blocks.
     *
     * @param array<string, class-string<Block>> $blocks
     * @param bool $override
     *
     * @return void
     */
    public static function registerBlocks(array $blocks, bool $override = false): void
    {
        if ($override)
        {
            static::$blocks = [];
        }

        foreach ($blocks as $name => $class)
        {
            static::registerBlock($name, $class);
        }
    }

    /**
     * Check if given block exists.
     *
     * @param string $type
     *
     * @return bool
     */
    public static function hasBlockType(string $type): bool
    {
        return isset(static::$blocks[$type]);
    }
}
