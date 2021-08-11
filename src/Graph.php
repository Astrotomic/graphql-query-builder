<?php

namespace Astrotomic\GraphqlQueryBuilder;

class Graph
{
    /** @var \Astrotomic\GraphqlQueryBuilder\Query[] */
    protected array $queries;

    public function __construct(Query ...$queries)
    {
        $this->queries = $queries;
    }

    public static function query(Query ...$queries): self
    {
        return new static(...$queries);
    }

    public function __toString(): string
    {
        $select = implode(PHP_EOL, $this->queries);

        return <<<GRAPHQL
        query {
        {$select}
        }
        GRAPHQL;
    }
}