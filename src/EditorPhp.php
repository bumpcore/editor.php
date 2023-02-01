<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Block\Block;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EditorPhp implements Arrayable, Jsonable, Responsable
{
    /**
     * @var Carbon
     */
    public readonly Carbon $time;

    /**
     * @var Collection<int, Block>
     */
    public Collection $blocks;

    /**
     * @var string
     */
    public readonly ?string $version;

    /**
     * Belonging model, if casted.
     *
     * @var Model
     */
    public readonly Model $model;

    /**
     * Fluent method to create new `EditorPhp` instance.
     *
     * @param string|null $input
     *
     * @return EditorPhp
     */
    public static function make(?string $input = null): self
    {
        return new static($input);
    }

    /**
     * Constructor.
     *
     * @param string|null $input
     *
     * @return void
     */
    public function __construct(?string $input = null)
    {
        if (empty($input))
        {
            $this->time = Carbon::now();
            $this->blocks = new Collection();
            $this->version = null;
        }
        else
        {
            $parser = new Parser($input);
            $this->time = $parser->time();
            $this->blocks = $parser->blocks($this);
            $this->version = $parser->version();
        }
    }

    /**
     * Registers new block.
     *
     * @param array<int, string> $blocks
     * @param bool $override
     *
     * @return void
     */
    public static function register(array $blocks, bool $override = false): void
    {
        Parser::register($blocks, $override);
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
            'time' => (int) $this->time->getPreciseTimestamp(3),
            'blocks' => $this->blocks->toArray(),
            'version' => $this->version,
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
