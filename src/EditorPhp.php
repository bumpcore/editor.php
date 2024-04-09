<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Contracts\Fakeable;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

/**
 * Class EditorPhp.
 *
 * This class is the main class of the EditorPhp.
 * It represents the `Editor.js` data as an object and provides functionality to interact and manipulate it.
 *
 * @property Carbon $time
 * @property string|null $version
 * @property \Illuminate\Database\Eloquent\Model|null $model
 */
class EditorPhp implements Arrayable, Jsonable, Responsable, Renderable, Htmlable
{
    use Macroable;

    /**
     * @var Collection<int, Block>
     */
    public Collection $blocks;

    /**
     * Attributes of the EditorPhp; time, version, model etc.
     *
     * @var array
     */
    protected array $attributes = [];

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
     * @param string|null $input The input data.
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
     * Returns given property.
     *
     * @param string $name The name of the property.
     *
     * @return mixed The value of the property.
     */
    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Checks if given property exists.
     *
     * @param string $name The name of the property.
     *
     * @return bool True if property exists, false otherwise.
     */
    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Sets given property.
     *
     * @param string $name The name of the property.
     * @param mixed $value The value of the property.
     *
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Unsets given property.
     *
     * @param string $name The name of the property.
     *
     * @return void
     */
    public function __unset(string $name): void
    {
        unset($this->attributes[$name]);
    }

    /**
     * Renders with `Bootstrap 5` templates.
     *
     * @return void
     */
    public static function useBootstrapFive(): void
    {
        Registry::setTemplate('bootstrap-five');
    }

    /**
     * Renders with `tailwindcss` templates.
     *
     * @return void
     */
    public static function useTailwind(): void
    {
        Registry::setTemplate('tailwind');
    }

    /**
     * Registers new block.
     *
     * @param array<string, class-string<Block>> $blocks The blocks to register.
     * @param bool $override Whether to override existing blocks or not.
     *
     * @return void
     */
    public static function register(array $blocks, bool $override = false): void
    {
        Registry::registerBlocks($blocks, $override);
    }

    /**
     * Converts the `Editor.php` as an array.
     *
     * @return array<string, array|int|string> Array representation of the `Editor.php`.
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
     * @param int $options JSON options.
     *
     * @return string JSON representation of the `Editor.php`. Can be used to load either `Editor.php` or `Editor.js`.
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Creates an HTTP response that represents the `Editor.php`.
     *
     * @param \Illuminate\Http\Request $request The request.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response.
     */
    public function toResponse($request)
    {
        return $request->expectsJson() ? response($this->toArray()) : response($this->render());
    }

    /**
     * Renders blocks into HTML.
     *
     * @return string Rendered HTML.
     */
    public function render(): string
    {
        return $this->blocks
            ->map(fn (Block $block) => $block->render())
            ->implode('');
    }

    /**
     * Renders blocks into HTML.
     *
     * @return string Rendered HTML.
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * Renders blocks into HTML.
     *
     * @return string Rendered HTML.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Generates fake instance.
     *
     * @param bool $instance Whether to return instance or not.
     * @param int $minLength The minimum number of blocks.
     * @param int $maxLength The maximum number of blocks.
     *
     * @return EditorPhp|string The fake instance or JSON representation of it.
     */
    public static function fake(bool $instance = false, int $minLength = 8, int $maxLength = 30): EditorPhp|string
    {
        $faker = \Faker\Factory::create();
        $blocks = Registry::getFakeableBlocks();
        $generatedBlocks = [];

        foreach (range(0, $faker->numberBetween($minLength, $maxLength)) as $index)
        {
            /**
             * @var class-string<Block&Fakeable>
             */
            $block = $faker->randomElement($blocks);

            $generatedBlocks[] = (new ($block)($block::fake($faker)))->toArray();
        }

        $generated = json_encode([
            'time' => (int) Carbon::now()->getPreciseTimestamp(3),
            'blocks' => $generatedBlocks,
            'version' => $faker->semver(),
        ]);

        return $instance ? static::make($generated) : $generated;
    }
}
