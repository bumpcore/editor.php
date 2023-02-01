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
     * @var array<string, Block>
     */
    public static array $blocks;

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
     * @param array<int, string> $blocks
     *
     * @return void
     */
    public static function register(array $blocks): void
    {
        foreach ($blocks as $block)
        {
            if (!in_array(Block::class, class_parents($block)))
            {
                throw new EditorPhpException($block . ' must extend ' . Block::class);
            }

            static::$blocks[static::resolveType($block)] = $block;
        }
    }

    /**
     * Resolves type from given block or string.
     *
     * @param Block|string $block
     *
     * @return string
     */
    public static function resolveType(Block|string $block): string
    {
        if ($block instanceof Block)
        {
            $block = $block::class;
        }

        return Str::of($block)->classBasename()->remove('Block')->snake()->lower()->toString();
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
            $type = static::resolveType(Arr::get($block, 'type'));

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
