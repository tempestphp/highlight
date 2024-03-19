<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use Tempest\Highlight\Pattern;

trait TestsPatterns
{
    public function assertMatches(
        Pattern $pattern,
        string $content,
        string|array|null $expected,
    ): void {
        $matches = $pattern->match($content);

        if (is_string($expected)) {
            $expected = [$expected];
        }

        if ($expected === null) {
            $this->assertCount(
                expectedCount: 0,
                haystack: $matches['match'],
                message: sprintf(
                    "Expected there to be no matches at all in %s, but there were: %s",
                    $pattern::class,
                    var_export($matches['match'], true),
                )
            );

            return;
        }

        foreach ($expected as $key => $expectedValue) {
            $this->assertSame(
                expected: $expectedValue,
                actual: $matches['match'][$key][0],
                message: sprintf(
                    "Pattern in %s did not match %s, found %s instead.",
                    $pattern::class,
                    var_export($expectedValue, true),
                    var_export($matches['match'][$key][0], true),
                ),
            );
        }
    }
}
