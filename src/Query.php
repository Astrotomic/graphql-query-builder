<?php

namespace Astrotomic\GraphqlQueryBuilder;

class Query
{
    protected string $from;
    protected array $arguments = [];
    protected array $fields = [];
    protected ?string $fragment = null;

    public function __construct(string $from)
    {
        $this->from = $from;
    }

    public static function from(string $from): self
    {
        return new static($from);
    }

    public static function for(string $fragment): self
    {
        return static::from('...')->fragment($fragment);
    }

    public function with(...$arguments): self
    {
        $arguments = is_array($arguments[0]) ? $arguments[0] : $arguments;

        $this->arguments = array_merge($this->arguments, $arguments);

        return $this;
    }

    public function select(string ...$fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function fragment(string $fragment): self
    {
        $this->fragment = $fragment;

        return $this;
    }

    public function __toString(): string
    {
        $select = implode(PHP_EOL, $this->fields);

        if($this->fragment !== null) {
            return <<<GRAPHQL
            {$this->from} on {$this->fragment} {
            {$select}
            }
            GRAPHQL;
        }

        if($this->arguments !== []) {
            $arguments = implode(', ', array_map(static function($value, string $key): string {
                return $key.': '.json_encode($value);
            }, array_values($this->arguments), array_keys($this->arguments)));

            return <<<GRAPHQL
            {$this->from}($arguments) {
            {$select}
            }
            GRAPHQL;
        }

        return <<<GRAPHQL
        {$this->from} {
        {$select}
        }
        GRAPHQL;
    }
}