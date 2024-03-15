<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Patterns\NamespacePattern;
use Tempest\Highlight\Tests\TestsPatterns;

class NamespacePatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new NamespacePattern(),
            content: 'namespace Foo\Bar',
            expected: 'Foo\Bar',
        );
    }
}
