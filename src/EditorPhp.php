<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Block\Block;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;

class EditorPhp implements Arrayable, Jsonable, Responsable
{
    protected Parser $parser;

    /**
     * @var Collection<int, Block>
     */
    public Collection $blocks;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->blocks = new Collection();
    }

    /**
     * Registers new providers for the blocks.
     *
     * @param array $providers
     *
     * @return void
     */
    public function register(array $providers): void
    {
        Parser::register($providers);
    }

    /**
     * Parses the given output.
     *
     * @param string $output Json output of the Editor.js
     *
     * @return EditorPhp
     */
    public function load(string $output): self
    {
        $this->parser = new Parser($output);
        $this->blocks = $this->parser->blocks();

        return $this;
    }

    /**
     * Converts the `Editor.php` as an array.
     *
     * @return array<string, array|int|string>
     */
    public function toArray(): array
    {
        return [
            'time' => $this->parser->time(),
            'blocks' => $this->blocks->toArray(),
            'version' => $this->parser->version(),
        ];
    }

    /**
     * Converts the `Editor.php` to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Renders blocks into HTML.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Creates an HTTP response that represents the `Editor.php`.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->expectsJson() ? response($this->toArray()) : response($this->render());
    }

    /**
     * Renders blocks into HTML.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->blocks
            ->map(fn (Block $block) => $block->render())
            ->implode('');
    }
}
