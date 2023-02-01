<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Block\Block;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EditorPhp implements Arrayable, Jsonable, Responsable
{
    /**
     * @var Parser
     */
    protected Parser $parser;

    /**
     * @var Collection<int, Block>
     */
    public Collection $blocks;

    /**
     * Belonging model, if casted.
     *
     * @var Model
     */
    public readonly Model $model;

    /**
     * Fluent method to create new `EditorPhp` instance.
     *
     * @param string $input
     *
     * @return EditorPhp
     */
    public static function make(string $input): self
    {
        return new static($input);
    }

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $input)
    {
        $this->parser = new Parser($input);
        $this->blocks = $this->parser->blocks($this);
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
        Parser::register($blocks);
    }

    /**
     * Sets model to be used with casting.
     *
     * @param Model $model
     *
     * @return EditorPhp
     */
    public function setModel(Model &$model): self
    {
        if (!isset($this->model))
        {
            $this->model = $model;
        }

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
