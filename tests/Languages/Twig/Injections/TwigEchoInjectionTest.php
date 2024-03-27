<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Injections\TwigEchoInjection;
use Tempest\Highlight\Tests\TestsInjections;

class TwigEchoInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '<b>Version</b> {{ appVersion }}';

        $expected = '&lt;b&gt;Version&lt;/b&gt; {{ appVersion }}';

        $this->assertMatches(
            injection: new TwigEchoInjection(),
            content: $content,
            expectedContent: $expected,
        );
    }
}
