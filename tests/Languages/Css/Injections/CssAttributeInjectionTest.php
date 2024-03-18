<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Css\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Css\Injections\CssAttributeInjection;
use Tempest\Highlight\Tests\TestsInjections;

class CssAttributeInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $this->assertMatches(
            injection: new CssAttributeInjection(),
            content: '<x-slot style="color: green">',
            expected: '&lt;x-slot style=&quot;<span class="hl-property">color</span>: green&quot;&gt;'
        );
    }
}
