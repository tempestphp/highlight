<?php

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;

final class PatternsTest extends TestCase
{
    use TestsPatterns;

    #[Test]
    public function test_patterns_with_attribute() 
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

//            if ($attributes === []) {
//                $this->fail("No #[PatternTest] attribute found on {$reflectionClass->getName()}");
//            }

            foreach ($attributes as $attribute) {
                /** @var PatternTest $patternTest */
                $patternTest = $attribute->newInstance();

                $this->assertMatches(
                    pattern: $reflectionClass->newInstance(),
                    content: htmlentities($patternTest->input),
                    expected: $patternTest->output,
                );
            }
        }
    }
}