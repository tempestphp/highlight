<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Patterns\Php;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Patterns\Php\NamespacePattern;
use Tempest\Highlight\Tests\Patterns\TestsPatterns;

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
