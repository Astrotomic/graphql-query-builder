<?php

use Pest\Expectation;
use PHPUnit\Framework\Assert;
use function Spatie\Snapshots\assertMatchesSnapshot;

expect()->extend('toBeStringable', function(): Expectation {
    /** @var Expectation $this */
    Assert::assertIsString((string) $this->value);

    return $this;
});

expect()->extend('toMatchSnapshot', function(): Expectation {
    /** @var Expectation $this */
    assertMatchesSnapshot((string) $this->value);

    return $this;
});