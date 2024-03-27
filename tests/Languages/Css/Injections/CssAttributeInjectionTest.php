<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Css\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Injections\CssAttributeInHtmlInjection;
use Tempest\Highlight\Tests\TestsInjections;

class CssAttributeInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $this->assertMatches(
            injection: new CssAttributeInHtmlInjection(),
            content: '<x-slot style="color: green">',
            expectedContent: '&lt;x-slot style=&quot;<span class="hl-property">color</span>: green&quot;&gt;'
        );
    }
}
