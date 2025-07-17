<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;

final class PatternsTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    #[DataProvider('provide_patterns_with_attribute_cases')]
    public function test_patterns_with_attribute(Pattern $pattern, PatternTest $patternTest)
    {
        $this->assertMatches(
            pattern: $pattern,
            content: $patternTest->input,
            expected: $patternTest->output,
        );
    }

    public static function provide_patterns_with_attribute_cases(): iterable
    {
        $patternFiles = glob(__DIR__ . '/../src/Languages/*/Patterns/**.php');

        foreach ($patternFiles as $patternFile) {
            $className = str_replace(
                search: [__DIR__ . '/../src/', '/', '.php'],
                replace: ['Tempest\\Highlight\\', '\\', ''],
                subject: $patternFile,
            );

            $reflectionClass = new ReflectionClass($className);

            $attributes = $reflectionClass->getAttributes(PatternTest::class);

            foreach ($attributes as $attribute) {
                /** @var PatternTest $patternTest */
                $patternTest = $attribute->newInstance();

                yield [$reflectionClass->newInstance(), $patternTest];
            }
        }
    }
}
