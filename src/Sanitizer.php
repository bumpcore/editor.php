<?php

namespace BumpCore\EditorPhp;

use Illuminate\Support\Arr;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\Reference\W3CReference;

/**
 * Class Sanitizer.
 *
 * This class is responsible for sanitizing data based on specified rules.
 */
class Sanitizer
{
    /**
     * Data to be sanitized.
     *
     * @var array
     */
    protected array $data;

    /**
     * Rules to apply for sanitization.
     *
     * @var array|string
     */
    protected array|string $rules;

    /**
     * Default HtmlSanitizerConfig.
     *
     * @var HtmlSanitizerConfig
     */
    protected HtmlSanitizerConfig $defaultHtmlSanitizerConfig;

    /**
     * Sanitizer constructor.
     *
     * @param array $data The data to be sanitized.
     * @param array|string $rules The rules to apply for sanitization.
     */
    public function __construct(array $data, array|string $rules)
    {
        $this->data = $data;
        $this->rules = is_string($rules) ? $rules : $this->parseRules($rules);
        $this->defaultHtmlSanitizerConfig = $this->getDefaultHtmlSanitizerConfig();
    }

    /**
     * Sanitize the data based on the specified rules.
     *
     * @return array The sanitized data.
     */
    public function sanitize(): array
    {
        if ($this->rules === '*')
        {
            return $this->data;
        }

        $data = Arr::dot($this->data);

        foreach ($data as $key => $value)
        {
            $rule = $this->getRuleFor($key);

            if ($rule === '*' || !is_string($value))
            {
                continue;
            }

            $data[$key] = $this->sanitizeValue($value, $rule);
        }

        return Arr::undot($data);
    }

    /**
     * Sanitize a single value based on the specified rule.
     *
     * @param string $value The value to be sanitized.
     * @param array $rule The rule to apply for sanitization.
     *
     * @return string The sanitized value.
     */
    protected function sanitizeValue(string $value, array $rule): string
    {
        return (new HtmlSanitizer($this->getHtmlSanitizerConfig($rule)))->sanitize($value);
    }

    /**
     * Get the HtmlSanitizerConfig based on the specified rule.
     *
     * @param array $rule The rule to apply for sanitization.
     *
     * @return HtmlSanitizerConfig The HtmlSanitizerConfig object.
     */
    protected function getHtmlSanitizerConfig(array $rule): HtmlSanitizerConfig
    {
        $config = $this->defaultHtmlSanitizerConfig;

        foreach ($rule as $tag => $attributes)
        {
            $config = $config->allowElement($tag, $attributes);
        }

        return $config;
    }

    /**
     * Get the default HtmlSanitizerConfig.
     *
     * @return HtmlSanitizerConfig The default HtmlSanitizerConfig object.
     */
    protected function getDefaultHtmlSanitizerConfig(): HtmlSanitizerConfig
    {
        $config = new HtmlSanitizerConfig();

        foreach (W3CReference::BODY_ELEMENTS as $element => $safe)
        {
            $config = $config->blockElement($element);
        }

        return $config;
    }

    /**
     * Get the rule for the specified key.
     *
     * @param string $key The key to get the rule for.
     *
     * @return array|string The rule for the specified key.
     */
    protected function getRuleFor(string $key): array|string
    {
        // Find matching key E.g. `content*.*.text` = `content.1.5.text`
        return Arr::first(
            array: $this->rules,
            // Below regex taken from `https://github.com/laravel/framework/blob/46ac3ec77ed4b07e3c6e47f97979822696bb7f1d/src/Illuminate/Validation/ValidationData.php#L57`
            callback: fn ($tags, $ruleKey) => (bool) preg_match('/^' . str_replace('\*', '[^\.]+', preg_quote($ruleKey)) . '/', $key, $matches),
            default: []
        );
    }

    /**
     * Parse the rules array.
     *
     * @param array $rules The rules to parse.
     *
     * @return array The parsed rules.
     */
    protected function parseRules(array $rules): array
    {
        $parsed = [];

        foreach ($rules as $key => $rule)
        {
            if ($rule === '*')
            {
                $parsed[$key] = '*';
                continue;
            }

            if (empty($rule))
            {
                $parsed[$key] = [];
                continue;
            }

            $parsed[$key] = $this->parseRule($rule);
        }

        return $parsed;
    }

    /**
     * Parse a single rule.
     *
     * @param array|string $rule The rule to parse.
     *
     * @return array|string The parsed rule.
     */
    protected function parseRule(string|array $rule): array|string
    {
        $parsed = [];

        foreach (Arr::wrap($rule) as $element)
        {
            $element = explode(':', $element);

            // First key is tag.
            $tag = Arr::first(array_slice($element, 0, 1));

            // Second key is attributes.
            $attributes = array_filter(explode(',', Arr::first(array_slice($element, 1, 2), null, '')));

            $parsed[$tag] = $attributes === ['*'] ? '*' : $attributes;
        }

        return $parsed;
    }
}
