<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Blade\Injections\BladeEchoInjection;
use Tempest\Highlight\Tests\TestsInjections;

class BladeEchoInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $this->assertMatches(
            injection: new BladeEchoInjection(),
            content: '{{ count($foo) }}',
            expectedContent: '{{ <span class="hl-property">count</span>(<span class="hl-variable">$foo</span>) }}',
        );
    }
}
