<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Exceptions\EditorPhpException;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Parser
{
    /**
     * Registered blocks.
     *
     * @var array<string, string>
     */
    public static array $blocks = [
        'attaches' => \BumpCore\EditorPhp\Blocks\Attaches::class,
        'checklist' => \BumpCore\EditorPhp\Blocks\Checklist::class,
        'code' => \BumpCore\EditorPhp\Blocks\Code::class,
        'delimiter' => \BumpCore\EditorPhp\Blocks\Delimiter::class,
        'embed' => \BumpCore\EditorPhp\Blocks\Embed::class,
        'header' => \BumpCore\EditorPhp\Blocks\Header::class,
        'image' => \BumpCore\EditorPhp\Blocks\Image::class,
        'linkTool' => \BumpCore\EditorPhp\Blocks\LinkTool::class,
        'list' => \BumpCore\EditorPhp\Blocks\ListBlock::class,
        'paragraph' => \BumpCore\EditorPhp\Blocks\Paragraph::class,
        'personality' => \BumpCore\EditorPhp\Blocks\Personality::class,
        'quote' => \BumpCore\EditorPhp\Blocks\Quote::class,
        'raw' => \BumpCore\EditorPhp\Blocks\Raw::class,
        'table' => \BumpCore\EditorPhp\Blocks\Table::class,
        'warning' => \BumpCore\EditorPhp\Blocks\Warning::class,
    ];

    /**
     * Converted input JSON.
     *
     * @var array
     */
    protected array $input;

    /**
     * Constructor.
     *
     * @param string $input
     *
     * @return void
     */
    public function __construct(string $input)
    {
        $this->input = $this->handleInput($input);
    }

    /**
     * Registers new block.
     *
     * @param array<string, string> $blocks
     * @param bool $override
     *
     * @return void
     */
    public static function register(array $blocks, bool $override = false): void
    {
        if ($override)
        {
            static::$blocks = [];
        }

        foreach ($blocks as $type => $block)
        {
            if (!in_array(Block::class, class_parents($block)))
            {
                throw new EditorPhpException($block . ' must extend ' . Block::class);
            }

            static::$blocks[$type] = $block;
        }
    }

    /**
     * Returns the time of given `Editor.js` output.
     *
     * @return Carbon
     */
    public function time(): Carbon
    {
        return Carbon::parse(Arr::get($this->input, 'time') / 1000);
    }

    /**
     * Returns parsed blocks of given `Editor.js` output.
     *
     * @param EditorPhp|null $root
     *
     * @return Collection
     */
    public function blocks(?EditorPhp &$root = null): Collection
    {
        $blocks = new Collection();

        foreach (Arr::get($this->input, 'blocks') as $block)
        {
            $type = Arr::get($block, 'type');

            if (!key_exists($type, static::$blocks))
            {
                throw new EditorPhpException('Unknown block type: ' . $type);
            }

            $blocks->push(new (static::$blocks[$type])(Arr::get($block, 'data'), $root));
        }

        return $blocks;
    }

    /**
     * Returns the version of given `Editor.js` output.
     *
     * @return string
     */
    public function version(): string
    {
        return Arr::get($this->input, 'version');
    }

    /**
     * Parses given `Editor.js` output JSON.
     *
     * @param string $input
     *
     * @return array
     */
    protected function handleInput(string $input): array
    {
        if (!Str::isJson($input))
        {
            throw new EditorPhpException('Given Editor.js output is not a valid JSON.');
        }

        $input = json_decode($input, true);

        if (!$this->validateSchema($input))
        {
            throw new EditorPhpException('Given Editor.js output is not matching schema.');
        }

        return $input;
    }

    /**
     * Validates given `Editor.js` output.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validateSchema(array $input): bool
    {
        $validator = Helpers::makeValidator($input, [
            'time' => 'required|numeric',
            'blocks' => 'present|array',
            'blocks.*' => 'present|array',
            'blocks.*.type' => 'required|string',
            'blocks.*.data' => 'present|array',
            'version' => 'required|string',
        ]);

        return !$validator->fails();
    }
}
