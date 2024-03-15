<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use Tempest\Highlight\Pattern;

trait TestsPatterns
{
    public function assertMatches(
        Pattern $pattern,
        string $content,
        string|array $expected,
    ): void {
        $matches = $pattern->match($content);

        if (is_string($expected)) {
            $expected = [$expected];
        }

        foreach ($expected as $key => $expectedValue) {
            $this->assertSame($expectedValue, $matches['match'][$key][0]);
        }
    }
}
