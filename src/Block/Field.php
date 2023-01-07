<?php

namespace BumpCore\EditorPhp\Block;

class Field
{
    /**
     * Name of the field.
     *
     * @var string
     */
    protected string $name;

    /**
     * Rules to apply field.
     *
     * @var array<string, array|string>|string
     */
    protected string|array $rules;

    /**
     * Tag and attribute list to escape purifing.
     *
     * @var array<string, array>
     */
    protected array $allow;

    /**
     * Creates new `Field` instance.
     *
     * @param string $name
     * @param array<string, array|string>|string $rules
     *
     * @return Field
     */
    public static function make(string $name = '', string|array $rules = ''): self
    {
        return new static($name, $rules);
    }

    /**
     * Constructor.
     *
     * @param string $name
     * @param array<string, array|string>|string $rules
     *
     * @return void
     */
    public function __construct(string $name = '', string|array $rules = '')
    {
        $this->name = $name;
        $this->rules = $rules;
        $this->allow = [];
    }

    /**
     * Sets name of the field.
     *
     * @param string $name
     *
     * @return Field
     */
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets rules of the field.
     *
     * @param array<string, array|string>|string $rules
     *
     * @return Field
     */
    public function rules(string|array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Sets allowed tag and attributes of the field.
     *
     * @param string $allow
     * @param string $attributes
     *
     * @return Field
     */
    public function allow(string $allow, string $attributes = ''): self
    {
        if (!isset($this->allow[$allow]))
        {
            $this->allow[$allow] = [];
        }

        array_push($this->allow[$allow], ...explode('|', $attributes));

        return $this;
    }

    /**
     * Returns `Field`'s name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns `Field`'s rules.
     *
     * @return array<string, array|string>|string
     */
    public function getRules(): array|string
    {
        return $this->rules;
    }

    /**
     * Returns `Field`'s allowed tags & attributes.
     *
     * @return array<string, array>
     */
    public function getAllow(): array
    {
        return $this->allow;
    }
}
