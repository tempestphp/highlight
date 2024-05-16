<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersEchoInjection;
use Tempest\Highlight\Tests\TestsInjections;

class AntlersEchoInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $this->assertMatches(
            injection: new AntlersEchoInjection(),
            content: '{{$ count($foo) $}}',
            expectedContent: '{{$ <span class="hl-property">count</span>(<span class="hl-variable">$foo</span>) $}}',
        );
    }
}
