<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Exceptions\EditorPhpException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Parser
{
    /**
     * Registered providers.
     *
     * @var array<string, Provider>
     */
    public static array $providers;

    /**
     * Converted input JSON.
     *
     * @var array
     */
    protected array $input;

    /**
     * Blocks.
     *
     * @var Collection
     */
    protected Collection $blocks;

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
     * Registers new block provider.
     *
     * @param array<int, string> $providers
     *
     * @return void
     */
    public static function register(array $providers): void
    {
        foreach ($providers as $provider)
        {
            if (!in_array(Provider::class, class_implements($provider)))
            {
                throw new EditorPhpException($provider . ' must implement ' . Provider::class);
            }

            /** @var Provider */
            $provider = new ($provider);

            static::$providers[static::resolveType($provider)] = $provider;
        }
    }

    /**
     * Resolves type from given provider or string.
     *
     * @param Provider|string $provider
     *
     * @return string
     */
    public static function resolveType(Provider|string $provider): string
    {
        if ($provider instanceof Provider && property_exists($provider, 'type'))
        {
            return strtolower($provider->type);
        }

        if ($provider instanceof Provider)
        {
            $provider = $provider::class;
        }

        return Str::of($provider)->classBasename()->remove('Block')->snake()->lower()->toString();
    }

    /**
     * Returns the time of given `Editor.js` output.
     *
     * @return int
     */
    public function time(): int
    {
        return Arr::get($this->input, 'time');
    }

    /**
     * Returns parsed blocks of given `Editor.js` output.
     *
     * @return Collection
     */
    public function blocks(): Collection
    {
        if (isset($this->blocks))
        {
            return $this->blocks;
        }

        $this->blocks = new Collection();

        foreach (Arr::get($this->input, 'blocks') as $block)
        {
            $type = static::resolveType(Arr::get($block, 'type'));

            if (!$this->providerExists($type))
            {
                throw new EditorPhpException('Unknown block type: ' . $type);
            }

            $this->blocks->push(new Block($type, Arr::get(static::$providers, $type), Arr::get($block, 'data')));
        }

        return $this->blocks();
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
     * Checks whether provider registered or not.
     *
     * @param string $type
     *
     * @return bool
     */
    protected function providerExists(string $type): bool
    {
        return key_exists($type, static::$providers);
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
